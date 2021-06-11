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

      var $newTaskObj = $('input#wp-to-do-list-task')
      var widgetInputVal = $('input#wp-to-do-list-widget').val()
      var userInputVal = $('input#wp-to-do-list-user').val()
      var newTaskVal = $newTaskObj.val()
      var dataJSON = {
        action: 'render_ajax',
        nonce: wpTodoListAjax.nonce,
        widget_id: widgetInputVal,
        user_id: userInputVal,
        new_task: newTaskVal,
      }

      console.dir('data json = ' + dataJSON)

      $.ajax({
        url: wpTodoListAjax.ajaxURL,
        nonce: wpTodoListAjax.nonce,
        type: 'POST',
        data: dataJSON,
        success: function (response, eventType) {
          let responseObj = JSON.parse(response)
          renderNewTask(responseObj)
          $newTaskObj.val('')
          console.log('data response = ' + response)
          console.log('success')
        },
        error: function (xhr, status, error) {
          console.log('Status: ' + xhr.status)
          console.log('Error: ' + xhr.responseText)
        },
      })
    })

    $('input[type=checkbox], input[type=checkbox] label').on(
      'click',
      function (event) {
        var currentTaskID = event.target.id
        var currentTaskIDInt = parseInt(
          currentTaskID.replace(/[^0-9]/g, ''),
          10
        )

        var currentTaskCheckbox = document.getElementById(currentTaskID)
        var currentTaskStatus = event.target.checked
        var dataCheckBoxJSON = {
          action: 'render_status_ajax',
          nonce: wpTodoListAjax.nonce,
          task_id: currentTaskIDInt,
          task_status: currentTaskStatus ? 'completed' : 'incomplete',
        }

        console.log(dataCheckBoxJSON)

        $.ajax({
          url: wpTodoListAjax.ajaxURL,
          nonce: wpTodoListAjax.nonce,
          type: 'POST',
          data: dataCheckBoxJSON,
          success: function (response) {
            let responseObj = JSON.parse(response)(
              responseObj.task_status === 'completed'
            )
              ? currentTaskCheckbox.setAttribute('checked', 'checked')
              : currentTaskCheckbox.removeAttribute('checked')
            console.log('data response = ' + responseObj)
            console.log('task status = ' + responseObj.task_status)
            console.log('success')
          },
          error: function (xhr, status, error) {
            console.log('Status: ' + xhr.status)
            console.log('Error: ' + xhr.responseText)
          },
        })
      }
    )
  })

  let renderNewTask = (responseObj) => {
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
