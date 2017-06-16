<?php

  // var_dump($_POST);
  // die();
  /*
  Database connection
  */
  require_once('../config.php');
  session_start();
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

  $prepareString = 'UPDATE parent SET title=?, fname=?, mname=?, lname=?, gender=?, age=?,
  address=?, landline=?, mobile=?, occupation=?, annual_income=?, business_name=?, business_address=?, business_phone=?,
  marital_status=?, nationality=? WHERE id=?';

  //Create prepare statement
  if(!($stmt = $conn -> prepare($prepareString))){
    echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
    die();
  }

  $title = $_POST['title'];
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $mname = $_POST['mname'];
  $gender = $_POST['gender'];
  $age = $_POST['age'];
  $address = $_POST['address'];
  $landline = $_POST['landline'];
  $mobile = $_POST['mobile'];
  $occupation = $_POST['occupation'];
  $income = $_POST['income'];
  $bname = $_POST['bname'];
  $baddress = $_POST['baddress'];
  $bphone = $_POST['bphone'];
  $id = $_POST['user_id'];
  $marital_status = $_POST['marital_status'];
  $nationality = $_POST['nationality'];

  /*bind params*/
  if (!$stmt->bind_param("ssssssssssssssssi", $title, $fname, $mname, $lname, $gender, $age, $address, $landline,
      $mobile, $occupation, $income, $bname, $baddress, $bphone, $marital_status, $nationality, $id)) {
    http_response_code(500);
    die("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
  }

  /*execute bound statement*/
  if (!$stmt->execute()) {
    http_response_code(500);
    die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
  }

  http_response_code(200);
  die("Success");


?>
