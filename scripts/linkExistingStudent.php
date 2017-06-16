<?php
  require_once('../config.php');
  session_start();

  $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

  if ($conn->connect_error) {
    http_response_code(500);
    die("Database connection failed: " . $conn->connect_error);
  }

  if(!isset($_POST['student_id']) && empty($_POST['student_id'])){
    http_response_code(400);
    die('Student id is required');
  }
  if(!isset($_POST['parent_id']) && empty($_POST['parent_id'])){
    http_response_code(400);
    die('Parent id is required');
  }
  if(!isset($_POST['relation']) && empty($_POST['relation'])){
    http_response_code(400);
    die('Relation is required');
  }

  $student_id = $_POST['student_id'];
  $parent_id = $_POST['parent_id'];
  $relation = $_POST['relation'];

  $prepareString = 'INSERT INTO studentparent (student_id, parent_id, relation) VALUES(?,?,?);';

  //Create prepare statement
  if(!($stmt = $conn -> prepare($prepareString))){
    echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
    die();
  }


  $relation = $_POST['relation'];
  //get the id from the database
  if (!$stmt->bind_param("sss", $student_id, $parent_id, $relation)) {
    http_response_code(500);
    die("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
  }

  /*execute bound statement*/
  if (!$stmt->execute()) {
    http_response_code(500);
    die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
  }
  $stmt->close();

  http_response_code(200);
  die('Success')


?>
