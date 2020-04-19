<?php

include('db.php');

if ($_POST["task_list_id"]) {
  $data = array(
    ':task_status'  => 'yes',
    ':task_list_id' => $_POST["task_list_id"]
  );

  $query = " UPDATE task_list SET task_status = :task_status WHERE task_list_id = :task_list_id";
  $stmt = $connect->prepare($query);

  if ($stmt->execute($data)) {
    echo 'Done';
  }
}
