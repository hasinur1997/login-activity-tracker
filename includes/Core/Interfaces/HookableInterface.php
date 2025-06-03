<?php
namespace Hasinur\LoginActivityTracker\Core\Interfaces;

/**
 * The HookableInterface defines the contract for classes that can register hooks in the application.
 * It requires implementing classes to define a register_hooks method, which is responsible
 * for registering the hooks with WordPress.
 *
 * @package Hasinur\LoginActivityTracker\Core\Interfaces
 */
interface HookableInterface {

    /**
     * Registers all hooks for the class.
     *
     * @return void
     */
    public function register_hooks(): void;
}
