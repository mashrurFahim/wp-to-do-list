;(function ($) {
  'use strict'

  /**
   * All of the code for your admin-facing JavaScript source
   * should reside in this file.
   *
   * Note: It has been assumed you will write jQuery code here, so the
   * $ function reference has been prepared for usage within the scope
   * of this function.
   *
   * This enables you to define handlers, for when the DOM is ready:
   *
   * $(function() {
   *
   * });
   *
   * When the window is loaded:
   *
   * $( window ).load(function() {
   *
   * });
   *
   * ...and/or other possibilities.
   *
   * Ideally, it is not considered best practise to attach more than a
   * single DOM-ready or window-load handler for a particular page.
   * Although scripts in the WordPress core, Plugins and Themes may be
   * practising this, we should strive to set a better example in our own work.
   */

  $(function () {
    $('#wp-to-do-list-form button').on('click', function (event) {
      event.preventDefault() // Prevent the default form submit.

      //add our own ajax check as X-Requested-With is not always reliable
      // ajax_form_data = ajax_form_data + '&ajaxrequest=true&submit=Submit+Form'

      var $newTaskObj = $('input#wp-to-do-list-task')

      var nonceInputVal = $('input#wp-to-do-list-nonce').val()
      var widgetInputVal = $('input#wp-to-do-list-widget').val()
      var userInputVal = $('input#wp-to-do-list-user').val()
      var newTaskVal = $newTaskObj.val()

      var dataJSON = {
        action: 'render_ajax',
        nonce: nonceInputVal,
        widget_id: widgetInputVal,
        user_id: userInputVal,
        new_task: newTaskVal,
      }

      console.log(dataJSON)

      $.ajax({
        url: wpTodoListAjax.ajaxURL,
        nonce: nonceInputVal,
        type: 'POST',
        data: dataJSON,
        success: function (response) {
          renderNewTask(response)
          $newTaskObj.val('')
          console.log(response)
          console.log('success')
        },
        error: function (xhr, status, error) {
          console.log('Status: ' + xhr.status)
          console.log('Error: ' + xhr.responseText)
        },
      })
    })
  })

  let renderNewTask = (response) => {
    let responseObj = JSON.parse(response)
    console.log(responseObj)
    const widgetSection = document.querySelector('#' + responseObj.widget_id)
    console.log(widgetSection)
    const tasksContainer = widgetSection.querySelector('.tasks')
    console.log(tasksContainer)
    const taskTemplate = document.getElementById('task-template')
    console.log(taskTemplate)
    const taskElement = document.importNode(taskTemplate.content, true)
    const checkbox = taskElement.querySelector('input')
    checkbox.id = responseObj.task_id
    checkbox.checked = responseObj.task_status
    const label = taskElement.querySelector('label')
    label.htmlFor = responseObj.task_id
    label.append(responseObj.task_name)
    tasksContainer.appendChild(taskElement)
  }
})(jQuery)
