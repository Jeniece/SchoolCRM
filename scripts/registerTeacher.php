<?php
  require '../vendor/autoload.php'; //loads the php libraries in the vendor folder. These libs/packages were installed via composer

  require("../pkgs/sendgrid-php/sendgrid-php.php");
  require_once('../config.php');
  session_start();

  function generateActivationToken(){
    $factory = new RandomLib\Factory;
    // var_dump($factory);
    $generator = $factory->getMediumStrengthGenerator();

    $token = $generator->generateString(32, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
    return $token;
  }

  function storeToken($email, $token){
    $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

    if ($conn->connect_error) {
      die("Database connection failed: " . $conn->connect_error);
    }

    $prepareString = 'INSERT INTO token(email, token, created) VALUES (?, ?, ?)';

    if(!($stmt = $conn -> prepare($prepareString))){
      echo "Could not store token. Prepare failed: (" . $conn->errno . ") " . $conn->error;
      die();
    }

    $created = time();
    if (!$stmt->bind_param("ssi", $email, $token, $created)) {
      echo "Could not store token. Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
      die();
    }

    if (!$stmt->execute()) {
      die("Could not store token. Execute failed: (" . $stmt->errno . ") " . $stmt->error);
    }
  }

  function sendMail($to){
    $token = generateActivationToken();

    $contentBody = "Please click this link to activate your account, http://localhost/schoolcrm/scripts/activate.php?token=$token";
    //store the token in the database, along with the user's email and timeout information
    storeToken($to, $token);
    die($contentBody);
    $from = new SendGrid\Email(null, "jeniece.skeete@gmail.com");
    $subject = "SchoolCRM Activation";
    $to = new SendGrid\Email(null, $to);
    $content = new SendGrid\Content("text/plain", $contentBody);
    $mail = new SendGrid\Mail($from, $subject, $to, $content);

    // $apiKey = getenv('SENDGRID_API_KEY');
    $apiKey = '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';
    // die($apiKey);
    $sg = new \SendGrid($apiKey);

    $response = $sg->client->mail()->send()->post($mail);
    // echo $response->statusCode();
    // print_r($response->headers());
    // echo $response->body();
  }

  if ($conn->connect_error) {
    http_response_code(500);
    die("Database connection failed: " . $conn->connect_error);
  }

  $prepareString = 'INSERT INTO student (fname,lname, email, password) VALUES(?,?,?,?);';

  //Create prepare statement
  if(!($stmt = $conn -> prepare($prepareString))){
    echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
    die();
  }

  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  if (!$stmt->bind_param("ssss", $fname, $lname, $email, $password)) {
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
