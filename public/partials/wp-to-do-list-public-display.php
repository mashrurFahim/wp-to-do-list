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

$all_tasks = Wp_To_Do_List_Public::get_all_task_of_widget_of_single_user($user_id, $widget_id);


?>

<div class="todo-list">
  <div class="todo-body">
    <div class="tasks">
    <?php foreach($all_tasks as $task): ?>
      <div class="task" >
        <input 
          type="checkbox"
          id="task-<?php echo $task->task_id; ?>"
          <?php echo ($task->task_status == 'completed') ? 'checked=checked' : ''; ?>
        />
        <label for="task-<?php echo $task->task_id; ?>">
          <span class="custom-checkbox"></span>
          <?php echo $task->task_name; ?>
        </label>
      </div>
      <?php endforeach; ?>
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

<template id="task-template">
  <div class="task">
    <input type="checkbox" />
    <label>
      <span class="custom-checkbox"></span>
    </label>
  </div>
</template>