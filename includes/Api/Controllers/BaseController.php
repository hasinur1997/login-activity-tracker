<?php
namespace Hasinur\LoginActivityTracker\Api\Controllers;

use Hasinur\LoginActivityTracker\Core\Interfaces\HookableInterface;
use WP_REST_Controller;

use WP_HTTP_Response;
use WP_Error;

/**
 * BaseRest Controller
 *
 * @package Hasinur\LoginActivityTracker/Api/Controllers
 */
abstract class BaseController extends WP_REST_Controller implements HookableInterface {
    /**
     * Register routes
     *
     * @return void
     */
    public function register_hooks(): void {
        add_action('rest_api_init', [$this, 'register_routes']);
    }

    /**
     * Register all routes
     *
     * @return void
     */
    public function register_routes() {
        throw new \Exception('Need to override register_routes method from child class');
    }

    /**
     * Send rest error
     *
     * @param   string  $message      Error message
     * @param   integer $status_code  Error status code
     *
     * @return  WP_Error
     */
    public function error($message, $status_code = 422, $type = '', $details = '') {
        $data = [
            'success' => 0,
            'message' => $message,
            'error'   => [
                'code'    => $status_code,
                'type'    => $type,
                'details' => $details,
            ],
        ];

        return new \WP_HTTP_Response($data, $status_code);
    }

    /**
     * Send rest response
     *
     * @param   array $data Response data
     *
     * @return  WP_HTTP_Response
     */
    public function response($data) {
        $data = [
            'success' => 1,
            'data'    => $data,
        ];

        return new \WP_HTTP_Response($data, 200);
    }

    /**
     * Send rest response with message
     *
     * @param   array  $data        Response data
     * @param   string $message     Response message
     * @param   int    $status_code Response status code
     *
     * @return  WP_HTTP_Response
     */
    public function responseWithMessage($data, $message = '', $status_code = 200) {
        if (!$message) {
            $message = __('Request was successful', 'phonebook');
        }

        $data = [
            'success' => 1,
            'message' => $message,
            'data'    => $data,
        ];

        return new \WP_HTTP_Response($data, $status_code);
    }
    /**
     * Send rest response with message and error
     *
     * @param   array  $data        Response data
     * @param   string $message     Response message
     * @param   int    $status_code Response status code
     *
     * @return  WP_HTTP_Response
     */
    public function responseWithError($data, $message = '', $status_code = 200) {
        if ( ! $message ) {
            $message = __('Request was successful', 'phonebook');
        }

        $data = [
            'success' => 0,
            'message' => $message,
            'data'    => $data,
        ];

        return new \WP_HTTP_Response( $data, $status_code );
    }
    /**
     * Send rest response with message and error
     *
     * @param   array  $data        Response data
     * @param   string $message     Response message
     * @param   int    $status_code Response status code
     *
     * @return  WP_HTTP_Response
     */
    public function responseWithErrorAndDetails($data, $message = '', $status_code = 200) {
        if ( ! $message ) {
            $message = __('Request was successful', 'phonebook');
        }

        $data = [
            'success' => 0,
            'message' => $message,
            'data'    => $data,
        ];

        return new \WP_HTTP_Response( $data, $status_code );
    }
}
