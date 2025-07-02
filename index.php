<?php
/**
 * Plugin Name: Virtual Exhibit
 * Description: A WordPress plugin to create and manage virtual exhibits.
 * Version: 0.1.2
 * Author: Jeremy Mullis, Coneflower Consulting
 * Author URI: https://www.coneflower.org
 * License: GPL2
 */

require_once __DIR__ . '/vendor/autoload.php';

// Timber Setup
Timber\Timber::init();
add_filter('timber/context', 'ddb7_add_to_context');
add_filter('timber/twig', 'ddb7_add_to_twig');
add_filter('timber/locations', 'ddb7_set_template_paths');

// Register Custom Post Types and Taxonomies
add_action('init', 'ddb7_register_cpts');

// Enqueue Assets
add_action('wp_enqueue_scripts', 'ddb7_enqueue_front', 100);

/* Filter the single_template with our custom function*/
add_filter('single_template', 'ddb7_exhibit_template');

function ddb7_register_cpts()
{
	/**
	 * Post Type Vircual Exhibit
	 */

	register_extended_post_type('exhibit', [
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

function ddb7_set_template_paths($paths) {
	/* The timber documentation says we shouldn't need to set this path explicitly, but we did. */
		$paths[] = [ plugin_dir_path(__FILE__) . '/views' ];
		
		return $paths;
}

function ddb7_enqueue_front()
{
  global $post;
	if ( $post->post_type == 'exhibit' ) {
		$asset_file = include plugin_dir_path(__FILE__) . '/build/index.asset.php';
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
}

function ddb7_exhibit_template($single) {

    global $post;

    /* Checks for single template by post type */
    if ( $post->post_type == 'exhibit' ) {
        if ( file_exists( plugin_dir_path(__FILE__) . '/inc/single-exhibit.php' ) ) {
            return plugin_dir_path(__FILE__) . '/inc/single-exhibit.php';
        }
    }
    return $single;

}