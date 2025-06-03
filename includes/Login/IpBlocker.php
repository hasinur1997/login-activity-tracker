<?php
namespace Hasinur\LoginActivityTracker\Login;

use Hasinur\LoginActivityTracker\Core\Interfaces\HookableInterface;
use Hasinur\LoginActivityTracker\Services\IPService;
use WP_Error;

/**
 * IpBlocker class for tracking login activities.
 *
 * @since 1.0.0
 */
class IpBlocker implements HookableInterface {
    /**
     * Register hooks for login activity tracking.
     *
     * @return void
     */
    public function register_hooks(): void {
        // Block login if IP is blocked
        add_filter('authenticate', [$this, 'ip_blocked'], 30, 3);
    }

    /**
     * Check if the user's IP is blocked.
     *
     * @param \WP_User|WP_Error $user The user object or WP_Error if authentication failed.
     * @param string $username The username of the user.
     * @param string $password The password of the user.
     * @return \WP_User|WP_Error
     */
    public function ip_blocked($user, $username, $password) {
        if ( ! empty( $_SERVER['REMOTE_ADDR'] ) ) {
            $ip = $_SERVER['REMOTE_ADDR'];
            if ( get_transient('lat_block_ip_' . md5( $ip ) ) ) {
                return new WP_Error('lat_ip_blocked', __('Your IP has been temporarily blocked due to multiple failed login attempts.', 'login-activity-tracker') );
            }
        }
        
        return $user;
    }

}
