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
    $('.wp-to-do-list-form button').on('click', function (event) {
      event.preventDefault()

      var wrapperID = $(this).closest('.todo-list').attr('id')
      var $noTaskLine = $(this).closest('.todo-list').find('h5.no-task-line')

      var userID = wrapperID.replace('-wrapper', '-user')
      var newTaskID = wrapperID.replace('-wrapper', '-task')

      var wrapperInputVal = $('input#' + wrapperID).val()
      var userInputVal = $('input#' + userID).val()
      var newTaskVal = $('input#' + newTaskID).val()

      var dataJSON = {
        action: 'render_ajax',
        nonce: wpTodoListAjax.nonce,
        wrapper_id: wrapperInputVal,
        user_id: userInputVal,
        new_task: newTaskVal,
      }

      $.ajax({
        url: wpTodoListAjax.ajaxURL,
        nonce: wpTodoListAjax.nonce,
        type: 'POST',
        data: dataJSON,
        success: function (response) {
          let responseObj = JSON.parse(response)
          renderNewTask(responseObj)

          $('input#' + newTaskID).val('')
          $noTaskLine.hide()
        },
        error: function (xhr, status, error) {
          console.log('Status: ' + xhr.status)
          console.log('Error: ' + xhr.responseText)
        },
      })
    })

    checkboxStatusChange()
  })

  let renderNewTask = (responseObj) => {
    // console.log(responseObj)

    let wrapperID = responseObj.wrapper_id
    // console.log(wrapperID)
    const wrapper = document.querySelector('#' + wrapperID + '-wrapper')
    // console.log(wrapper)
    const tasksContainer = wrapper.querySelector('.tasks')
    // console.log(tasksContainer)
    const taskTemplate = document.getElementById('task-template')
    // console.log(taskTemplate)
    const taskElement = document.importNode(taskTemplate.content, true)
    const checkbox = taskElement.querySelector('input')
    const checkboxID = wrapperID + '-task-' + responseObj.task_id
    checkbox.id = checkboxID
    checkbox.checked = responseObj.task_status
    const label = taskElement.querySelector('label')
    label.htmlFor = checkboxID
    label.append(responseObj.task_name)
    tasksContainer.appendChild(taskElement)
    checkboxStatusChange('#' + checkboxID)
  }

  let checkboxStatusChange = (checkboxID = 'input[type="checkbox"]') => {
    let currentCheckboxObj = $(checkboxID)
    $(currentCheckboxObj, currentCheckboxObj + ' label').on(
      'click',
      function (event) {
        // console.log(event)
        let wrapperID = $(this).closest('.todo-list').attr('id')
        // console.log(wrapperID)
        let replaceableString = wrapperID.replace('-wrapper', '-task-')
        // console.log(replaceableString)
        var currentTaskID = event.target.id
        // console.log(currentTaskID)
        var currentTaskIDInt = parseInt(
          currentTaskID.replace(replaceableString, ''),
          10
        )
        // console.log(currentTaskIDInt)
        var currentTaskCheckbox = document.getElementById(currentTaskID)
        var currentTaskStatus = event.target.checked
        var dataCheckBoxJSON = {
          action: 'render_status_ajax',
          nonce: wpTodoListAjax.nonce,
          task_id: currentTaskIDInt,
          task_status: currentTaskStatus ? 'completed' : 'incomplete',
        }

        // console.log(dataCheckBoxJSON)

        $.ajax({
          url: wpTodoListAjax.ajaxURL,
          nonce: wpTodoListAjax.nonce,
          type: 'POST',
          data: dataCheckBoxJSON,
          success: function (response) {
            let responseObj = JSON.parse(response)

            let taskStatus = responseObj.task_status
            if (taskStatus === 'completed') {
              currentTaskCheckbox.setAttribute('checked', 'checked')
            } else {
              currentTaskCheckbox.removeAttribute('checked')
            }

            // console.log('data response = ' + responseObj)
            // console.log('task status = ' + responseObj.task_status)
            // console.log('success')
          },
          error: function (xhr, status, error) {
            console.log('Status: ' + xhr.status)
            console.log('Error: ' + xhr.responseText)
          },
        })
      }
    )
  }
})(jQuery)
