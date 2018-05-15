<?php

require_once get_parent_theme_file_path( '/widgets/class-cnr-widget-media.php' );
require_once get_parent_theme_file_path( '/widgets/theme-audio/theme-audio.widget.php' );
require_once get_parent_theme_file_path( '/widgets/social-links/social-links.widget.php' );

add_action( 'widgets_init', function(){
  register_widget( 'Theme_Audio_Widget' );
  register_widget( 'Social_Links_Widget' );
});
