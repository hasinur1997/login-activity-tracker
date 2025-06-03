<?php
namespace Hasinur\LoginActivityTracker\Assets;

/**
 * Manage all localize data
 */
class Localize {

    /**
     * Get admin localize data
     *
     * @return  array Collection localize data
     */
    public static function get_admin() {
        $data = [
            'site_url'            => site_url(),
            'admin_url'           => admin_url(),
            'nonce'               => wp_create_nonce( 'wp_rest' ),
            'date_format'         => get_option( 'date_format' ),
            'date_format_string'  => date_i18n( get_option( 'date_format' ) ),
            'time_format'         => get_option( 'time_format' ),
            'time_format_string'  => date_i18n( get_option( 'time_format' ) ),
            'start_of_week'       => get_option( 'start_of_week', 0 ),
            'current_user_id'     => get_current_user_id(),
        ];

        return apply_filters( 'phonebook_admin_localize', $data );
    }

    /**
     * Get frontend localize data
     *
     * @return  array Collection localize data
     */
    public static function get_frontend() {
        $data = [
            'site_url'            => site_url(),
            'nonce'               => wp_create_nonce( 'wp_rest' ),
            'date_format'         => get_option( 'date_format' ),
            'time_format'         => get_option( 'time_format' ),
            'current_user_id'     => get_current_user_id(),
            'start_of_week'       => get_option( 'start_of_week', 0 ),
            'locale_name'         => strtolower( str_replace( '_', '-', get_locale() ) )
        ];

        return apply_filters( 'phonebook_frontend_localize', $data );
    }
}
