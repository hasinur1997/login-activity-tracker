<?php
namespace HubOrder\Core\Interfaces;

/**
 * The CustomPostTypeInterface defines the contract for custom post type classes in the     application.
 * It requires implementing classes to define a register_post_type method, which is responsible
 * for registering the custom post type with WordPress.
 *
 * @package HubOrder\Core\Interfaces
 */
interface CustomPostTypeInterface {

	/**
	 * Register the custom post type.
	 *
	 * @return void
	 */
	public function register_post_type(): void;
}
