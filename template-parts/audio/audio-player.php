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

  $buttons = array( 'play', 'pause' );

  $stateLabels = array(
    'play' => _x( 'theme state: play', 'Audio player label for state "play".', 'twentyseventeen-cnr' ),
    'pause' => _x( 'theme state: pause', 'Audio player label for state "pause".', 'twentyseventeen-cnr' )
  );

  $theme_state_format = 'theme state: %s';
  
  /* Render Buttons */

  foreach ( $buttons as $i => $key ) {
    ?>
      <button type="button" class="<?php echo $key; ?>">
          
        <?php 
          echo twentyseventeen_get_svg( array( 'icon' => $key ) );
        ?>
        <span class="button-label button-label-<?php echo $key; ?>">
          <?php echo $stateLabels[$key]; ?>
        </span>

      </button>
    <?php
  } ?>

      

</div>