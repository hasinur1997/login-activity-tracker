<?php
namespace Hasinur\LoginActivityTracker\Assets;

/**
 * Manage all admin scripts and styles
 */
class FrontendAssets extends BaseAssets {
    /**
     * Register hooks
     *
     * @return  void
     */
    public function register_hooks(): void {
        add_action( 'wp_enqueue_scripts', [$this, 'register_scripts'] );
        add_action( 'wp_enqueue_scripts', [$this, 'register_styles'] );
        add_action( 'wp_enqueue_scripts',  [$this, 'enqueue_scripts_styles'] );
    }
    
    /**
     * Enqueue scripts and styles
     *
     * @return  void
     */
    public function enqueue_scripts_styles() {
        wp_enqueue_script( 'loginActivityTracker-frontend-scripts' );
        wp_enqueue_style( 'loginActivityTracker-frontend-style' );
    }

    /**
     * Get all scripts
     *
     * @return  array List register scripts
     */
    public function get_scripts(): array {
        $scripts = [
            'loginActivityTracker-frontend-scripts'     => [
                'src'       => loginActivityTracker()->build_url . '/frontend.js',
                'in_footer' => true,
            ],
        ];

        return apply_filters( 'loginActivityTracker_frontend_assets', $scripts );
    }

    /**
     * List of register styles
     *
     * @return  array
     */
    public function get_styles(): array {
        $styles = [
            'loginActivityTracker-frontend-style'    => [
                'src' => loginActivityTracker()->build_url . '/frontend.css',
            ],
        ];

        return apply_filters( 'loginActivityTracker_frontend_styles', $styles );
    }
}
