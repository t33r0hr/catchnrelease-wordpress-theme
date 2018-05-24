<?php


function catchnrelease_svg_icon_shortcode ( $args ) {

  $atts = shortcode_atts( array (
    "icon" => "play",
    "width" => 32,
    "height" => 32
  ), $args );

  return twentyseventeen_get_svg( array( 'icon' => $atts['icon'], 'fallback' => true ) );

}

add_shortcode( 'svg_icon', 'catchnrelease_svg_icon_shortcode' );