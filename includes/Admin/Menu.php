<?php
namespace Hasinur\LoginActivityTracker\Admin;

use Hasinur\LoginActivityTracker\Core\Interfaces\HookableInterface;

/**
 * Admin menu class.
 *
 * @since 1.0.0
 */
class Menu implements HookableInterface {

    /**
     * Menu page title.
     *
     * @var string
     */
    protected $page_title;

    /**
     * Menu page title.
     *
     * @var string
     */
    protected $menu_title;

    /**
     * Menu page base capability.
     *
     * @var string
     */
    protected $base_capability;

    /**
     * Menu page base capability.
     *
     * @var string
     */
    protected $capability;

    /**
     * Menu page slug.
     *
     * @var string
     */
    protected $menu_slug;

    /**
     * Menu page icon url.
     *
     * @var string
     */
    protected $icon;

    /**
     * Menu page position.
     *
     * @var int
     */
    protected $position;

    /**
     * Submenu pages.
     *
     * @var array
     */
    protected $submenus;

    /**
     * Constructor.
     *
     * @since 1.0.0
     */
    public function __construct() {

        $this->page_title      = __( 'Login Activity Tracker', 'login-activity-tracker' );
        $this->menu_title      = __( 'Login Activity Tracker', 'login-activity-tracker' );
        $this->base_capability = 'read';
        $this->capability      = 'manage_options';
        $this->menu_slug       = 'login-activity-tracker';
        $this->icon            = 'dashicons-phone';
        $this->position        = 57;
        $this->submenus        = [];
    }

    /**
     * Registers all hooks for the class.
     *
     * @return void
     */
    public function register_hooks(): void {
        add_action( 'admin_menu', [ $this, 'register_menu' ] );
    }

    /**
     * Register admin menu.
     *
     * @since  1.0.0
     *
     * @return void
     */
    public function register_menu(): void {
        global $submenu;

        add_menu_page(
            $this->page_title,
            $this->menu_title,
            $this->base_capability,
            $this->menu_slug,
            [ $this, 'render_menu_page' ],
            $this->icon,
            $this->position,
        );

        // foreach ( $this->submenus as $item ) {
        //     $submenu[ $this->menu_slug ][] = [ $item['title'], $item['capability'], $item['url'] ]; // phpcs:ignore
        // }

        add_submenu_page(
            'login-activity-tracker', 
            'Settings', 
            'Settings', 
            'manage_options', 
            'lat-settings', 
            [$this, 'lat_render_settings_page']
        );
    }

    /**
     * Renders the admin page.
     *
     * @since  1.0.0
     *
     * @return void
     */
    public function render_menu_page(): void {
        global $wpdb;
        $table = $wpdb->prefix . 'login_activity';

        $search_user = $_GET['username'] ?? '';
        $search_status = $_GET['status'] ?? '';
        $page = max(1, intval($_GET['paged'] ?? 1));
        $per_page = 20;
        $offset = ($page - 1) * $per_page;

        $where = 'WHERE 1=1';
        if ($search_user) {
            $where .= $wpdb->prepare(" AND username LIKE %s", "%$search_user%");
        }
        if ($search_status) {
            $where .= $wpdb->prepare(" AND login_status = %s", $search_status);
        }

        $total = $wpdb->get_var("SELECT COUNT(*) FROM $table $where");
        $logs = $wpdb->get_results("SELECT * FROM $table $where ORDER BY created_at DESC LIMIT $per_page OFFSET $offset");
        $total_pages = ceil($total / $per_page);

        echo '<div class="wrap">
            <h1>Login Activity Logs</h1>
            <form method="get" style="margin-bottom: 20px;">
                <input type="hidden" name="page" value="login-activity-tracker">
                <input type="text" name="username" placeholder="Username" value="' . esc_attr($search_user) . '" />
                <select name="status">
                    <option value="">All Statuses</option>
                    <option value="Success"' . selected($search_status, 'Success', false) . '>Success</option>
                    <option value="Failed"' . selected($search_status, 'Failed', false) . '>Failed</option>
                </select>
                <button class="button">Filter</button>
            </form>

            <table class="widefat fixed striped">
                <thead><tr>
                    <th>Username</th>
                    <th>Status</th>
                    <th>IP</th>
                    <th>Location</th>
                    <th>Device</th>
                    <th>User Agent</th>
                    <th>Time</th>
                </tr></thead>
                <tbody>';

        if ($logs) {
            foreach ($logs as $log) {
                echo '<tr>
                    <td>' . esc_html($log->username) . '</td>
                    <td>' . esc_html($log->login_status) . '</td>
                    <td>' . esc_html($log->ip_address) . '</td>
                    <td>' . esc_html($log->location) . '</td>
                    <td>' . esc_html($log->device) . '</td>
                    <td>' . esc_html($log->user_agent) . '</td>
                    <td>' . esc_html($log->created_at) . '</td>
                </tr>';
            }
        } else {
            echo '<tr><td colspan="7">No records found.</td></tr>';
        }

        echo '</tbody></table>';

        if ($total_pages > 1) {
            echo '<div class="tablenav"><div class="tablenav-pages">';
            for ($i = 1; $i <= $total_pages; $i++) {
                $class = ($i === $page) ? ' class="current"' : '';
                $url = add_query_arg(['paged' => $i]);
                echo "<a href='" . esc_url($url) . "'$class>$i</a> ";
            }
            echo '</div></div>';
        }

        echo '</div>';
    }

    /**
     * Renders the settings page.
     *
     * @since  1.0.0
     *
     * @return void
     */
    public function lat_render_settings_page() {
        ?>
        <div class="wrap">
            <h1>Login Activity Tracker Settings</h1>
            <form method="post" action="options.php">
                <?php settings_fields('lat_settings_group'); ?>
                <?php do_settings_sections('lat_settings_group'); ?>

                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Enable Logging</th>
                        <td><input type="checkbox" name="lat_logging_enabled" value="1" <?php checked(get_option('lat_logging_enabled', true), true); ?> /></td>
                    </tr>

                    <tr valign="top">
                        <th scope="row">Max Log Retention (days)</th>
                        <td><input type="number" name="lat_log_retention_days" value="<?php echo esc_attr(get_option('lat_log_retention_days', 30)); ?>" min="1" /></td>
                    </tr>

                    <tr valign="top">
                        <th scope="row">Enable Email Alerts on Failed Attempts</th>
                        <td><input type="checkbox" name="lat_email_alert_enabled" value="1" <?php checked(get_option('lat_email_alert_enabled', false), true); ?> /></td>
                    </tr>

                    <tr valign="top">
                        <th scope="row">Failed Attempts Threshold</th>
                        <td><input type="number" name="lat_failed_attempt_threshold" value="<?php echo esc_attr(get_option('lat_failed_attempt_threshold', 5)); ?>" min="1" /></td>
                    </tr>

                    <tr valign="top">
                        <th scope="row">Enable IP Blocking</th>
                        <td><input type="checkbox" name="lat_ip_block_enabled" value="1" <?php checked(get_option('lat_ip_block_enabled', false), true); ?> /></td>
                    </tr>
                </table>

                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
}

