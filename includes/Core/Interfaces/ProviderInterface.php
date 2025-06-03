<?php
namespace Hasinur\LoginActivityTracker\Core\Interfaces;

/**
 * The ProviderInterface defines the contract for service providers in the application.
 * It requires implementing classes to define a register method, which is responsible
 * for registering the services provided by the provider.
 *
 * @package Hasinur\LoginActivityTracker\Core\Interfaces
 */
interface ProviderInterface {

	/**
	 * Registers the services provided by the provider.
	 *
	 * @return void
	 */
	public function register(): void;
}
