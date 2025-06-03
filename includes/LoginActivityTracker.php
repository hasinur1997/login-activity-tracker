<?php
namespace Hasinur\LoginActivityTracker;

use Hasinur\LoginActivityTracker\Core\Container\Container;

/**
 * LoginActivityTracker Plugin Main Class
 * This class initializes the plugin, sets up the text domain for translations,
 * registers admin menu items, and initializes the contact routes.
 * @package Hasinur\LoginActivityTracker
 * @since 1.0.0
 * @author Hasinur Rahman
 * @license GPL v2 or later
 */
class LoginActivityTracker {
    /**
     * Plugin version.
     *
     * @var string
     */
    public $version;

    /**
     * Plugin file.
     *
     * @var string
     */
    public $plugin_file;

    /**
     * Plugin directory.
     *
     * @var string
     */
    public $plugin_directory;

    /**
     * @var string
     */
    public $build_url;

    /**
     * Plugin base name.
     *
     * @var string
     */
    public $basename;

    /**
     * Plugin text directory path.
     *
     * @var string
     */
    public $text_domain_directory;

    /**
     * Plugin text directory path.
     *
     * @var string
     */
    public $template_directory;

    /**
     * Plugin assets directory path.
     *
     * @var string
     */
    public $assets_url;

    /**
     * Plugin url.
     *
     * @var string
     */
    public $plugin_url;

    /**
     * Container that holds all the services.
     *
     * @var Container
     */
    public $container;

    /**
     * HubOrder Constructor.
     */
    public function __construct() {
        $this->init();
        $this->register_lifecycle();
        $this->register_container();

        Bootstrap::run();
    }

    /**
     * Initialize the plugin.
     *
     * @return void
     */
    protected function init(): void {
        $this->version               = '1.0.0';
        $this->plugin_file           = LOGIN_ACTIVITY_TRACKER_PLUGIN_FILE;
        $this->plugin_directory      = LOGIN_ACTIVITY_TRACKER_PLUGIN_DIR;
        $this->basename              = plugin_basename( $this->plugin_file );
        $this->text_domain_directory = $this->plugin_directory . '/languages';
        $this->template_directory    = $this->plugin_directory . '/templates';
        $this->plugin_url            = plugins_url( '', $this->plugin_file );
        $this->assets_url            = $this->plugin_url . '/assets';
        $this->build_url             = $this->plugin_url . '/build';
    }

    /**
     * Registers life-cycle hooks.
     *
     * @return void
     */
    protected function register_lifecycle(): void {
        register_activation_hook( $this->plugin_file, [ Activate::class, 'handle' ] );
        register_deactivation_hook( $this->plugin_file, [ Deactivate::class, 'handle' ] );
    }

    /**
     * Initializes the container.
     *
     * @return void
     */
    protected function register_container(): void {
        $this->container = new Container();
    }

    /**
     * Initializes the HubOrder class.
     *
     * Checks for an existing HubOrder instance
     * and if it doesn't find one, creates it.
     *
     * @return LoginActivityTracker
     */
    public static function instance(): LoginActivityTracker {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new self();
        }

        return $instance;
    }
}
