<?php
  require_once('../config.php');
  session_start();
  print_r($_FILES);
  $teacher_id = $_SESSION['user']["id"];

  $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

  if ($conn->connect_error) {
    http_response_code(500);
    die("Database connection failed: " . $conn->connect_error);
  }

  function uploadSurvey(){
    if(!isset($_FILES["survey"]) || empty($_FILES["survey"])){
      die("Could not find survey file");
    }

    $fileData = $_FILES["survey"];
    $target_dir = "../surveys/";
    $survey_info = pathinfo($fileData["name"]);
    $filename = $survey_info["basename"];
    $target_file = $target_dir . $survey_info["filename"] . '.' . $survey_info["extension"];
    $uploadOk = 1;
    $surveyFileType = pathinfo($target_file,PATHINFO_EXTENSION);



    if(isset($_POST["submit"])) {
      // Check if image file is a actual image or fake image
      $check = getimagesize($fileData["tmp_name"]);
      if($check !== false) {
        die("The file: $filename is not an image");
      }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
      die("Sorry, file: $filename already exists.");
        // $uploadOk = 0;
    }

    // Check file size
    if ($fileData["size"] > 50000000) {
        die("Sorry, your file: $filename is too large.");
        $uploadOk = 0;
    }

      // Allow certain file formats
    if($surveyFileType != "txt" && $surveyFileType != "doc" && $surveyFileType != "docx" && $surveyFileType != "pages") {
        die("Sorry, only txt, doc, docx or pages files allowed.");
        $uploadOk = 0;
    }

    if (move_uploaded_file($fileData["tmp_name"], $target_file)) {
        // echo "The file ". basename($fileData["name"]). " has been uploaded.";
        return $target_file;
    } else {
        die("Sorry, there was an error uploading your file: $filename");
    }
  }

  function storeSurveyPath($path){
    $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

    if ($conn->connect_error) {
      http_response_code(500);
      die("Database connection failed: " . $conn->connect_error);
    }

    $currentTime = time();
    $surveyName = $_POST["survey_name"];

    $prepareString = "INSERT INTO survey (file_path, created, name) VALUES(?,?,?)";

    if(!($stmt = $conn -> prepare($prepareString))){
      echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
      die();
    }

    if (!$stmt->bind_param("sis", $path, $currentTime, $surveyName)) {
      http_response_code(500);
      die("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
    }

    /*execute bound statement*/
    if (!$stmt->execute()) {
      http_response_code(500);
      die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
    }

    $stmt->close();
  }

  if(!isset($_FILES["survey"]) || empty($_FILES["survey"])){
    die("Could not find survey file");
  }

  if(!isset($_POST["survey_name"]) || empty($_POST["survey_name"])){
    die("Could not find the name of the survey");
  }
  $file_path = uploadSurvey();
  storeSurveyPath($file_path)
?>
