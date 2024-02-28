    <div class="container taskBackground">
      <header class="text-center text-light my-4">
          <h1 class="mb-4">Task List</h1>
      </header>

      <label for="addTask" class="text-light"> Add a new task... </label>
      <input class="form-control m-auto taskInput" type="text" id="task" name="task">
      <button type="button" class="btn btn-primary btn-block mt-2"  id="add-task">Add</button>
    </form>

    <p id='total-tasks'></p>
    <ul class="list-group todos mx-auto text-light" id="tasks-list">
    </ul>

    <!-- Edit Task Modal -->
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-primary font-weight-bold" id="exampleModalLabel">Edit Task</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" id="modalTaskForm">
              <label for="addTask"> Task </label>
              <input class="form-control" type="text" id="modalInput">
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" id="updateBtn">Update</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="js/login-validation.js"></script>


