<?php

/**
 * The to do list widget class functionality.
 *
 * @link       https://github.com/mashrurFahim
 * @since      1.0.0
 *
 * @package    Wp_To_Do_List
 * @subpackage Wp_To_Do_List/includes
 */

/**
 * The to do list widget class functionality.
 *
 * Extends the wp widget functionality to create to do list
 * specific custom functionality.
 *
 * @package    Wp_To_Do_List
 * @subpackage Wp_To_Do_List/includes
 * @author     Mashrur Fahim <imashrurfahim@gmail.com>
 */
class Wp_To_Do_List_Widget extends WP_Widget {


  // Main constructor
  public function __construct()
  {
    parent::__construct(
      'wp-to-do-list-widget',
      __('WP TO DO List', 'wp-to-do-list'),
      array(
        'description' => __('Widget to do list', 'wp-to-do-list'),
      )
    );
  }
  
  // The widget form (for the backend )
	public function form( $instance ) {
    
    $options = get_option('wp-to-do-list');
		
    // Set widget defaults
    $defaults = array(
      'title'    => __('Simple Todo List', 'wp-to-do-list'),
      'enable_input' => $options['enable_widget_text_input'],
    );

    // Parse current settings with defaults
    extract( wp_parse_args( ( array ) $instance, $defaults ) ); ?>

    <?php // Widget Title ?>
    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title', 'wp-to-do-list' ); ?></label>
      <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>

    <?php // Widget Enable Input Field ?>
    <p>
      <input id="<?php echo esc_attr( $this->get_field_id( 'enable_input' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'enable_input' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $enable_input ); ?> />
      <label for="<?php echo esc_attr( $this->get_field_id( 'enable_input' ) ); ?>"><?php _e( 'Enable/Disable task entry field', 'wp-to-do-list' ); ?></label>
    </p>
    <?php
	}

	// Update widget settings
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
    $instance['title']  = isset( $new_instance['title'] ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
    $instance['enable_input'] = isset( $new_instance['enable_input'] ) ? 1 : false;
    return $instance;
	}

	// Display the widget
	public function widget( $args, $instance ) {
		

    extract($args);

    // Check the widget options
    $title    = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
    $enable_input = ! empty( $instance['enable_input'] ) ? $instance['enable_input'] : false;

    // WordPress core before_widget hook (always include )
    echo $before_widget;

    if ( $title ) {
      echo $before_title . $title . $after_title;
    }

    if(is_user_logged_in()) {
      $user_id = get_current_user_id();
    } else {
      $user_id = 0;
    }

    $all_tasks = Wp_To_Do_List_Public::get_all_task_of_wrapper_of_single_user($user_id, $widget_id);


    $options = get_option('wp-to-do-list');
    $enable_widget_text_input = $options['enable_widget_text_input'];


    $enable_input = ($enable_widget_text_input) ? $enable_input : $enable_widget_text_input ;

    $wrapper_id = $widget_id;

    // Widget Content
    include plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/wp-to-do-list-public-display.php';
    
    // WordPress core after_widget hook (always include )
    echo $after_widget;
	}
}