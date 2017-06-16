<?php
  require_once('../config.php');
  session_start();
  /*Add the waitlisted student to the database*/

  $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

  if ($conn->connect_error) {
    http_response_code(500);
    die("Database connection failed: " . $conn->connect_error);
  }
  // $result = $conn->query('SHOW DATABASES');
  // var_dump($result->fetch_all());
  //
  // $result -> close();


  /*
    Insert data into database.
  */

  $prepareString = 'INSERT INTO waitlist (fname, mname, lname, age, gender, nationality, religion, expectedEnrollmentYear) VALUES(?,?,?,?,?,?,?,?);';

  //Create prepare statement
  if(!($stmt = $conn -> prepare($prepareString))){
    echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
    die();
  }

  $fname = $_POST['fname'];
  $mname = $_POST['mname'];
  $lname = $_POST['lname'];
  $age = $_POST['age'];
  $gender = $_POST['gender'];
  $religion = $_POST['religion'];
  $nationality = $_POST['nationality'];
  $expectedEnrollmentYear = $_POST['expectedSchoolYear'];

  if (!$stmt->bind_param("sssisssi", $fname, $mname, $lname, $age, $gender, $nationality, $religion, $expectedEnrollmentYear)) {
    http_response_code(500);
    die("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
  }

  /*execute bound statement*/
  if (!$stmt->execute()) {
    http_response_code(500);
    die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
  }


  /*get student id*/
  $prepareString = 'SELECT id from waitlist WHERE fname=? AND mname=? AND lname=? ORDER BY id DESC LIMIT 1';

  //Create prepare statement
  if(!($stmt = $conn -> prepare($prepareString))){
    http_response_code(500);
    echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
    die();
  }

  if (!$stmt->bind_param("sss", $fname, $mname, $lname)){
    http_response_code(500);
    die("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
  }

  $student_id = -1;

  $stmt->bind_result($student_id);

  if (!$stmt->execute()) {
    http_response_code(500);
    die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
  }

  $stmt->store_result();

  if(!$stmt->fetch()){
    http_response_code(500);
    die("Fetch failed: (" . $stmt->errno . ") " . $stmt->error);
  }

  if($student_id == -1){
    http_response_code(500);
    die('An error occurred');
}


  /*
  Link parent and student
  $p_id contains the student id and $parent_id contains the id of the currently loggged in parent
  */
  $parent_id = $_SESSION['user_id'];
  $relation = $_POST['relation'];

  $prepareString = 'INSERT INTO waitingstudentparent (student_id, parent_id, relation) VALUES(?,?,?);';

  //Create prepare statement
  if(!($stmt = $conn -> prepare($prepareString))){
    echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
    die();
  }

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
  // $stmt->close();
  http_response_code(200);
  die("Success");
?>
