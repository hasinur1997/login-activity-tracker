<?php
namespace Hasinur\LoginActivityTracker\Login;

use Hasinur\LoginActivityTracker\Core\Abstracts\Provider;

/**
 * Class LoginProvider.
 *
 * Provides the login functionality of the plugin.
 *
 * @package Hasinur\LoginActivityTracker\Login
 */
class LoginProvider extends Provider {

    /**
     * Register all the necessary services for the login.
     * Dependencies are automatically resolved.
     *
     * @var string $services
     */
    protected $services = [
        Logger::class,
        IpBlocker::class,
    ];

    /**
     * Checks if a service should be registered.
     *
     * @return bool
     */
    protected function can_be_registered(): bool {
        return true;
    }
}
