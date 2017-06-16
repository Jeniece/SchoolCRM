<?php
  require_once('../config.php');
  session_start();
  // http_response_code(200);
  // print_r($_POST);

  if(!isset($_GET["survey_id"]) && empty($_GET["survey_id"])){
    die("Survey id missing");
  }

  //Get survey from the id
  $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

  if ($conn->connect_error) {
    http_response_code(500);
    die("Database connection failed: " . $conn->connect_error);
  }

  $id = $_GET["survey_id"];
  // $id = 2;

  $stmt = "SELECT * FROM survey WHERE id=$id";
  // echo $queryString;
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
  $survey = $surveys[0];

  //survey is an array that contains the data returned from the database for the survey that matches the sent id

  $file_path = $survey["file_path"];
  $file_name = $survey["name"];
  header('Content-Type: application/octet-stream');
  header("Content-Transfer-Encoding: Binary");
  header("Content-disposition: attachment; filename=\"" . basename($file_name) . "\"");
  readfile($file_path);

?>
