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
		
    // Set widget defaults
    $defaults = array(
      'title'    => __('Simple Todo List', 'wp-to-do-list'),
      'enable_input' => '',
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

    // Widget Content
    ?>
    <div class="todo-list">
    
      <div class="todo-body">
        <div class="tasks">
          <div class="task">
            <input 
              type="checkbox"
              id="task-1"
            />
            <label for="task-1">
              <span class="custom-checkbox"></span>
              record todo list video
            </label>
          </div>
        </div>
        <?php if($enable_input) : ?>
        <div class="new-task-creator">
          <form action="">
              <input 
                type="text"
                class="new task"
                placeholder="new task name"
                aria-label="new task name"
              />
              <button class="btn create" aria-label="create new task">+</button>
            </form>
        </div>
        <?php endif; ?>
      </div>
    </div>

    <?php
    // WordPress core after_widget hook (always include )
    echo $after_widget;
	}
}