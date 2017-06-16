<?php
  require_once('../config.php');
  session_start();
  // print_r($_FILES);
  // print_r($_POST);
  // print_r($_SESSION);
  // die();
  // die();
  function uploadFile($fileData){
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


  $identity = $_FILES["identity"];
  $identity_path = uploadFile($identity);

  $certificate = $_FILES["certificate"];
  $certificate_path = uploadFile($certificate);

  // echo $identity_path;
  // echo $certificate_path;
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

  $prepareString = 'INSERT INTO student (fname, mname, lname, age, gender, nationality, religion, enrollment_year, is_complete, birth_certificate, photo_id) VALUES(?,?,?,?,?,?,?,?,?,?,?);';

  //Create prepare statement
  if(!($stmt = $conn -> prepare($prepareString))){
    echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
    die();
  }

  //save the student data
  var_dump($_POST);
  $fname = $_POST['fname'];
  $mname = $_POST['mname'];
  $lname = $_POST['lname'];
  $age = $_POST['age'];
  $gender = $_POST['gender'];
  $religion = $_POST['religion'];
  $nationality = $_POST['nationality'];
  $enrollmentYear = $_POST['e_year'];
  $iscomplete = true;

  //get the id from the database
  if (!$stmt->bind_param("sssisssiiss", $fname, $mname, $lname, $age, $gender, $nationality, $religion, $enrollmentYear, $iscomplete, $certificate_path, $identity_path)) {
    http_response_code(500);
    die("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
  }

  /*execute bound statement*/
  if (!$stmt->execute()) {
    http_response_code(500);
    die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
  }

  $stmt->close();

  $prepareString = 'SELECT id from student WHERE fname=? AND mname=? AND lname=? ORDER BY id DESC LIMIT 1';

  //Create prepare statement
  if(!($stmt = $conn -> prepare($prepareString))){
    http_response_code(500);
    echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
    die();
  }

  // echo $fname.' '.$mname.' '.$lname;

  if (!$stmt->bind_param("sss", $fname, $mname, $lname)){
    http_response_code(500);
    die("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
  }

  $student_id = -1;

  $stmt->bind_result($student_id);

  if (!$stmt->execute()) {
    http_response_code(500);
    die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
  }

  $stmt->store_result();

  if(!$stmt->fetch()){
    http_response_code(500);
    die("Fetch failed: (" . $stmt->errno . ") " . $stmt->error);
  }

  if($student_id == -1){
    http_response_code(500);
    die('An error occurred');
  }

  var_dump($student_id);
  http_response_code(200);
  // die("Success");

  $stmt->close();
  //link the parent
  $parent_id = $_SESSION['user']['id'];

  /*
  Link parent and student
  $p_id contains the student id and $parent_id contains the id of the currently loggged in parent
  */

  $prepareString = 'INSERT INTO studentparent (student_id, parent_id, relation) VALUES(?,?,?);';

  //Create prepare statement
  if(!($stmt = $conn -> prepare($prepareString))){
    echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
    die();
  }


  $relation = $_POST['relation'];
  //get the id from the database
  if (!$stmt->bind_param("sss", $student_id, $parent_id, $relation)) {
    http_response_code(500);
    die("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
  }

  /*execute bound statement*/
  if (!$stmt->execute()) {
    http_response_code(500);
    die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
  }

  $stmt->close();

  header('Location: http://localhost/schoolcrm/pages/studentbasic.php?message=success');

?>
