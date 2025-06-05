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

        $this->page_title      = __( 'Login Activity', 'login-activity-tracker' );
        $this->menu_title      = __( 'Login Activity', 'login-activity-tracker' );
        $this->base_capability = 'read';
        $this->capability      = 'manage_options';
        $this->menu_slug       = 'login-activity-tracker';
        $this->icon            = 'dashicons-rest-api';
        $this->position        = 57;
        $this->submenus        = [
            [
                'title'      => __( 'Logs', 'login-activity-tracker' ),
                'capability' => $this->base_capability,
                'url'        => 'admin.php?page=' . $this->menu_slug . '#/',
            ],
            [
                'title'      => __( 'Settings', 'login-activity-tracker' ),
                'capability' => $this->base_capability,
                'url'        => 'admin.php?page=' . $this->menu_slug . '#/settings',
            ],
            
        ];
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

        

        foreach ( $this->submenus as $item ) {
            $submenu[ $this->menu_slug ][] = [ $item['title'], $item['capability'], $item['url'] ]; // phpcs:ignore
        }
    }

    /**
     * Renders the admin page.
     *
     * @since  1.0.0
     *
     * @return void
     */
    public function render_menu_page(): void {
        echo '<div id="login-activity-tracker"></div>';
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

