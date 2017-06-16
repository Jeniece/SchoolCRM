<?php
  require_once('../config.php');
  session_start();
  /*
    Student Search
  */

  $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

  if ($conn->connect_error) {
    http_response_code(500);
    die("Database connection failed: " . $conn->connect_error);
  }

  if(!isset($_POST['fname']) && empty($_POST['fname'])){
    http_response_code(400);
    die('First name missing');
  }

  if(!isset($_POST['mname']) && empty($_POST['mname'])){
    http_response_code(400);
    die('Middle name missing');
  }

  if(!isset($_POST['lname']) && empty($_POST['lname'])){
    http_response_code(400);
    die('Last name missing');
  }

  $fname=$_POST['fname'];
  $mname=$_POST['mname'];
  $lname=$_POST['lname'];

  // print_r($_POST);
  $queryString = "SELECT * FROM student WHERE fname='$fname' AND mname='$mname' AND lname='$lname'";
  // echo $queryString;
  $result = $conn->query($queryString);

  if(!$result){
    http_response_code(500);
    var_dump($result);
    die('Error with query!');
  }

  if($result->num_rows === 0){
    http_response_code(400);
    die('Student not found');
  }

  //student data.
  $students = $result->fetch_all(MYSQLI_ASSOC);

  //have to get the parent data for each student
  for($i=0; $i < count($students); $i++){
    $student = $students[$i];
    // var_dump($student);
    $id = $student['id'];
    $parentQuery = "SELECT parent.email, parent.fname, parent.mname, parent.lname, studentparent.relation FROM studentparent
                    INNER JOIN parent ON studentparent.parent_id=parent.id WHERE student_id=$id";

    // echo $parentQuery;
    $parentResult = $conn->query($parentQuery);

    if(!$parentResult){
      http_response_code(500);
      die('Error with parent query');
    }

    $parents = [];
    if($parentResult->num_rows !== 0){
      $parents = $parentResult->fetch_all(MYSQLI_ASSOC);
      // var_dump($parents);
    }

    $students[$i]['parents'] = $parents;

  }

  http_response_code(200);
  $jsonResult = json_encode($students);
  die($jsonResult);

  // $prepareString = 'SELECT * FROM student WHERE fname=? AND lname=?';
  //
  // if(!($stmt = $conn -> prepare($prepareString))){
  //   http_response_code(500);
  //   echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
  //   die();
  // }
  //
  // if (!$stmt->bind_param("ss", $fname, $lname)){
  //   http_response_code(500);
  //   die("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
  // }
  //
  // if (!$stmt->execute()) {
  //   http_response_code(500);
  //   die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
  // }

  // $stmt->store_result();




?>
