<?php
session_start();
$user_id = $_SESSION['user']["id"];
$user_email = $_SESSION['user']["email"];

/*check for student data*/
  $data;
  if(isset($_GET['data'])){
    // echo 'data is present';
    $dataString = urldecode($_GET['data']);
    $data = json_decode($dataString);
  }

  $photo_id_avail;
  $birth_cert_avail;

  if($data->photo_id == null || $data->photo_id == ''){
    $photo_id_avail=false;
  }

  if($data->birth_certificate == null || $data->birth_certificate == ''){
    $birth_cert_avail=false;
  }

  // var_dump($data);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>School CRM</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/schoolcrm.css" />
    <script src="../js/jquery-3.1.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
  </head>
  <body>
    <?php
      require('./parent/header.php');
    ?>
    <section class="container-fluid crm-container">
      <div class="registrationForm">
        <form id="studentBasicForm" method="post" action="../scripts/editStudent.php" enctype="multipart/form-data">
          <header>Basic Information</header>
          <div class="row">
            <div class="form-group col-sm-4">
              <label>Your relationship to the student</label>
              <select class="form-control" id="parentRelation" name="relation">
                <option value="mother">Mother</option>
                <option value="father">Father</option>
                <option value="guardian">Guardian</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-sm-4">
              <label for="studentFname">First Name</label>
              <input type="text" class="form-control" placeholder="Jeniece" id="studentFname" name="fname"
              value="<?php if(empty($data->fname)) echo ''; else echo $data->fname;?>"
              />
            </div>
            <div class="form-group col-sm-4">
              <label for="studentMname">Middle Name</label>
              <input type="text" class="form-control" placeholder="Dionne" id="studentMname" name="mname"
              value="<?php if(empty($data->mname)) echo ''; else echo $data->mname;?>"
              />
            </div>
            <div class="form-group col-sm-4">
              <label for="studentLname">Last Name</label>
              <input type="text" class="form-control" placeholder="Skeete" id="studentLname" name="lname"
              value="<?php if(empty($data->lname)) echo ''; else echo $data->lname;?>"
              />
            </div>
          </div>
          <div class="row">
            <div class="form-group col-sm-4">
              <label for="studentAge">Age</label>
              <input type="number" class="form-control" id="studentAge" name="age"
              value=<?php if(empty($data->age)) echo ''; else echo $data->age;?>
              />
            </div>
            <div class="form-group col-sm-4">
              <label>Gender</label>
              <select class="form-control" id="studentGender" name="gender">
                <option value="male" <?php if($data->gender === 'male') echo 'selected'; ?>>Male</option>
                <option value="female" <?php if($data->gender === 'female') echo 'selected'; ?>>Female</option>
                <option value="other" <?php if($data->gender === 'other') echo 'selected'; ?>>Other</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-sm-4">
              <label for="studentReligion">Religion</label>
              <input type="text" class="form-control" id="studentReligion" name="religion" placeholder="Christianity" value="<?php if(empty($data->religion)) echo ''; else echo $data->religion; ?>" />
            </div>
            <div class="form-group col-sm-4">
              <label for="studentNationality">Nationality</label>
              <input type="text" class="form-control" id="studentNationality" name="nationality" placeholder="Barbadian"
              value="<?php if(empty($data->nationality)) echo ''; else echo $data->nationality;?>"
              />
            </div>
          </div>
          <div class="row">
            <div class="form-group col-sm-4">
              <label for="studentNationality">Expected Enrollment Year</label>
              <input required type="number" class="form-control" id="expectedSchoolYear" name="e_year" min=<?php echo date("Y"); ?>
              value=<?php if(empty($data->enrollment_year)) echo ''; else echo $data->enrollment_year;?>
              />
            </div>
          </div>
          <header>
            Documents
          </header>
          <div class="form-group">
            <label for="passportPhoto" id="passportPhotoLabel" style='display:<?php if($photo_id_avail) echo 'none'; else echo 'initial';?>'>Passport Size Photo</label>
            <label for="passportPhoto" style='display:<?php if($photo_id_avail) echo 'initial'; else echo 'none';?>' id="diffPassportPhotoLabel">Upload a different passport size photo</label>
            <input type="file" name="identity" id="passportPhoto"/>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-sm-4">
                <label for="birthCertificate" id="birthCertificate" style='display:<?php if($birth_cert_avail) echo "none"; else echo "initial";?>'>Birth Certificate</label>
                <label for="birthCertificate" style="display:<?php if($birth_cert_avail) echo "initial"; else echo "none";?>" id="diffBirthCertificate">Upload a different birth certificate</label>
                <input type="file" name="certificate" id="birthCertificate"/>
              </div>
            </div>
          </div>
          <input type="hidden" name="user_id" value=<?echo $user_id;?> />
          <input type="hidden" name="user_email" value=<?echo $user_email;?> />
          <input type="hidden" name="student_id" value=<?echo $data->id;?> />
          <input class="btn crm-btn-primary" type="Submit" id="studentSubmit" value="Edit">
          <!-- <button id="sInfoSave" class="btn crm-btn-secondary">Save Progress</button> -->
        </form>
      </div>
    </section>
    <?php
      require('../common/footer.php');
    ?>
    <script>
      // $("#studentInfoAlert").hide();
      //
      // var form = $('#studentBasicForm');
      // $(form).submit(function(e){
      //   e.preventDefault();
      //   var formData = $(form).serialize();
      //
      //   $.ajax({
      //     type: 'POST',
      //     url: '../scripts/editStudent.php',
      //     data: formData
      //   }).done(function(response){
      //     console.log('edit student script form');
      //     console.log(response);
      //     // $("#studentInfoAlert")
      //     //   .show()
      //     //   .addClass("alert-success")
      //     //   .text(response);
      //   }).fail(function(error){
      //     console.log("error occurred");
      //     console.log(error.responseText);
      //     $("#studentInfoAlert")
      //       .show()
      //       .addClass("alert-danger")
      //       .text(error.responseText);
      //   });
      //   // console.log('login button clicked');
      //   // var email = $('#iptEmail')[0].value;
      //   // var password = $('#iptPassword')[0].value;
      //   // console.log(email, password);
      // });
    </script>
  </body>
</html>
