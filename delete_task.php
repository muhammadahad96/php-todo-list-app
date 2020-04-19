<?php

include('db.php');

if ($_POST["task_list_id"]) {
  $data = array(
    ':task_list_id' => $_POST['task_list_id']
  );

  $query = "DELETE FROM task_list WHERE task_list_id = :task_list_id";
  $stmt = $connect->prepare($query);

  if ($stmt->execute($data)) {
    echo 'Done';
  }
}
