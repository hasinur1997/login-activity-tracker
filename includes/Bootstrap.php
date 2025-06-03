<?php
namespace Hasinur\LoginActivityTracker;

use Hasinur\LoginActivityTracker\Admin\AdminProvider;
use Hasinur\LoginActivityTracker\Api\ApiProvider;
use Hasinur\LoginActivityTracker\Assets\AssetsProvider;
use Hasinur\LoginActivityTracker\Core\Interfaces\ProviderInterface;
use Hasinur\LoginActivityTracker\Login\LoginProvider;
use Hasinur\LoginActivityTracker\Services\Database;

/**
 * Class Bootstrap
 *
 * Handles the plugin's bootstrap process.
 *
 * @package Hasinur\LoginActivityTracker
 */
class Bootstrap {
	/**
	 * Holds plugin's provider classes.
	 *
	 * @var string[]
	 */
	protected static $providers = [
		AdminProvider::class,
		LoginProvider::class,
		ApiProvider::class,
		AssetsProvider::class
	];

	/**
	 * Runs plugin bootstrap.
	 *
	 * @return void
	 */
	public static function run(): void {
		add_action( 'init', [ self::class, 'init' ] );
		add_action( 'plugins_loaded', [ self::class, 'db_connect' ] );
	}

	/**
	 * Bootstraps the plugin. Load all necessary providers.
	 *
	 * @return void
	 */
	public static function init(): void {
		self::register_providers();
	}

	/**
	 * Registers providers.
	 *
	 * @return void
	 */
	protected static function register_providers(): void {
		foreach ( self::$providers as $provider ) {
			if ( class_exists( $provider ) && is_subclass_of( $provider, ProviderInterface::class ) ) {
				new $provider();
			}
		}
	}

	/**
	 * Connects to the database using Eloquent ORM.
	 *
	 * @return void
	 */
	public static function db_connect(): void {
		// Ensure the Database service is loaded.
		if ( class_exists( Database::class ) ) {
			Database::boot();
		} else {
			wp_die( 'Database service class not found.' );
		}
	}
}

