<?php
namespace Hasinur\LoginActivityTracker\Api\Controllers;

use WP_REST_Server;
use WP_REST_Request;
use WP_HTTP_Response;
use WP_Error;
use Hasinur\LoginActivityTracker\Api\Controllers\BaseController;
use Hasinur\LoginActivityTracker\Models\Log;
use Hasinur\LoginActivityTracker\Resources\LogResource;


/**
 * LogController
 *
 * @package Hasinur\LoginActivityTracker\Api\Controllers
 */
class LogController extends BaseController {
    /**
     * Log namespace
     *
     * @var string
     */
    protected $namespace = 'login-activity/v1';

    /**
     * Contact rest base
     *
     * @var string
     */
    protected $rest_base = 'logs';

    /**
     * Register routes
     *
     * @return  void
     */
    public function register_routes(): void {

        register_rest_route( $this->namespace, '/' . $this->rest_base, [
            [
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => [ $this, 'get_items' ],
                'permission_callback' => [
                    $this,
                    'get_items_permissions_check'
                ],
            ],
            [
                'methods'             => WP_REST_Server::DELETABLE,
                'callback'            => [ $this, 'delete_items' ],
                'permission_callback' => [
                    $this,
                    'delete_items_permissions_check'
                ],
            ],
        ] );

        register_rest_route( $this->namespace, '/' . $this->rest_base . '/(?P<id>[\d]+)', [
            [
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => [ $this, 'get_item' ],
                'permission_callback' => [
                    $this,
                    'get_item_permissions_check'
                ],
            ],
            [
                'methods'             => WP_REST_Server::DELETABLE,
                'callback'            => [ $this, 'delete_item' ],
                'permission_callback' => [
                    $this,
                    'delete_item_permissions_check'
                ],
            ]
        ] );
    }

    /**
     * Get one item from the collection.
     *
     * @param $request
     *
     * @return WP_HTTP_Response
     */
    public function get_item( $request ) {
        $id = intval( $request['id'] );

        $log = Log::find( $id );

        if ( ! $log ) {
            return new WP_Error( 'not_found', __( 'log not found.', 'phonebook' ), [ 'status' => 404 ] );
        }

        $log = new LogResource( $log );

        return $this->response( $log );
    }

    /**
     * Check if a given request has access to get a specific item.
     *
     * @param $request
     *
     * @return WP_Error
     */
    public function get_item_permissions_check( $request ): bool {
        return current_user_can( 'manage_options' );
    }

    /**
     * Get a collection of items.
     *
     * @param $request
     *
     * @return WP_HTTP_Response
     */
    public function get_items( $request ) {
        $per_page   = !empty($request['per_page']) ? intval($request['per_page']) : 10;
        $page       = !empty($request['page']) ? intval($request['page']) : 1;
        $search     = !empty($request['search']) ? sanitize_text_field($request['search']) : '';
        $sortBy     = !empty($request['orderby']) ? sanitize_text_field($request['orderby']) : 'id';
        $sortOrder  = !empty($request['order']) ? sanitize_text_field($request['order']) : 'asc';
        $filter     = !empty($request['filter']) ? $request['filter'] : null;

        $query = Log::query();

        if ( ! empty( $search ) ) {
            $query->where(function ($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                    ->orWhere('login_status', 'like', "%{$search}%")
                    ->orWhere('ip_address', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('device', 'like', "%{$search}%")
                    ->orWhere('user_agent', 'like', "%{$search}%");
            });
        }

        // Filter
        if ( ! empty( $filter ) && is_string( $filter ) ) {
            $query->where( 'type', $filter );
        }

        // Sort
        $allowedSorts = ['id', 'name', 'created_at'];
        $sortBy       = in_array($sortBy, $allowedSorts) ? $sortBy : 'id';
        $sortOrder    = strtolower($sortOrder) === 'desc' ? 'desc' : 'asc';
        $query->orderBy($sortBy, $sortOrder);

        // Paginate
        $log = $query->paginate( $per_page, ['*'], 'page', $page );

        // Return
        return rest_ensure_response( $log );
    }

    /**
     * Check if a given request has access to get items.
     *
     * @param $request
     *
     * @return WP_Error
     */
    public function get_items_permissions_check( $request ): bool {
        return current_user_can( 'manage_options' );
    }

    /**
     * Delete one item from the collection.
     *
     * @param $request
     *
     * @return WP_HTTP_Response
     */
    public function delete_item( $request ) {
        $id = intval( $request['id'] );

        $log = Log::find( $id );

        if ( ! $log ) {
            return new WP_Error( 'not_found', __( 'Log not found.', 'login-activity-tracker' ), [ 'status' => 404 ] );
        }

        $log->delete();

        return $this->response( [
            'message' => __( 'Log deleted successfully.', 'login-activity-tracker' ),
        ], 200 );
    }

    /**
     * Check if a given request has access to delete a specific item.
     *
     * @param $request
     *
     * @return WP_Error
     */
    public function delete_item_permissions_check( $request ) {
        return current_user_can( 'manage_options' );
    }

    /**
     * Delete a collection of items
     *
     * @param $request
     *
     * @return WP_HTTP_Response
     */
    public function delete_items( $request ) {
        $ids = $request['ids'];

    }

    /**
     * Check if a given request has access to delete a collection of items.
     *
     * @param $request
     *
     * @return WP_Error
     */
    public function delete_items_permissions_check( $request ) {
        return current_user_can( 'manage_options' );
    }
}
