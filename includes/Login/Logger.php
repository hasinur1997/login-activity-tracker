<?php
namespace Hasinur\LoginActivityTracker\Login;

use Hasinur\LoginActivityTracker\Core\Interfaces\HookableInterface;
use Hasinur\LoginActivityTracker\Services\IPService;

/**
 * Logger class for tracking login activities.
 *
 * @since 1.0.0
 */
class Logger implements HookableInterface {
    /**
     * Register hooks for login activity tracking.
     *
     * @return void
     */
    public function register_hooks(): void {
        add_action('wp_login', [$this, 'handle_successful_login'], 10, 2);
        add_action('wp_login_failed', [$this, 'handle_failed_login']);
    }

    /**
     * Handle successful login event.
     *
     * @param string $username The username of the user who logged in.
     * @param \WP_User $user The WP_User object of the logged-in user.
     * @return void
     */
    public function handle_successful_login(string $username, \WP_User $user): void {

        $this->log_activity($username, $user->ID, 'success');
    }

    /**
     * Handle failed login event.
     *
     * @param string $username The username of the user who attempted to log in.
     * @return void
     */
    public function handle_failed_login(string $username): void {
        $this->log_activity($username, null, 'failed');
    }

    /**
     * Log the login activity.
     *
     * @param string $username The username of the user.
     * @param int|null $user_id The ID of the user, or null if not applicable.
     * @param string $status The status of the login attempt ('success' or 'failed').
     * @return void
     */
    private function log_activity(string $username, ?int $user_id, string $status): void {
        global $wpdb;

        $ip = $_SERVER['HTTP_CLIENT_IP'] ??
              $_SERVER['HTTP_X_FORWARDED_FOR'] ??
              $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';

        $location = (new IPService())->get_location($ip);
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'UNKNOWN';
        $device = $this->detect_device($user_agent);

        $wpdb->insert(
            $wpdb->prefix . 'login_activity',
            [
                'username'     => $username,
                'login_status' => $status,
                'ip_address'   => $ip,
                'location'     => $location,
                'device'       => $device,
                'user_agent'   => $user_agent,
            ]
        );

        if ( $status === 'failed' ) {
            $this->lat_handle_failed_login($ip, $username);
        } 
    }

    /**
     * Detect the device type based on the user agent.
     *
     * @param string $user_agent The user agent string.
     * @return string The detected device type.
     */
    private function detect_device(string $user_agent): string {
        if (preg_match('/mobile/i', $user_agent)) return 'Mobile';
        if (preg_match('/tablet/i', $user_agent)) return 'Tablet';
        if (preg_match('/windows|macintosh|linux/i', $user_agent)) return 'Desktop';

        return 'Unknown';
    }

    /**
     * Handle failed login attempts and take actions based on settings.
     *
     * @param string $ip The IP address of the user.
     * @param string $username The username of the user who attempted to log in.
     * @return void
     */
    private function lat_handle_failed_login( $ip, $username ) {
        $threshold           = intval(get_option('lat_failed_attempt_threshold', 5));
        $email_alert_enabled = get_option('lat_email_alert_enabled', false);
        $ip_block_enabled    = get_option('lat_ip_block_enabled', false);

        global $wpdb;
        $table = $wpdb->prefix . 'login_activity';

        // Count failed attempts from this IP in last 1 hour
        $one_hour_ago = date('Y-m-d H:i:s', strtotime('-1 hour'));
        $failed_count = $wpdb->get_var( $wpdb->prepare(
            "SELECT COUNT(*) FROM $table WHERE ip_address = %s AND login_status = 'Failed' AND created_at > %s",
            $ip, $one_hour_ago
        ) );

        if ( $failed_count >= $threshold ) {
            // Send email alert if enabled
            if ( $email_alert_enabled ) {
                $admin_email = get_option('admin_email');
                $subject = "Multiple Failed Login Attempts Detected";
                $message = "There have been {$failed_count} failed login attempts from IP: {$ip} in the last hour.\nUsername tried: {$username}\nTime: " . current_time('mysql');
                wp_mail($admin_email, $subject, $message);
            }

            // Block IP by adding a transient to block for 1 hour (simple implementation)
            if ( $ip_block_enabled ) {
                set_transient('lat_block_ip_' . md5($ip), true, HOUR_IN_SECONDS);
            }
        }
    }
}
