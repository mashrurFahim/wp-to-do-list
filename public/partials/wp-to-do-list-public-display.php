<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://github.com/mashrurFahim
 * @since      1.0.0
 *
 * @package    Wp_To_Do_List
 * @subpackage Wp_To_Do_List/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php

if(is_user_logged_in()) {
  $user_id = get_current_user_id();
} else {
  $user_id = 0;
}

$wp_to_do_list_nonce = wp_create_nonce( 'wp_to_do_list_nonce' );

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
        <form action="" method="POST" id="wp-to-do-list-form">
          <input
            type="hidden"
            name="action"
            value="render_ajax"
          />

          <input
            type="hidden"
            name="wp_to_do_list_nonce"
            value="<?php echo $wp_to_do_list_nonce ?>"
            id="wp-to-do-list-nonce"
          />
          
          <input 
            type="hidden"
            name="wp_to_do_list[user_id]"
            value="<?php echo $user_id ?>"
            id="wp-to-do-list-user"
          />
          
          <input 
            type="hidden"
            name="wp_to_do_list[widget_id]"
            value="<?php echo $widget_id ?>"
            id="wp-to-do-list-widget"
          />
          
          <input
            type="text"
            name="wp_to_do_list[new_task]"
            value=""
            class="new task"
            placeholder="new task name"
            aria-label="new task name"
            id="wp-to-do-list-task"
          />
          <button class="btn create" aria-label="create new task">+</button>
        </form>
      </div>
    <?php endif; ?>
  </div>
</div>