<?php
/*
 * Plugin Name:       Login Activity Tracker
 * Plugin URI:        https://github.com/plugins/login-activity-tracker
 * Description:       A plugin to track user login activities in WordPress.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      8.2
 * Author:            Hasinur Rahman
 * Author URI:        https://github.com/hasinur1997
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       login-activity-tracker
 * Domain Path:       /languages
 */

defined('ABSPATH') || exit;

use Hasinur\LoginActivityTracker\LoginActivityTracker;

require_once __DIR__ . '/vendor/autoload.php';


if ( ! defined( 'LOGIN_ACTIVITY_TRACKER_PLUGIN_FILE' ) ) {
	define( 'LOGIN_ACTIVITY_TRACKER_PLUGIN_FILE', __FILE__ );
}

if ( ! defined( 'LOGIN_ACTIVITY_TRACKER_PLUGIN_DIR' ) ) {
	define( 'LOGIN_ACTIVITY_TRACKER_PLUGIN_DIR', __DIR__ );
}

/**
 * LoginActivityTracker
 *
 * @return  LoginActivityTracker
 */
function loginActivityTracker() {
	return LoginActivityTracker::instance();
}

// Kick off the plugin.
loginActivityTracker();