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
<div id='<?php echo $wrapper_id; ?>-wrapper' class="todo-list">  
  <div class="todo-body">
    <div class="tasks">
    <?php if(!empty($all_tasks)) : ?>
    <?php foreach($all_tasks as $task): ?>
      <div class="task" >
        <input 
          type="checkbox"
          id="<?php echo $wrapper_id; ?>-task-<?php echo $task->task_id; ?>"
          <?php echo ($task->task_status == 'completed') ? 'checked=checked' : ''; ?>
        />
        <label for="<?php echo $wrapper_id; ?>-task-<?php echo $task->task_id; ?>">
          <span class="custom-checkbox"></span>
          <?php echo $task->task_name; ?>
        </label>
      </div>
      <?php endforeach; ?>
      <?php else: ?>
      <h5 class="no-task-line"><?php echo __('No Task To Show', 'wp-to-do-list'); ?></h5>
      <?php endif; ?>
    </div>
    <?php if($enable_input) : ?>
      <div class="new-task-creator">
        <form action="" method="POST" class="wp-to-do-list-form">
          <input
            type="hidden"
            name="action"
            value="render_ajax"
          />

          <input 
            type="hidden"
            name="wp_to_do_list[user_id]"
            value="<?php echo $user_id; ?>"
            id="<?php echo $wrapper_id; ?>-user"
          />
          
          <input 
            type="hidden"
            name="wp_to_do_list[wrapper_id]"
            value="<?php echo $wrapper_id; ?>"
            id="<?php echo $wrapper_id; ?>-wrapper"
          />
          
          <input
            type="text"
            name="wp_to_do_list[new_task]"
            value=""
            class="new task"
            placeholder="new task name"
            aria-label="new task name"
            id="<?php echo $wrapper_id; ?>-task"
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