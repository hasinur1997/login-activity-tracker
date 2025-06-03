<?php
namespace Hasinur\LoginActivityTracker\Assets;

/**
 * Manage all common scripts and styles
 */
class CommonAssets extends BaseAssets {

    /**
     * Register hooks
     *
     * @return  void
     */
    public function register_hooks(): void {
        add_action( 'wp_enqueue_scripts', [$this, 'register_scripts'] );
        add_action( 'wp_enqueue_scripts', [$this, 'register_styles'] );
        add_action( 'wp_enqueue_scripts',  [$this, 'enqueue'] );
    }

    /**
     * Enqueue scripts and styles
     *
     * @return  void
     */
    public function enqueue() {

    }

    /**
     * Get all scripts
     *
     * @return  array List register scripts
     */
    public function get_scripts(): array {
        $scripts = [];

        return apply_filters( 'phonebook_common_assets', $scripts );
    }

    /**
     * List of register styles
     *
     * @return  array
     */
    public function get_styles(): array {
        $styles = [];

        return apply_filters( 'phonebook_common_styles', $styles );
    }
}



