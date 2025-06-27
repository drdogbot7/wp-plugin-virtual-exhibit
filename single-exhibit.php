<?php
/**
 * The template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Timber
 * @since 1.0.0
 */

$context = Timber::context();
$context['html_class'] = 'online-exhibit';

Timber::render('single-exhibit.twig', $context);