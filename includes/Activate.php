<?php
namespace Hasinur\LoginActivityTracker;

/**
 * Activation class.
 *
 * @package Hasinur\LoginActivityTracker
 */
class Activate {

    /**
     * Activation hook.
     *
     * @return void
     */
    public static function handle(): void {
        Install::run();
    }
}
