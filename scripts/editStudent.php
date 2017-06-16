<?php
  require_once('../config.php');
  session_start();
  print_r($_FILES);
  // print_r($_POST);
  // die();
  function updateStudentApplicationData(){
    $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

    if ($conn->connect_error) {
      http_response_code(500);
      die("Database connection failed: " . $conn->connect_error);
    }

    if(!isset($_POST['student_id']) || empty($_POST['student_id'])){
      http_response_code(400);
      die('Could not identify student');
    }

    $relation = $_POST['relation'];
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $religion = $_POST['religion'];
    $nationality = $_POST['nationality'];
    $e_year = $_POST['e_year'];
    $student_id = $_POST['student_id'];

    // $query = "UPDATE student SET relation=COALESCE(relation, $relation), fname=COALESCE(fname, $fname), mname=COALESCE(mname, $mname), lname=COALESCE(lname, $lname),
    // age=COALESCE(age, $age), gender=COALESCE(gender, $gender), religion=COALESCE(religion, $religion), nationality=COALESCE(nationality, $nationality),
    // enrollment_year=COALESCE(enrollment_year, $e_year) WHERE student_id=$student_id";

    $prepareString = "UPDATE student SET fname=COALESCE(?,fname), mname=COALESCE(?, mname), lname=COALESCE(?,lname),
    age=COALESCE(?,age), gender=COALESCE(?,gender), religion=COALESCE(?,religion), nationality=COALESCE(?,nationality),
    enrollment_year=COALESCE(?,enrollment_year) WHERE id=?";

    if(!($stmt = $conn -> prepare($prepareString))){
      http_response_code(500);
      echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
      die();
    }

    if (!$stmt->bind_param("sssisssii", $fname, $mname, $lname, $age, $gender, $religion, $nationality, $e_year, $student_id)) {
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

  function updateImage($fileData){
    $target_dir = "../student/documents/";
    $img_info = pathinfo($fileData["name"]);
    $filename = $img_info["basename"];
    $target_file = $target_dir . $img_info["filename"] . time() . '.' . $img_info["extension"];
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);



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
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        die("Sorry, only JPG, JPEG & PNG files are allowed.");
        $uploadOk = 0;
    }

    if (move_uploaded_file($fileData["tmp_name"], $target_file)) {
        // echo "The file ". basename($fileData["name"]). " has been uploaded.";
        return $target_file;
    } else {
        die("Sorry, there was an error uploading your file: $filename");
    }
  }

  function updateImagePaths($identity, $certificate){
    $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

    if ($conn->connect_error) {
      http_response_code(500);
      die("UpdateImagePaths;Database connection failed: " . $conn->connect_error);
    }

    $student_id = $_POST['student_id'];
    $prepareString = "UPDATE student SET birth_certificate=COALESCE(?, birth_certificate), photo_id=COALESCE(?, photo_id) WHERE id=?";

    if(!($stmt = $conn -> prepare($prepareString))){
      http_response_code(500);
      echo "UpdateImagePaths;Prepare failed: (" . $conn->errno . ") " . $conn->error;
      die();
    }

    if (!$stmt->bind_param("ssi", $certificate, $identity, $student_id)) {
      http_response_code(500);
      die("UpdateImagePaths;Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
    }

    /*execute bound statement*/
    if (!$stmt->execute()) {
      http_response_code(500);
      die("UpdateImagePaths;Execute failed: (" . $stmt->errno . ") " . $stmt->error);
    }

    $stmt->close();
  }

  function updateRelation(){

    if(!isset($_POST['relation']) || empty($_POST['relation'])){
        http_response_code(400);
        die('updateRelation;Missing relation to student');
    }

    if(!isset($_POST['user_id']) || empty($_POST['user_id'])){
        http_response_code(400);
        die('updateRelation;Missing user id');
    }

    if(!isset($_POST['student_id']) || empty($_POST['student_id'])){
        http_response_code(400);
        die('updateRelation;Missing student id for student');
    }

    $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

    if ($conn->connect_error) {
      http_response_code(500);
      die("updateRelation;Database connection failed: " . $conn->connect_error);
    }

    $prepareString = "UPDATE studentparent SET relation=? WHERE parent_id=? AND student_id=?";

    //Create prepare statement
    if(!($stmt = $conn -> prepare($prepareString))){
      http_response_code(500);
      echo "updateRelation;Prepare failed: (" . $conn->errno . ") " . $conn->error;
      die();
    }


    $relation = $_POST['relation'];
    $student_id = $_POST['student_id'];
    $parent_id = $_POST['user_id'];
    //get the id from the database
    if (!$stmt->bind_param("sii", $relation, $student_id, $parent_id)) {
      http_response_code(500);
      die("updateRelation;Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
    }

    /*execute bound statement*/
    if (!$stmt->execute()) {
      http_response_code(500);
      die("updateRelation;Execute failed: (" . $stmt->errno . ") " . $stmt->error);
    }

    $stmt->close();
  }

  //Update the student information
  updateStudentApplicationData();

  //Update the relationship between the student and parent
  if(isset($_POST["relation"]) && !empty($_POST["relation"])){
    updateRelation();
  }

  $identity_path="";
  $certificate_path="";

  //Update identity if one is present
  if(isset($_FILES["identity"]) && !empty($_FILES["identity"])){
    $identity = $_FILES["identity"];
    $identity_path = updateImage($identity);
  }

  //Update certificate if one is present
  if(isset($_FILES["certificate"]) && !empty($_FILES["certificate"])){
    $certificate = $_FILES["certificate"];
    $certificate_path = updateImage($certificate);
  }

  updateImagePaths($identity_path, $certificate_path);

  // die();
  http_response_code(200);
  header('Location: http://localhost/schoolcrm/pages/parent/viewApplications.php');
?>
