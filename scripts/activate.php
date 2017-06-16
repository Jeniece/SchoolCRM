<?php

  // $conn = new mysqli('localhost', 'root', '123ABC!@#defg','schoolcrm');
  //
  // if ($conn->connect_error) {
  //   die("Database connection failed: " . $conn->connect_error);
  // }

  /*
    Activate the account linked to the token found in the link
  */
  require_once('../config.php');

  $token = $_GET["token"];
  $account_type = $_GET["type"];

  if(!$token){
    die("Invalid Token");
  }

  if(!$account_type){
    die("Missing Account Type");
  }

  $conn = new mysqli('localhost', 'root', '123ABC!@#defg','schoolcrm');

  if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
  }

  $prepareString = 'SELECT email, created FROM token WHERE token=?';

  if(!($stmt = $conn -> prepare($prepareString))){
    echo "Could not store token. Prepare failed: (" . $conn->errno . ") " . $conn->error;
    die();
  }

  $created = time();
  if (!$stmt->bind_param("s", $token)) {
    echo "Could not store token. Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    die();
  }

  $t_email = '';
  $t_created = 0;

  $stmt->bind_result($t_email, $t_created);
  if (!$stmt->execute()) {
      // http_response_code(500);
      die("Account activation. Execute failed: (" . $stmt->errno . ") " . $stmt->error);
  }

  $stmt->store_result();

  if($stmt->num_rows === 0){
    // http_response_code(401);
    die("Token Not Found");
  }

  if(!$stmt->fetch()){
    // http_response_code(500);
    die("Account Activation. Fetch failed: (" . $stmt->errno . ") " . $stmt->error);
  }

  $time_expired = time() - $t_created;

  if($time_expired > (60 * 5)){
    die("Token Expired");
  }

  $insertString = "";
  if($account_type == "teacher"){
    $insertString = 'UPDATE teacher SET is_active=? WHERE email=?';

  } else if($account_type == "parent"){
    $insertString = 'UPDATE parent SET activated=? WHERE email=?';
  } else {
    die("Invalid account type");
  }

  if(!($stmt = $conn -> prepare($insertString))){
    echo "Account Activation. Prepare failed: (" . $conn->errno . ") " . $conn->error;
    die();
  }
  $accountStatus = 1;

  if (!$stmt->bind_param("is", $accountStatus, $t_email)) {
    echo "Account Activation. Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    die();
  }

  if (!$stmt->execute()) {
      // http_response_code(500);
      die("Account Activation. Execute failed: (" . $stmt->errno . ") " . $stmt->error);
  }

  if($stmt->affected_rows == 0){
    die("Account Activation. Failed to activate user.");
  }

  // echo 'Success';
  header("Location: http://localhost/schoolcrm/pages/activated.php");
  exit();
?>
