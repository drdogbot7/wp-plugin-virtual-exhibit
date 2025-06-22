<?php
/**
 * Plugin Name: Virtual Exhibit
 * Description: A WordPress plugin to create and manage virtual exhibits.
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://yourwebsite.com
 * License: GPL2
 */

require_once __DIR__ . '/vendor/autoload.php';

// Timber Setup
Timber\Timber::init();

// Register Custom Post Types and Taxonomies
add_action('init', 'ddb7_register_cpts');

function ddb7_register_cpts()
{
	/**
	 * Post Type Online Exhibit
	 */

	register_extended_post_type('online-exhibit', [
		'menu_icon' => 'dashicons-images-alt',
		'show_in_rest' => true,
	]);
}