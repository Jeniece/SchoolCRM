<?php
  // print_r($_POST);
  // echo $_POST['id'];
  require_once('../config.php');
  session_start();

  if(!isset($_POST['id']) && empty($_POST['id'])){
    http_response_code(400);
    die('Id required');
  }

  if(!isset($_POST['mode']) && empty($_POST['mode'])){
    http_response_code(400);
    die('Method required');
  }

  $id = $_POST['id'];
  $mode = $_POST['mode'];

  $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

  if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
  }

  $prepareString = '';

  if($mode === 'accept'){
    $prepareString = 'UPDATE student set is_accepted=1 WHERE id=?';
  } else {
    $prepareString = 'UPDATE student set is_accepted=0 WHERE id=?';
  }


  if(!($stmt = $conn -> prepare($prepareString))){
    echo "Could not store token. Prepare failed: (" . $conn->errno . ") " . $conn->error;
    die();
  }

  if (!$stmt->bind_param("i", $id)) {
    echo "Could not store token. Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    die();
  }

  if (!$stmt->execute()) {
      http_response_code(500);
      die("Account activation. Execute failed: (" . $stmt->errno . ") " . $stmt->error);
  }


  http_response_code(200);
  die("Success");
?>
