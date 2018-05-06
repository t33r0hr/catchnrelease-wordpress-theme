<?php
/**
 * Catch&Release: Theme Audio Widget
 *
 * @package Twenty_eventeen-CNR
 * @since 1.0
 */

/** If this file is called directly, abort. */
if ( !defined( 'ABSPATH' ) ) {
  die;
}

if ( !class_exists( 'Theme_Audio_Widget' ) ) {

  function debug_obj ( $label, $obj ) {

    echo '<!-- // Debug "' . $label . '" ';
    print_r($obj);
    echo '-->';

  }

  class Theme_Audio_Widget extends WP_Widget_Media {

    public function __construct() {

      parent::__construct( 'theme_audio_widget', __('Theme Audio'), array(
        'description' => __('Theme audio playback widget for background music.')
      ) );



      $this->l10n = array_merge( $this->l10n, array(
        'no_media_selected' => __( 'No audio selected' ),
        'add_media' => _x( 'Add Audio', 'label for button in the audio widget' ),
        'replace_media' => _x( 'Replace Audio', 'label for button in the audio widget; should preferably not be longer than ~13 characters long' ),
        'edit_media' => _x( 'Edit Audio', 'label for button in the audio widget; should preferably not be longer than ~13 characters long' ),
        'missing_attachment' => sprintf(
          /* translators: %s: URL to media library */
          __( 'We can&#8217;t find that audio file. Check your <a href="%s">media library</a> and make sure it wasn&#8217;t deleted.' ),
          esc_url( admin_url( 'upload.php' ) )
        ),
        /* translators: %d: widget count */
        'media_library_state_multi' => _n_noop( 'Audio Widget (%d)', 'Audio Widget (%d)' ),
        'media_library_state_single' => __( 'Audio Widget' ),
        'unsupported_file_type' => __( 'Looks like this isn&#8217;t the correct kind of file. Please link to an audio file instead.' ),
      ) );

    }
  
    /**
     * Get schema for properties of a widget instance (item).
     *
     * @since  4.8.0
     *
     * @see WP_REST_Controller::get_item_schema()
     * @see WP_REST_Controller::get_additional_fields()
     * @link https://core.trac.wordpress.org/ticket/35574
     * @return array Schema for properties.
     */
    public function get_instance_schema() {
      $schema = array_merge(
        parent::get_instance_schema(),
        array(
          'preload' => array(
            'type' => 'string',
            'enum' => array( 'none', 'auto', 'metadata' ),
            'default' => 'none',
            'description' => __( 'Preload' ),
          ),
          'loop' => array(
            'type' => 'boolean',
            'default' => false,
            'description' => __( 'Loop' ),
          ),
        )
      );

      foreach ( wp_get_audio_extensions() as $audio_extension ) {
        $schema[ $audio_extension ] = array(
          'type' => 'string',
          'default' => '',
          'format' => 'uri',
          /* translators: %s: audio extension */
          'description' => sprintf( __( 'URL to the %s audio source file' ), $audio_extension ),
        );
      }

      debug_obj('Schema', $schema);
      $this->debug_me();

      return $schema;
    }



    
    public function debug_me () {

      debug_obj('Theme_Audio_Widget',array(
        'id_base' => $this->id_base,
        'registered' => $this->registered,
        'number' => $this->number,
        'widget_options' => $this->widget_options,
        'l10n' => $this->l10n
      ));

    }


    /**
     * Render the media on the frontend.
     *
     * @since  4.8.0
     *
     * @param array $instance Widget instance props.
     * @return void
     */
    public function render_media( $instance ) {
      $instance = array_merge( wp_list_pluck( $this->get_instance_schema(), 'default' ), $instance );
      $attachment = null;

      if ( $this->is_attachment_with_mime_type( $instance['attachment_id'], $this->widget_options['mime_type'] ) ) {
        $attachment = get_post( $instance['attachment_id'] );
      }

      if ( $attachment ) {
        $src = wp_get_attachment_url( $attachment->ID );
      } else {
        $src = $instance['url'];
      }

      echo wp_audio_shortcode(
        array_merge(
          $instance,
          compact( 'src' )
        )
      );
    }

    /*public function form() {
      return parent::form();
    }*/


    /**
     * Enqueue preview scripts.
     *
     * These scripts normally are enqueued just-in-time when an audio shortcode is used.
     * In the customizer, however, widgets can be dynamically added and rendered via
     * selective refresh, and so it is important to unconditionally enqueue them in
     * case a widget does get added.
     *
     * @since 4.8.0
     */
    public function enqueue_preview_scripts() {
      /** This filter is documented in wp-includes/media.php */
      if ( 'mediaelement' === apply_filters( 'wp_audio_shortcode_library', 'mediaelement' ) ) {
        wp_enqueue_style( 'wp-mediaelement' );
        wp_enqueue_script( 'wp-mediaelement' );
      }
    }

    /**
     * Loads the required media files for the media manager and scripts for media widgets.
     *
     * @since 4.8.0
     */
    public function enqueue_admin_scripts() {
      parent::enqueue_admin_scripts();

      wp_enqueue_style( 'wp-mediaelement' );
      wp_enqueue_script( 'wp-mediaelement' );

      $handle = 'media-audio-widget';
      wp_enqueue_script( $handle );

      $exported_schema = array();
      foreach ( $this->get_instance_schema() as $field => $field_schema ) {
        $exported_schema[ $field ] = wp_array_slice_assoc( $field_schema, array( 'type', 'default', 'enum', 'minimum', 'format', 'media_prop', 'should_preview_update' ) );
      }
      wp_add_inline_script(
        $handle,
        sprintf(
          'wp.mediaWidgets.modelConstructors[ %s ].prototype.schema = %s;',
          wp_json_encode( $this->id_base ),
          wp_json_encode( $exported_schema )
        )
      );

      wp_add_inline_script(
        $handle,
        sprintf(
          '
            wp.mediaWidgets.controlConstructors[ %1$s ].prototype.mime_type = %2$s;
            wp.mediaWidgets.controlConstructors[ %1$s ].prototype.l10n = _.extend( {}, wp.mediaWidgets.controlConstructors[ %1$s ].prototype.l10n, %3$s );
          ',
          wp_json_encode( $this->id_base ),
          wp_json_encode( $this->widget_options['mime_type'] ),
          wp_json_encode( $this->l10n )
        )
      );
    }

    /**
     * Render form template scripts.
     *
     * @since 4.8.0
     */
    public function render_control_template_scripts() {
      parent::render_control_template_scripts()
      ?>
      <script type="text/html" id="tmpl-wp-theme-audio-widget-audio-preview">
        <# if ( data.error && 'missing_attachment' === data.error ) { #>
          <div class="notice notice-error notice-alt notice-missing-attachment">
            <p><?php echo $this->l10n['missing_attachment']; ?></p>
          </div>
        <# } else if ( data.error ) { #>
          <div class="notice notice-error notice-alt">
            <p><?php _e( 'Unable to preview media due to an unknown error.' ); ?></p>
          </div>
        <# } else if ( data.model && data.model.src ) { #>
          <?php wp_underscore_audio_template() ?>
        <# } #>
      </script>
      <?php
    }


    public function widget ( $args, $instance ) {

      echo '<!-- // widget-debug';
      echo 'Args';
      print_r($args);
      echo 'Instance';
      print_r($instance);

      echo '--!>';

    }

  }

  add_action( 'widgets_init', function(){
    register_widget( 'Theme_Audio_Widget' );
  });

}