<?php

function catchandrelease_create_post_type_feature () {

  register_post_type ( 'game_feature', 
    array(
      'labels' => array (
        'name' => __('Game Features'),
        'singular_name' => __('Game Feature'),
        'add_new_item' => __('Add New Game Feature'),
        'edit_item' => __('Edit Game Feature')
      ),
      'public'       => true,
      'hierarchical' => true,
      'has_archive'  => true,
      'show_in_nav_menus' => false,
      'show_in_menu' => true,
      'hierarchical' => true,
      'supports'     => array(
        'title',
        'editor',
        'page-attributes'
      ), 
      'taxonomies'   => array()
    )
  );
}
add_action( 'init', 'catchandrelease_create_post_type_feature' );