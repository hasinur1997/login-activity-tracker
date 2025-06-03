<?php
namespace Hasinur\LoginActivityTracker\Services;

/**
 * IPService class
 *
 * This class provides methods to retrieve location information based on IP addresses.
 *
 * @package Hasinur\LoginActivityTracker\Services
 * @since 1.0.0
 */
class IPService {
    /**
     * Get the location information for a given IP address.
     *
     * @param   string  $ip  The IP address to look up.
     *
     * @return  string       The location information.
     */
    public function get_location(string $ip): string {
        $cached = get_transient('lat_location_' . md5($ip));
        if ( $cached ) return $cached;

        $url = "http://ip-api.com/json/{$ip}?fields=status,country,regionName,city";

        $response = wp_remote_get($url);

        if ( is_wp_error( $response ) ) return 'Unknown';

        $body = json_decode( wp_remote_retrieve_body( $response ), true );

        if ( ! is_array( $body ) || ( $body['status'] ?? '' ) !== 'success' ) return 'Unknown';

        $location = trim( "{$body['city']}, {$body['regionName']}, {$body['country']}", ', ' );

        set_transient( 'lat_location_' . md5($ip), $location, DAY_IN_SECONDS );

        return $location;
    }
}

