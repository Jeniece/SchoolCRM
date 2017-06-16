<?php
  require_once('../config.php');
  session_start();

  // echo date("Y");
  // die();
  if(!isset($_GET['id']) || empty($_GET['id'])){
    http_response_code(500);
    die('Could not find student id');
  }

  $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

  if ($conn->connect_error) {
    http_response_code(500);
    die("Database connection failed: " . $conn->connect_error);
  }

  $academicYear;
  // $studentId = 12;
  $studentId = $_GET['id'];

  // if(!isset($_GET['academic_year']) || empty($_GET['academic_year'])){
  //   $academicYear = date("Y");
  // } else {
  //   $academicYear = $_GET['academic_year'];
  // }

  /*

    Get records from studentsubject table.
    Get the name instead of the student id.
    Get the subject name instead of the subject id.
  */
  $stmt = "
  SELECT ss.percentage, ss.grade, ss.notes, ss.academic_year, subject.name as subject_name FROM studentsubject as ss
  INNER JOIN student ON ss.student_id = student.id
  INNER JOIN subject ON ss.subject_id = subject.id
  WHERE student.id=$studentId
  ";

  // echo $stmt;
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

  $records = $result->fetch_all(MYSQLI_ASSOC);
  $jsonResult = json_encode($records);

  // print_r($applications);
  http_response_code(200);
  die($jsonResult);

?>
