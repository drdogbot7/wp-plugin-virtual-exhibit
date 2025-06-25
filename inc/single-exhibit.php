<?php
/**
 * The template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Timber
 * @since 1.0.0
 */

$context = Timber::context();

$templates = [];

if (get_query_var('singlepage')) {
	$templates[] = 'single.twig';
	$context['body_class'] .= ' supports-wide';
} else {
	$templates = ['single-online-exhibit.twig', 'single.twig'];
	$context['html_class'] = 'online-exhibit';
}

Timber::render($templates, $context);