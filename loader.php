<?php
/**
 * The loader file.
 *
 * @package Opalestate_Custom_Fields
 */

/**
 * First, we need autoload via Composer to make everything works.
 */
require_once trailingslashit( __DIR__ ) . 'vendor/autoload.php';

/**
 * Then, require the main class.
 */
require_once trailingslashit( __DIR__ ) . 'inc/functions.php';
require_once trailingslashit( __DIR__ ) . 'inc/Plugin.php';

/**
 * Alias the class "Opalestate_Custom_Fields\Plugin" to "Opalestate_Custom_Fields".
 */
class_alias( \Opalestate_Custom_Fields\Plugin::class, 'Opalestate_Custom_Fields', false );
