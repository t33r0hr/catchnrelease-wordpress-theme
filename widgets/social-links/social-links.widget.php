<?php
/**
 * Catch&Release: Social Links Widget
 *
 * @package Twenty_eventeen-CNR
 * @since 1.5.4
 */

if ( !class_exists( 'Social_Links_Widget' ) ) {

  class Social_Links_Widget extends WP_Widget {

    private static $BASE_ID = 'social_links_widget';

    public function __construct() {

      parent::__construct( Social_Links_Widget::$BASE_ID, __('Social Links', 'twentyseventeen-cnr' ), array(
        'classname' => Social_Links_Widget::$BASE_ID,
        'description' => __('Display Links to your social profiles.', 'twentyseventeen-cnr')
      ) );

    }

    protected function get_icon_ids () {

      return array(
        'facebook',
        'twitter',
        'youtube',
        'instagram'
      );

    }

    public function widget ($args, $instance) {

      echo $args['before_widget'];
      
      if ( !empty($instance['title']) ) {
        echo $args['before_title'];
        echo $args['after_title'];
      }

      $icon_ids = $this->get_icon_ids();

      echo '<ul class="cnr-social-icons" name="cnr_social_services">';
      //echo '<h4>' . __('Social Networks', 'twentyseventeen-cnr') . '</h4>';
      
      foreach ($icon_ids as $icon_id) {

        if ( $instance[$icon_id] ) {

          $caption = $instance[$icon_id.'_caption'];
          $link = $instance[$icon_id.'_link'];

          $this->render_icon($icon_id, $caption, $link);
          /*echo '<li><a href="#" class="cnr-social-icon ' . $icon_id . '">';
          echo twentyseventeen_get_svg( array( 'icon' => $icon_id ) );
          echo '</a></li>';*/

        }

        /*echo '<label class="' . $icon_id . '" for="' . $icon_key . '>">
          ' . $icon_id . '
          <input type="checkbox" name="cnr_social_icon_' . $icon_key . '">
        </label>';*/
      }
      echo '</ul>';
      /*echo '<code>' . var_dump($args) . '</code>';

      echo '<h3>Instance</h3>';
      echo '<code>' . var_dump($instance) . '</code>';*/

      echo $args['after_widget'];

    }

    public function render_icon ( $icon_id, $caption, $link ) { ?> 
        <li class="<?php echo esc_attr($this->get_field_id($icon_id)); ?>">
          <a href="<?php echo $link; ?>" target="_blank">
            <?php echo twentyseventeen_get_svg( array ( 'icon' => $icon_id ) ); ?>
            <span><?php echo $caption; ?></span>
          </a>
        </li>
      <?php
    }

    public function field ( $instance, $icon_id ) {

      $checked = $instance[$icon_id] ? 'checked' : '';
      $field_name = $this->get_field_name($icon_id);
      $field_id = $this->get_field_id($icon_id);

      echo '<h3>';
      echo '<input id="' . esc_attr($field_id) . 
      '" type="checkbox" name="' . esc_attr($field_name) .'" ' . 
      'change="cnr_toggle_social_form_group(this)" name="' . esc_attr($field_name) .'" ' . 
      $checked . '>';      
      
      echo '<label for="' . esc_attr($field_name) . '">' . $icon_id . '</label>';
      echo '</h3>';
      
      echo '<ul>';
      $caption_field_name = $this->get_field_name($icon_id . '_caption');
      $caption_field_id = $this->get_field_id($icon_id . '_caption');

      echo '<li>';
      echo '<label for="' . esc_attr($caption_field_name) . '">' . __('Link Caption', 'twentyseventeen-cnr') .  '</label>';
      echo '<input value="'.$instance[$icon_id.'_caption'].'" class="widefat" id="' . esc_attr($caption_field_id) . '" type="text" name="' . esc_attr($caption_field_name) .'">';      
      echo '</li>';


      $link_field_name = $this->get_field_name($icon_id . '_link');
      $link_field_id = $this->get_field_id($icon_id . '_link');

      echo '<li>';
      echo '<label for="' . esc_attr($link_field_name) . '">' . __('Link URL', 'twentyseventeen-cnr') . '</label>';
      echo '<input value="' . esc_url($instance[$icon_id.'_link']) . '" class="widefat" id="' . esc_attr($link_field_id) . '" type="text" name="' . esc_attr($link_field_name) .'">';  
      echo '</li>';
      echo '</ul>';


    }

    protected function debug_instance ($instance) {

      $icon_ids = $this->get_icon_ids();

      echo "<!--\n";
      
      foreach ($icon_ids as $icon_id) {
        echo 'icon_id: ' . $icon_id . "\n";

        $caption_key = $this->get_field_name($icon_id.'_caption');
        echo 'caption_key: ' . $caption_key . "\n";
        echo "value: " . $instance[$icon_id.'_caption'] . "\n";

        $link_key = $this->get_field_name($icon_id.'_link');
        echo 'link_key: ' . $link_key . "\n";
        echo "value: " . $instance[$icon_id.'_link'] . "\n";
        
      }

      echo "-->\n";
      
    }

    public function icon_selection ( $instance ) {

      $icon_ids = $this->get_icon_ids();
      
      echo '<ul class="cnr-social-links">';

      foreach ($icon_ids as $icon_id) {
        echo '<li class="' . $icon_id . '">';
        $this->field($instance, $icon_id);
        echo '</li>';
      }

      echo '</ul>';

    }
      
    public function form( $instance ) {

      $title = array_key_exists('title', $instance ) ? $instance['title'] : esc_html__( 'New title', 'text_domain' );
      //$this->debug_instance($instance);
      ?>
      <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label> 
      <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
      </p>
      <?php 
      $this->icon_selection($instance);
      echo '<script type="javascript">cnr_handle_social_links_form()</script>';
    }



    public function update( $new_instance, $old_instance ) {
      
      $instance = array();
      
      $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
      
      $icon_ids = $this->get_icon_ids();
      foreach ($icon_ids as $icon_id) {

        $instance[$icon_id] = $new_instance[$icon_id];
        $instance[$icon_id.'_caption'] = sanitize_text_field($new_instance[$icon_id.'_caption']);
        $instance[$icon_id.'_link'] = $new_instance[$icon_id.'_link'];

      }

      return $instance;
    }

    public function _register_one ( $number ) {
      parent::_register_one($number);

      add_action( 'admin_print_scripts-widgets.php', array( $this, 'enqueue_admin_scripts' ) );

    }


    public function enqueue_admin_scripts () {

      $handle = 'social-links-form';
      wp_enqueue_script( $handle, get_parent_theme_file_uri('/assets/js/' . $handle . '.js' ) );

    }


 }

}