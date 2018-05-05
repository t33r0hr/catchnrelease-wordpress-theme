<?php
/**
 * Displays audio player
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.2
 */

?>
<div class="widget-audio-player">
<?php
  
  foreach ( array( 'play', 'pause' ) as $i => $key ) {
    ?>
      <button type="button" class="<?php echo $key; ?>">
          
        <?php 
          echo twentyseventeen_get_svg( array( 'icon' => $key ) );
        ?>

      </button>
    <?php
  } ?>

      

</div>