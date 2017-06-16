<?php
  require_once('../config.php');
  session_start();

  $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

  if ($conn->connect_error) {
    http_response_code(500);
    die("Database connection failed: " . $conn->connect_error);
  }

  $prepareString = 'INSERT INTO student (fname, mname, lname, age, gender, nationality, religion, enrollment_year, is_complete, birth_certificate, photo_id) VALUES(?,?,?,?,?,?,?,?,?,?,?);';

  //Create prepare statement
  if(!($stmt = $conn -> prepare($prepareString))){
    echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
    die();
  }

  if(!isset($_POST['fname']) || empty($_POST['fname'])){
    http_response_code(400);
    die('The first name is required');
  }
  //save the student data
  // var_dump($_POST);
  $fname = $_POST['fname'];
  $mname = $_POST['mname'];
  $lname = $_POST['lname'];
  $age = $_POST['age'];
  $gender = $_POST['gender'];
  $religion = $_POST['religion'];
  $nationality = $_POST['nationality'];
  $enrollmentYear = $_POST['e_year'];
  $iscomplete = false;
  $certificate_path = '';
  $identity_path = '';

  //get the id from the database
  if (!$stmt->bind_param("sssisssiiss", $fname, $mname, $lname, $age, $gender, $nationality, $religion, $enrollmentYear, $iscomplete, $certificate_path, $identity_path)) {
    http_response_code(500);
    die("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
  }

  /*execute bound statement*/
  if (!$stmt->execute()) {
    http_response_code(500);
    die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
  }

  $stmt->close();
?>
