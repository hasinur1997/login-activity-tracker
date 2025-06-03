<?php
namespace Hasinur\LoginActivityTracker\Core\Container\Exception;

use Exception;
use HubOrder\Core\Container\NotFoundExceptionInterface;

/**
 * Exception thrown when a dependency has no default value.
 *
 * @package Hasinur\LoginActivityTracker\Container
 */
class DependencyHasNoDefaultValueException extends Exception implements NotFoundExceptionInterface {
}
