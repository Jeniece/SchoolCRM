<?php
session_start();
$user_id = $_SESSION['user']["id"];
$user_email = $_SESSION['user']["email"];

$displayMessage = '';

if(isset($_GET['message']) && !empty($_GET['message'])){
  $displayMessage = $_GET['message'];
}
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
        <div id="studentInfoAlert" class="alert <?php if($displayMessage == 'success') echo 'alert-success'; else echo 'alert-danger';?>" style="display: <?php if($displayMessage != '') echo 'block'; else echo 'none';?> ">
          <?php echo $displayMessage; ?>
        </div>
        <form id="studentBasicForm" action="../scripts/addStudent.php" method="post" enctype="multipart/form-data">
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
              <input required type="text" class="form-control" placeholder="Jeniece" id="studentFname" name="fname"/>
            </div>
            <div class="form-group col-sm-4">
              <label for="studentMname">Middle Name</label>
              <input type="text" class="form-control" placeholder="Dionne" id="studentMname" name="mname"/>
            </div>
            <div class="form-group col-sm-4">
              <label for="studentLname">Last Name</label>
              <input required type="text" class="form-control" placeholder="Skeete" id="studentLname" name="lname"/>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-sm-4">
              <label for="studentAge">Age</label>
              <input type="number" class="form-control" id="studentAge" name="age"/>
            </div>
            <div class="form-group col-sm-4">
              <label>Gender</label>
              <select class="form-control" id="studentGender" name="gender">
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-sm-4">
              <label for="studentReligion">Religion</label>
              <input type="text" class="form-control" id="studentReligion" name="religion" placeholder="Christianity"/>
            </div>
            <div class="form-group col-sm-4">
              <label for="studentNationality">Nationality</label>
              <input type="text" class="form-control" id="studentNationality" name="nationality" placeholder="Barbadian"/>
            </div>
          </div>
          <div>
            <label for="studentNationality">The current academic year is <?php echo date("Y"); ?>. Students expected to enroll after the current academic year will be put on a waiting list.</label>
          </div>
          <div class="row">
            <div class="form-group col-sm-4">
              <label for="studentNationality">Expected Enrollment Year.</label>
              <input required type="number" class="form-control" id="expectedSchoolYear" name="e_year" min=<?php echo date("Y"); ?> value='<?php echo date("Y"); ?>'/>
            </div>
          </div>
          <header>
            Documents
          </header>
          <div class="form-group">
            <label for="passportPhoto">Passport Size Photo</label>
            <input required type="file" name="identity" id="passportPhoto"/>
          </div>
          <div class="form-group">
            <label for="birthCertificate">Birth Certificate</label>
            <input required type="file" name="certificate" id="birthCertificate"/>
          </div>
          <input type="hidden" name="user_id" value=<?echo $user_id;?> />
          <input type="hidden" name="user_email" value=<?echo $user_email;?> />
          <input class="btn crm-btn-primary" type="Submit" id="studentSubmit" value="Submit">
          <button id="sInfoSave" class="btn crm-btn-secondary">Save Progress</button>
        </form>
      </div>
    </section>
    <?php
      require('../common/footer.php');
    ?>
    <script>
      // $("#studentInfoAlert").hide();

      // var form = $('#studentBasicForm');
      // $(form).submit(function(e){
      //   e.preventDefault();
      //   var formData = $(form).serialize();
      //
      //   $.ajax({
      //     type: 'POST',
      //     url: '../scripts/addStudent.php',
      //     data: formData
      //   }).done(function(response){
      //     console.log('login scrip form');
      //     console.log(response);
      //     $("#studentInfoAlert")
      //       .show()
      //       .addClass("alert-success")
      //       .text(response);
      //   }).fail(function(error){
      //     console.log("error occurred");
      //     console.log(error);
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


      $("#sInfoSave").click(function(e){
        e.preventDefault();
        $('studentInfoAlert').hide();
        console.log("sInfoSave clicked!");

        var form = $('#studentBasicForm');
        var formData = $(form).serialize();

        $.ajax({
          type: 'POST',
          url: '../scripts/saveApplication.php',
          data: formData
        }).done(function(response){
          console.log('save data script complete');
          console.log(response);
          $("#studentInfoAlert")
            .show()
            .addClass("alert-success")
            .text('Form Successfully Saved');
        }).fail(function(error){
          console.log("error occurred");
          console.log(error);
          $("#studentInfoAlert")
            .show()
            .addClass("alert-danger")
            .text(error.responseText);
        });
      });

    </script>
  </body>
</html>
