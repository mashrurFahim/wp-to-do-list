<?php



?>
<div id='<?php echo $shortcode_id; ?>'>
  <h3><?php echo $data['title']; ?></h3>
  <div class="todo-list">  
    <div class="todo-body">
      <?php if(!empty($all_tasks)) : ?>
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
      <?php else: ?>
      <h5><?php echo __('No Task To Show', 'wp-to-do-list'); ?></h5>
      <?php endif; ?>
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
              value="<?php echo $data['user_id'] ?>"
              id="wp-to-do-list-user"
            />
            
            <input 
              type="hidden"
              name="wp_to_do_list[widget_id]"
              value="<?php echo $shortcode_id; ?>"
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
</div>

  <template id="task-template">
    <div class="task">
      <input type="checkbox" />
      <label>
        <span class="custom-checkbox"></span>
      </label>
    </div>
  </template>