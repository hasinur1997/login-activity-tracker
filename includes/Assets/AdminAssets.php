<?php
namespace Hasinur\LoginActivityTracker\Assets;

/**
 * Manage all admin scripts and styles
 */
class AdminAssets extends BaseAssets {
    /**
     * Enqueue all scripts and styles
     *
     * @return  void
     */
    public function register_hooks(): void {
        add_action( 'admin_enqueue_scripts', [$this, 'register_scripts'] );
        add_action( 'admin_enqueue_scripts', [$this, 'register_styles'] );
        add_action( 'admin_enqueue_scripts',  [$this, 'enqueue_scripts_styles'] );
    }

    /**
     * Enqueue scripts and styles
     *
     * @return  void
     */
    public function enqueue_scripts_styles() {
        $result = wp_enqueue_script( 'loginActivityTracker-admin-scripts' );

        error_log(print_r([
            'result' => $result,
        ], true));
    }

    /**
     * Get all scripts
     *
     * @return  array List register scripts
     */
    public function get_scripts(): array {
        $scripts = [
            'loginActivityTracker-admin-scripts'     => [
                'src'       => loginActivityTracker()->build_url . '/index.js',
                'in_footer' => true,
            ],
        ];

        return apply_filters( 'loginActivityTracker_admin_assets', $scripts );
    }

    /**
     * List of register styles
     *
     * @return  array
     */
    public function get_styles(): array {
        $styles = [
            'loginActivityTracker-admin-style'    => [
                'src' => loginActivityTracker()->build_url . '/admin.css',
            ],
        ];

        return apply_filters( 'loginActivityTracker_admin_styles', $styles );
    }
}
