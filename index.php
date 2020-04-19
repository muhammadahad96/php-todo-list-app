<?php

include('db.php');

$query = "SELECT * FROM task_list WHERE user_id = '" . $_SESSION["user_id"] . "' ORDER BY task_list_id DESC";
$stmt = $connect->prepare($query);
$stmt->execute();
$result = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Developed To-Do List in PHP using Ajax</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
    body {
      font-family: 'Comic Sans MS';
    }

    .list-group-item {
      font-size: 26px;
    }
  </style>
</head>

<body>

  <br />
  <br />
  <div class="container">
    <h1 style="text-align: center">Developed To-Do List in PHP using Ajax</h1>
    <br />
    <div class="panel panel-default">
      <div class="panel-heading">
        <div class="row">
          <div class="col-md-9">
            <h3 class="panel-title">My To-Do List</h3>
          </div>
          <div class="col-md-3">

          </div>
        </div>
      </div>
      <div class="panel-body">
        <form method="POST" id="to_do_form">
          <span id="message"></span>
          <div class="input-group">
            <input type="text" name="task_name" id="task_name" class="form-control input-lg" autocomplete="off" placeholder="Title..." />
            <div class="input-group-btn">
              <button type="submit" name="submit" id="submit" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-plus"></span></button>
            </div>
          </div>
        </form>
        <br />
        <div class="list-group">
          <?php
          foreach ($result as $row) {
            $style = '';
            if ($row["task_status"] == 'yes') {
              $style = 'text-decoration: line-through';
            }
            echo '<a href="#" style="' . $style . '" class="list-group-item" id="list-group-item-' . $row["task_list_id"] . '" data-id="' . $row["task_list_id"] . '">' . $row["task_details"] . ' <span class="badge" data-id="' . $row["task_list_id"] . '">X</span></a>';
          }
          ?>
        </div>
      </div>
    </div>
  </div>

</body>

</html>

<script>
  $(document).ready(function() {
    $(document).on("submit", "#to_do_form", function(e) {
      // prevents page refresh
      e.preventDefault();

      if ($('#task_name').val() == "") {
        $('#message').html('<div class="alert alert-danger">Enter Task Details</div>');
        return false;
      } else {
        $('#submit').attr("disbled", 'disabled');
        $.ajax({
          url: 'add_task.php',
          method: 'POST',
          data: $(this).serialize(),
          // serialize = convert form data into url encoded string
          success: function(data) {
            $('#submit').attr('disabled', false);
            // reset form input
            $('#to_do_form')[0].reset();
            // prepend = insert content at the beginning of each element
            $('.list-group').prepend(data);
          }

        })

      }

    });

    $(document).on('click', '.list-group-item', function() {
      var task_list_id = $(this).data('id');
      $.ajax({
        url: "update_task.php",
        method: "POST",
        data: {
          task_list_id: task_list_id
        },
        success: function(data) {
          $('#list-group-item-' + task_list_id).css('text-decoration', 'line-through');
        }
      })
    });

    $(document).on('click', '.badge', function() {
      var task_list_id = $(this).data('id');
      $.ajax({
        url: "delete_task.php",
        method: "POST",
        data: {
          task_list_id: task_list_id
        },
        success: function(data) {
          $('#list-group-item-' + task_list_id).fadeOut('slow');
        }
      })
    });

  });
</script>