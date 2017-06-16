<?php
  require_once('../config.php');

  session_start();
  $_SESSION = array();
  // print_r($_POST);
/*
$DATABASE_USER='root';
$DATABASE_PASS='123ABC!@#defg';
$DATABASE_HOST='localhost';
$DATABASE_NAME='schoolcrm';
*/
  function loginParent() {
    $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

    if ($conn->connect_error) {
      die("Database connection failed: " . $conn->connect_error);
    }

    $prepareString = "SELECT id, email, activated, title, fname, mname, lname, age, landline,
    mobile, nationality, marital_status, address, business_name, business_address,
    business_phone, occupation, annual_income, gender, hasRegisteredStudent, hasCompletedInfo
    FROM parent WHERE email=? AND password=?";

    if(!($stmt = $conn -> prepare($prepareString))){
      echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
      http_response_code(500);
      die();
    }

    /*bind params*/
    if (!$stmt->bind_param("ss", $_POST['email'], $_POST['password'])) {
      echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
      http_response_code(500);
      die();
    }

    // if (!$stmt->bind_param("ss", $name, $pass)) {
    //   echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    //   die();
    // }
    $p_email = '';
    $p_id = '';
    $p_activated = 0;
    $title = '';
    $fname = '';
    $mname = '';
    $lname = '';
    $age = 0;
    $landline = '';
    $mobile = '';
    $nationality = '';
    $marital_status = '';
    $address = '';
    $business_name = '';
    $business_address = '';
    $business_phone = '';
    $occupation = '';
    $annual_income = '';
    $gender= '';
    $hasRegisteredStudent = 0;
    $hasCompletedInfo = 0;


    $stmt->bind_result($p_id, $p_email, $p_activated, $title, $fname, $mname, $lname, $age, $landline, $mobile, $nationality, $marital_status, $address, $business_name, $business_address, $business_phone, $occupation, $annual_income, $gender, $hasRegisteredStudent, $hasCompletedInfo);
    if (!$stmt->execute()) {
        http_response_code(500);
        die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
    }

    $stmt->store_result();

    if($stmt->num_rows === 0){
      http_response_code(401);
      die("Invalid Login Details");
    }

    if(!$stmt->fetch()){
      http_response_code(500);
      die("Fetch failed: (" . $stmt->errno . ") " . $stmt->error);
    }

    /*
      if activated go to home page else go to login page
    */
    if(!$p_activated){
      // var_dump($p_activated);
      http_response_code(400);
      die("Please Activate Your Account");
      // header("Location: http://localhost/schoolcrm/pages/login.php"); /* Redirect browser */
      // exit();
      // die('User not activated');
    } else {
      // echo 'Success!';
      // echo $p_id;
      $_SESSION['user']['id'] = $p_id;
      $_SESSION['user']['email'] = $p_email;
      $_SESSION['user']['title'] = $title;
      $_SESSION['user']['fname'] = $fname;
      $_SESSION['user']['mname'] = $mname;
      $_SESSION['user']['lname'] = $lname;
      $_SESSION['user']['age'] = $age;
      $_SESSION['user']['landline'] = $landline;
      $_SESSION['user']['mobile'] = $mobile;
      $_SESSION['user']['nationality'] = $nationality;
      $_SESSION['user']['marital_status'] = $marital_status;
      $_SESSION['user']['address'] = $address;
      $_SESSION['user']['business_name'] = $business_name;
      $_SESSION['user']['business_address'] = $business_address;
      $_SESSION['user']['business_phone'] = $business_phone;
      $_SESSION['user']['occupation'] = $occupation;
      $_SESSION['user']['annual_income'] = $annual_income;
      $_SESSION['user']['gender'] = $gender;
      $_SESSION['user']['hasRegisteredStudent'] = $hasRegisteredStudent;
      $_SESSION['user']['hasCompletedInfo'] = $hasCompletedInfo;
      $_SESSION['user']['type'] = "parent";
      // var_dump($_SESSION['user']);
      // die("User activated");
      // header("Location: http://localhost/schoolcrm/pages/parent/home.php");
      // exit();
    }
  }

  function loginTeacher(){
    $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

    if ($conn->connect_error) {
      die("Database connection failed: " . $conn->connect_error);
    }

    $prepareString = "SELECT id, email, fname, lname, is_active
    FROM teacher WHERE email=? AND password=?";

    if(!($stmt = $conn -> prepare($prepareString))){
      echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
      http_response_code(500);
      die();
    }

    /*bind params*/
    if (!$stmt->bind_param("ss", $_POST['email'], $_POST['password'])) {
      echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
      http_response_code(500);
      die();
    }

    // if (!$stmt->bind_param("ss", $name, $pass)) {
    //   echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    //   die();
    // }
    $email = '';
    $id = '';
    $is_active = 0;
    $fname = '';
    $lname = '';


    $stmt->bind_result($id, $email, $fname, $lname, $is_active);
    if (!$stmt->execute()) {
        http_response_code(500);
        die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
    }

    $stmt->store_result();

    if($stmt->num_rows === 0){
      http_response_code(401);
      die("Invalid Login Details");
    }

    if(!$stmt->fetch()){
      http_response_code(500);
      die("Fetch failed: (" . $stmt->errno . ") " . $stmt->error);
    }

    /*
      if activated go to home page else go to login page
    */
    if(!$is_active){
      // var_dump($p_activated);
      http_response_code(400);
      die("Please Activate Your Account");
      // header("Location: http://localhost/schoolcrm/pages/login.php"); /* Redirect browser */
      // exit();
      // die('User not activated');
    } else {
      $_SESSION['user']['id'] = $id;
      $_SESSION['user']['email'] = $email;
      $_SESSION['user']['fname'] = $fname;
      $_SESSION['user']['lname'] = $lname;
      $_SESSION['user']['type'] = 'teacher';

      // var_dump($_SESSION['user']);
      // die("User activated");
      // header("Location: http://localhost/schoolcrm/pages/teacher/home.php");
      // exit();
    }
  }

  if(!isset($_POST['email']) && empty($_POST['email'])){
    http_response_code(400);
    die('Email is empty!');
  }

  if(!isset($_POST['password']) && empty($_POST['password'])){
    http_response_code(400);
    die('Password is empty!');
  }

  // die($_POST['user_type']);
  if($_POST['user_type'] === 'parent'){
    // echo 'Parent';
    loginParent();
    die('parent');
  } else if($_POST['user_type'] === 'teacher'){
    // echo 'Teacher';
    loginTeacher();
    die('teacher');
  } else {
    http_response_code(400);
    die('Could not identify account type');
  }


  // printf('ID: %s Email: %s', $p_id, $p_email);
  // print_r($_SESSION);
  die();
?>
