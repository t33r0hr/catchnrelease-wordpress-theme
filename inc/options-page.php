<?php
/**
 * Catch & Release: Options Page
 *
 * @package WordPress
 * @subpackage Catch&Release
 * @since 1.5.5
 */


/* ------------------ */
/* theme options page */
/* ------------------ */

function catchandrelease_options_init () {

  register_setting('cnr_options', 'cnr_theme_options', 'cnr_validate_options');

}

function catchandrelease_options_add_page() {
  add_theme_page('How Tos', 'How Tos', 'edit_theme_options', 'theme-howtos', 'catchandrelease_options_page' ); // Seitentitel, Titel in der Navi, Berechtigung zum Editieren (http://codex.wordpress.org/Roles_and_Capabilities) , Slug, Funktion 
}


function catchandrelease_options_page () {
  
  global $select_options, $radio_options;
  
  if ( ! isset( $_REQUEST['settings-updated'] ) ) {
    $_REQUEST['settings-updated'] = false;
  } ?>

  <div class="wrap">
    <?php echo file_get_contents( get_parent_theme_file_path('/howto.html') ); ?>
  </div>

  <?php

}

function cnr_validate_options ( $input ) {
  return $input;
}


add_action( 'admin_init', 'catchandrelease_options_init' );
add_action( 'admin_menu', 'catchandrelease_options_add_page' );

