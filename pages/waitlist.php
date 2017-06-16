<?php
session_start();
$user_id = $_SESSION['user']["id"];
$user_email = $_SESSION['user']["email"];
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
    <header id="headerContainer">
      Header!
    </header>
    <section class="container-fluid crm-container">
      <div class="registrationForm">
        <div id="studentInfoAlert" class="alert">
          Testing alert!
        </div>
        <form id="studentBasicForm" action="../scripts/waitlist.php" method="post">
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
              <input type="text" class="form-control" placeholder="Jeniece" id="studentFname" name="fname" required/>
            </div>
            <div class="form-group col-sm-4">
              <label for="studentMname">Middle Name</label>
              <input type="text" class="form-control" placeholder="Dionne" id="studentMname" name="mname" required/>
            </div>
            <div class="form-group col-sm-4">
              <label for="studentLname">Last Name</label>
              <input type="text" class="form-control" placeholder="Skeete" id="studentLname" name="lname" required/>
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
              <input type="text" class="form-control" id="studentNationality" name="nationality" placeholder="Barbadian" />
            </div>
          </div>
          <div class="row">
            <div class="form-group col-sm-4">
              <label for="expectedSchoolYear"> Expected Enrollment Year </label>
              <input required type="number" class="form-control" id="expectedSchoolYear" name="expectedSchoolYear" min=<?php echo date("Y"); ?>  max=<?php echo date("Y")+4; ?>/>
            </div>
          </div>
          <input type="hidden" name="user_id" value=<?echo $user_id;?> />
          <input type="hidden" name="user_email" value=<?echo $user_email;?> />
          <input class="btn crm-btn-primary" type="Submit" id="studentSubmit" value="Submit">
          <button id="sInfoSave" class="btn crm-btn-secondary">Save Progress</button>
        </form>
      </div>
    </section>
    <div id="footerContainer">
      This is the footer
    </div>
    <script>
      $("#sInfoSave").click(function(e){
        e.preventDefault();
        console.log("sInfoSave clicked!");
      });

      $("#studentInfoAlert").hide();

      var form = $('#studentBasicForm');
      $(form).submit(function(e){
        e.preventDefault();
        var formData = $(form).serialize();

        $.ajax({
          type: 'POST',
          url: '../scripts/waitlist.php',
          data: formData
        }).done(function(response){
          console.log(response);
          $("#studentInfoAlert")
            .show()
            .addClass("alert-success")
            .text(response);
        }).fail(function(error){
          console.log("error occurred");
          console.log(error);
          $("#studentInfoAlert")
            .show()
            .addClass("alert-danger")
            .text(error.responseText);
        });
        // console.log('login button clicked');
        // var email = $('#iptEmail')[0].value;
        // var password = $('#iptPassword')[0].value;
        // console.log(email, password);
      });
    </script>
  </body>
</html>
