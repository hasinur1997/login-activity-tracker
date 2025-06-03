<?php
namespace Hasinur\LoginActivityTracker\Services;

// use Illuminate\Database\Capsule\Manager as Capsule;
// use Illuminate\Events\Dispatcher;
// use Illuminate\Container\Container;

/**
 * Database Service Class
 * This class handles the database connection using Eloquent ORM.
 * It sets up the database connection and initializes Eloquent.
 *
 * @package Hasinur\LoginActivityTracker\Services
 * @since 1.0.0
 * @author Hasinur Rahman
 * @license GPL v2 or later
 */
class Database {
    /**
     * Boot the database connection using Eloquent ORM.
     * This method sets up the database connection and initializes Eloquent.
     *
     * @return void
     */
    public static function boot() {
        global $wpdb;

        /**
         * Capsule instance for database interactions.
         *
         * @var Capsule
         */
        // $capsule = new Capsule;

        // Set the event dispatcher used by Eloquent models (optional).
        // $capsule->addConnection([
        //     'driver'    => 'mysql',
        //     'host'      => DB_HOST,
        //     'database'  => DB_NAME,
        //     'username'  => DB_USER,
        //     'password'  => DB_PASSWORD,
        //     'charset'   => 'utf8',
        //     'collation' => 'utf8_unicode_ci',
        //     'prefix'    => $wpdb->prefix,
        // ]);

        // $capsule->setAsGlobal();
        // $capsule->bootEloquent();
    }
}
