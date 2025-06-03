<?php
namespace Hasinur\LoginActivityTracker\Core\Abstracts;

use Hasinur\LoginActivityTracker\Core\Interfaces\ProviderInterface;
use Hasinur\LoginActivityTracker\Core\Interfaces\HookableInterface;
use Hasinur\LoginActivityTracker\LoginActivityTracker;

/**
 * Handles instantiation of services.
 *
 * @package Hasinur\LoginActivityTracker\Core\Abstracts
 */
abstract class Provider implements ProviderInterface {

    /**
     * Holds classes that should be instantiated.
     *
     * @var array
     */
    protected $services = [];

    /**
     * Service provider.
     *
     * @param array $services
     *
     * @throws \ReflectionException
     */
    public function __construct( array $services = [] ) {
        if ( ! empty( $services ) ) {
            $this->services = $services;
        }

        $this->register();
    }

    /**
     * Checks if a providers' service should be registered.
     *
     * @return bool
     */
    abstract protected function can_be_registered(): bool;

    /**
     * Registers services with the container.
     *
     * @throws \ReflectionException
     */
    public function register(): void {
        foreach ( $this->services as $service ) {
            if ( ! class_exists( $service ) || ! $this->can_be_registered() ) {
                continue;
            }

            $service = (new LoginActivityTracker)->container->get( $service );

            if ( $service instanceof HookableInterface ) {
                $service->register_hooks();
            }
        }
    }
}
