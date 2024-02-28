<footer class="footer">
  <div class=" text-center">
    Altair Code Challenge
  </div>
</footer>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> 
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="public/js/login-validation.js"></script>
  
  <script src="public/js/jquery-3.4.1.min.js" ></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script type="text/javascript">
    $(document).ready(function() {
    const taskBtn = $('#add-task'); //task button Selector
    const taskInput = $("#task"); // todo input selector
    const updateTaskModal = $("#modal") // update task modal selector
    const modalTaskInput = $("#modalInput"); // modal task input selector
    const taskUpdateBtn = $("#updateBtn"); // modal task update button selector
    var selectedId = null;

    const fetchSignup = () => {
      
    }

    const fetchTasks = () => {
      $.ajax({
          type: 'GET',
          url: 'http://localhost/altair_code_challenge/index.php?controller=task&function=fetch',
          success: function(res) {
              const parseRes = JSON.parse(res);
              const {
                  success,
                  tasks,
                  total
              } = parseRes;
              if (success) {
                var tasksHtml = '';
                if (total > 0) {
                  $('#total-tasks').html('Total Tasks: ' + total);
                  $.map(tasks, function(task, key) {
                  tasksHtml += '<li class="list-group-item d-flex justify-content-between align-items-center">' + task.task + '<span><a class="edit-task text-success mr-2" data-task-id="' + task.id + '" href="javascript:void(0)"> <i class="fa fa-edit"></i> </a> <a  class="del-task text-danger" data-task-id="' + task.id + ' " href="javascript:void(0)"> <i class="fas fa-trash-alt"></i> </a><span></li>'
                      });
                      $('#tasks-list').html(tasksHtml)
                  } else {
                      $('#total-tasks').html('Total Tasks: ' + 0);
                      $('#tasks-list').html('<li class="list-group-item d-flex justify-content-between align-items-center">No Tasks Found :)</li>')
                  }
              } else {
                  toastr.info('Unable to fetch tasks')
              }
                }
            })
        }

        fetchTasks();

        taskBtn.click(function() {
          const task = taskInput.val();
          if ($.trim(task).length > 0) {
            $.ajax({
              type: 'POST',
              url: 'http://localhost/altair_code_challenge/index.php?controller=task&function=create',
              data: {
                task
              },
              success: function(res) {
                const parseRes = JSON.parse(res);
                if (parseRes.success) {
                    taskInput.val(null);
                    fetchTasks();
                    toastr.success(parseRes.message)
                } else toastr.error(parseRes.message)
              }
            })
          } else {
            toastr.info('Please write task!!')
          }
        })

        $('#tasks-list').on('click', '.del-task', function() {
            const taskId = $(this).data('task-id');
            $.ajax({
                type: 'POST',
                url: `http://localhost/altair_code_challenge/index.php?controller=task&function=delete&id=${taskId}`,
                data: {
                    taskId
                },
                success: function(res) {
                    const parseRes = JSON.parse(res);
                    if (parseRes.success) {
                        fetchTasks();
                        toastr.success(parseRes.message)
                    } else toastr.error(parseRes.message)
                }
            })
        })

        $('#tasks-list').on('click', '.edit-task', function() {
            const taskId = $(this).data('task-id');
            selectedId = taskId;
            $.ajax({
                type: 'GET',
                url: `http://localhost/altair_code_challenge/index.php?controller=task&function=edit&id=${taskId}`,
                success: function(res) {
                    const parseRes = JSON.parse(res)
                    const {
                        success,
                        task
                    } = parseRes;

                    if (success) {
                        updateTaskModal.modal('show');
                        modalTaskInput.val(task);
                    }
                }
            })
        })

        taskUpdateBtn.click(function() {
            const task = modalTaskInput.val();;
            $.ajax({
                type: 'POST',
                url: 'http://localhost/altair_code_challenge/index.php?controller=task&function=update',
                data: {
                    taskId: selectedId,
                    task
                },
                success: function(res) {
                    const parseRes = JSON.parse(res);
                    if (parseRes.success) {
                        updateTaskModal.modal('hide');
                        toastr.success(parseRes.message);
                        fetchTasks();
                    } else toastr.error(parseRes.message)
                }
            })
        })
    })
  </script>


        
</body>
</html>