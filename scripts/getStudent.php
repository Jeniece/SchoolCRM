<?php
  require_once('../config.php');

  session_start();

  if(!isset($_GET['id']) && empty($_GET['id'])){
    http_response_code(400);
    die('Id required');
  }

  $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

  if ($conn->connect_error) {
    http_response_code(500);
    die("Database connection failed: " . $conn->connect_error);
  }

  $id = $_GET['id'];

  $queryString = "SELECT * FROM student WHERE id=$id";
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
  die(json_encode($students));
?>
