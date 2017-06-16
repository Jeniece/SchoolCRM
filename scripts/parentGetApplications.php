<?php

  require_once('../config.php');
  #Get the applications of students that are children of the currently logged in parent.
  session_start();

  if(!isset($_SESSION['user']['id']) || empty($_SESSION['user']['id'])){
    die('Could not retrieve information for current user.');
  }


  $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

  if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
  }

  $id = $_SESSION['user']['id'];

  $query = "SELECT * FROM studentparent
            INNER JOIN student
            ON studentparent.student_id=student.id
            WHERE studentparent.parent_id=$id";

  $result = $conn->query($query);

  if(!$result){
    http_response_code(500);
    die('Error with query!');
  }

  if($result->num_rows === 0){
    http_response_code(400);
    die('No applications found');
  }

  $applications = $result->fetch_all(MYSQLI_ASSOC);
  $jsonResult = json_encode($applications);
  http_response_code(200);
  die($jsonResult);

?>
