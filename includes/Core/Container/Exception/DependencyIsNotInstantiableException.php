<?php
namespace Hasinur\LoginActivityTracker\Core\Container\Exception;

use Exception;
use Hasinur\LoginActivityTracker\Core\Container\ContainerExceptionInterface;

/**
 * Exception thrown when a dependency is not instantiable.
 *
 * @package HubOrder\Container
 */
class DependencyIsNotInstantiableException extends Exception implements ContainerExceptionInterface {
}
