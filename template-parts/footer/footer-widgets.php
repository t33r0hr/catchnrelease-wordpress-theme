<?php
/**
 * Displays footer widgets if assigned
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?>

<?php
if ( is_active_sidebar( 'sidebar-start' ) || is_active_sidebar( 'sidebar-center' ) || is_active_sidebar( 'sidebar-end' ) ) :
?>

	<aside class="widget-area" role="complementary" aria-label="<?php esc_attr_e( 'Footer', 'twentyseventeen-cnr' ); ?>">
		<?php
		if ( true || is_active_sidebar( 'sidebar-start' ) ) { ?>
			<div class="widget-column footer-widget-start">
				<?php dynamic_sidebar( 'sidebar-start' ); ?>
			</div>
		<?php } ?>
		 
		<?php if ( true || is_active_sidebar( 'sidebar-center' ) ) { ?>
			<div class="widget-column footer-widget-center">
				<?php dynamic_sidebar( 'sidebar-center' ); ?>
			</div>
		<?php } ?>
		
		<?php if ( true || is_active_sidebar( 'sidebar-end' ) ) { ?>
			<div class="widget-column footer-widget-end">
				<?php dynamic_sidebar( 'sidebar-end' ); ?>
			</div>
		<?php } ?>
		
	</aside><!-- .widget-area -->

	

<?php endif; ?>


<?php
if ( is_active_sidebar( 'sidebar-footer-navigation' ) ) :
?>

	<aside class="widget-area" role="complementary" aria-label="<?php esc_attr_e( 'Footer Navigation', 'twentyseventeen-cnr' ); ?>">
		<?php
		if ( is_active_sidebar( 'sidebar-footer-navigation' ) ) { ?>
			<div class="widget-column footer-navigation">
				<?php dynamic_sidebar( 'sidebar-footer-navigation' ); ?>
			</div>
		<?php } ?>
		 		
	</aside><!-- .widget-area -->

	

<?php endif; ?>
