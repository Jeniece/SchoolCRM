<?php
  require '../vendor/autoload.php'; //loads the php libraries in the vendor folder. These libs/packages were installed via composer

  require("../pkgs/sendgrid-php/sendgrid-php.php");
  require_once('../config.php');
  // die($token);
  // sendMail('jamariothorne@gmail.com');
  function sendMail($to, $account_type){
    $token = generateActivationToken();

    $contentBody = "Please click this link to activate your account, http://localhost/schoolcrm/scripts/activate.php?token=$token&type=$account_type";
    //store the token in the database, along with the user's email and timeout information
    storeToken($to, $token);
    // die($contentBody);
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
    echo $response->statusCode();
    print_r($response->headers());
    echo $response->body();
  }

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

  function insertParentData($email, $password){
    $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);
    $stmt=null;

    if ($conn->connect_error) {
      die("Database connection failed: " . $conn->connect_error);
    }

    $prepareString = 'INSERT INTO parent(email, password) VALUES (?, ?)';

    if(!($stmt = $conn -> prepare($prepareString))){
      echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
      die();
    }

    /*bind params*/
    if (!$stmt->bind_param("ss", $email, $password)) {
      echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
      die();
    }

    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }
  }

  function insertTeacherData($email, $password){
    $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);
    $stmt=null;

    if ($conn->connect_error) {
      die("Database connection failed: " . $conn->connect_error);
    }

    $prepareString = 'INSERT INTO teacher(email, password) VALUES (?, ?)';

    if(!($stmt = $conn -> prepare($prepareString))){
      echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
      die();
    }

    /*bind params*/
    if (!$stmt->bind_param("ss", $email, $password)) {
      echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
      die();
    }

    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }
  }

  if(empty($_POST["email"]) || empty($_POST["password"])){
    die("email or password is empty!");
  } else {
    $register_type = $_POST["account_type"];

    if($register_type == "parent"){
      insertParentData($_POST['email'], $_POST['password']);
    } else {
      insertTeacherData($_POST['email'], $_POST['password']);
    }

    sendMail($_POST["email"], $register_type);

  }

  die('Success!');
?>
