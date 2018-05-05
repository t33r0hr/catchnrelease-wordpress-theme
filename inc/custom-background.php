<?php if( ! defined( 'ABSPATH' ) ) exit;
/**
 * Sample implementation of the Custom Header feature.
 *
 */
function catchnrelease_custom_background_setup() {
  add_theme_support( 'custom-background', apply_filters( 'catchnrelease_custom_background_args', array(
    'default-image' => get_template_directory_uri() . '/img/default-background.webp', 
    'default-text-color'     => 'fff',
    'flex-height'            => true,
    'flex-width'            => true
  ) ) );
}
add_action( 'after_setup_theme', 'catchnrelease_custom_background_setup' );
/*
register_default_backgrounds( array(
  'yourimg' => array(
  'url' => get_template_directory_uri() . '/framework/images/background.jpg',
  'thumbnail_url' => get_template_directory_uri() . '/framework/images/background.jpg',
  'description' => _x( 'Default Image', 'background image description', 'catch-and-release' )),
));*/