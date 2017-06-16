<?php
  require_once('../config.php');
  session_start();

  $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

  if ($conn->connect_error) {
    http_response_code(500);
    die("Database connection failed: " . $conn->connect_error);
  }

  $stmt = "SELECT * from news ORDER BY created DESC";

  $result = $conn->query($stmt);

  if(!$result){
    http_response_code(500);
    // var_dump($result);
    die('Error with query!');
  }

  if($result->num_rows === 0){
    http_response_code(400);
    die('Student not found');
  }

  $surveys = $result->fetch_all(MYSQLI_ASSOC);

  $jsonResult = json_encode($surveys);

  http_response_code(200);
  die($jsonResult);

?>
