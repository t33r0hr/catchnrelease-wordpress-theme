<?php
/**
 * Displays top navigation
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.2
 */

?>
<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Top Menu', 'twentyseventeen' ); ?>">
	<button class="menu-toggle" aria-controls="top-menu" aria-expanded="false">
		<?php
		echo twentyseventeen_get_svg( array( 'icon' => 'bars' ) );
		echo twentyseventeen_get_svg( array( 'icon' => 'close' ) );
		_e( 'Menu', 'twentyseventeen' );
		?>
	</button>

	<div class="navigation-wrapper">

		<?php wp_nav_menu( array(
			'theme_location' => 'top',
			'menu_id'        => 'top-menu',
		) ); ?>

		<?php
			if ( is_active_sidebar( 'navigation-sidebar-1' ) && true ) { ?>
				<div class="spacer"></div>

				<?php get_template_part( 'template-parts/audio/audio', 'player' ); ?>

				<!-- <div class="widget-column navigation-widget-1"> -->
					<?php dynamic_sidebar( 'navigation-sidebar-1' ); ?>
				<!-- </div> -->
		<?php } ?>

		<?php if ( ( twentyseventeen_is_frontpage() || ( is_home() && is_front_page() ) ) && has_custom_header() ) : ?>
			<a href="#content" class="menu-scroll-down"><?php echo twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ); ?><span class="screen-reader-text"><?php _e( 'Scroll down to content', 'twentyseventeen' ); ?></span></a>
		<?php endif; ?>

	</div><!-- .navigation-wrapper -->
</nav><!-- #site-navigation -->
