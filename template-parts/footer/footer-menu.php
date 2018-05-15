<?php
/**
 * Displays footer navigation menu if assigned
 *
 * @package WordPress
 * @subpackage Catch & Release
 * @since 1.5.4
 * @version 1.5.4
 */

?>

<?php if ( has_nav_menu( 'futher' ) ) : ?>
  <nav class="further-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Further Links Menu', 'twentyseventeen-cnr' ); ?>">
    <?php
      wp_nav_menu( array(
        'theme_location' => 'further',
        'menu_class'     => 'further-links-menu',
        'depth'          => 1,
        'link_before'    => '<span class="screen-reader-text">',
        'link_after'     => '</span>',
      ) );
    ?>
  </nav><!-- .social-navigation -->
<?php endif;

