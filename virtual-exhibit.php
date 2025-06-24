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
add_filter('timber/context', 'ddb7_add_to_context');
add_filter('timber/twig', 'ddb7_add_to_twig');

// Register Custom Post Types and Taxonomies
add_action('init', 'ddb7_register_cpts');

// Enqueue Assets
add_action('wp_enqueue_scripts', 'ddb7_enqueue_front', 100);

/* Filter the single_template with our custom function*/
add_filter('single_template', 'my_custom_template');

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

function ddb7_add_to_context($context)
{
	// if (class_exists('acf')) {
	// 	$context['options'] = get_fields('option');
	// }
	// show twig debugging if WP_DEBUG enabled
	if (in_array(WP_DEBUG, ['true', 'TRUE', 1])) {
		$context['debug'] = true;
	}

	return $context;
}

function ddb7_add_to_twig($twig)
{
	$twig
		->getExtension(\Twig\Extension\CoreExtension::class)
		->setTimezone('America/Chicago');
	return $twig;
}


function ddb7_enqueue_front()
{
	$asset_file = include __DIR__ . '/build/index.asset.php';
	wp_enqueue_script(
		'ddb7_js',
		plugin_dir_url( __FILE__ ) . 'build/index.js',
		['jquery'],
		$asset_file['version']
	);
	wp_enqueue_style(
		'ddb7_css',
		plugin_dir_url( __FILE__ ) . 'build/index.css',
		null,
		$asset_file['version']
	);
}

function my_custom_template($single) {

    global $post;

    /* Checks for single template by post type */
    if ( $post->post_type == 'online-exhibit' ) {
        if ( file_exists( __DIR__ . '/single-online-exhibit.php' ) ) {
            return __DIR__ . '/single-online-exhibit.php';
        }
    }

    return $single;

}