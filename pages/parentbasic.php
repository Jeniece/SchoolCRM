<?php
  session_start();
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
    <section class="crm-container container-fluid">
      <div class="registrationForm">
        <div id="parentInfoAlert" class="alert">
          Testing alert!
        </div>
        <form action="../scripts/handleParentInfo.php" method="post" id="parentInfoForm" >
          <header>Basic Information</header>
          <section id="parentBasicInfo">
            <div class="row">
              <div class="form-group col-sm-4">
                <label for="title">Title</label>
                <input required type="text" class="form-control" placeholder="Mr./Mrs./Dr." id="title" name="title"/>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-sm-4">
                <label>First Name</label>
                <input required type="text" class="form-control" placeholder="Susan" id="fname" name="fname" required/>
              </div>
              <div class="form-group col-sm-4">
                <label>Middle Name</label>
                <input required type="text" class="form-control" placeholder="Princess" id="mname" name="mname"/>
              </div>
              <div class="form-group col-sm-4">
                <label>Last Name</label>
                <input required type="text" class="form-control" placeholder="Bone" id="lname" name="lname"/>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-sm-4">
                <label for="age">Age</label>
                <input required type="number" class="form-control" placeholder="44" max="75" min="18" id="age" name="age"/>
              </div>
              <div class="form-group col-sm-4">
                <label>Gender</label>
                <select class="form-control" id="gender" name="gender">
                  <option value="male">Male</option>
                  <option value="female">Female</option>
                  <option value="other">Other</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-sm-4">
                <label for="mstatus">Marital Status</label>
                <select id="mstatus" name="marital_status" class="form-control">
                  <option>Married</option>
                  <option>Divorced</option>
                  <option>Single</option>
                  <option>Other</option>
                </select>
              </div>
              <div class="form-group col-sm-4">
                <label for="nationality">Nationality</label>
                <input required type="text" class="form-control" placeholder="Barbadian" id="nationality" name="nationality"/>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-sm-4">
                <label for="landline">Landline Number</label>
                <input required type="text" class="form-control" placeholder="+1 (246) 888-4578" id="landline" name="landline"/>
              </div>
              <div class="form-group col-sm-4">
                <label for="mobile">Mobile Number</label>
                <input required type="text" class="form-control" placeholder="+1 (246) 888-4578" id="mobile" name="mobile"/>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-sm-12">
                <label for="address">Address</label>
                <input required type="text" class="form-control" placeholder="Hearts Gap, Christ Church" name="address" id="address"/>
              </div>
            </div>
          </section>

          <section id="parentEmployment">
            <header>Employment</header>
            <div class="row">
              <div class="form-group col-sm-4">
                <label for="occupation">Occupation</label>
                <input required type="text" class="form-control" placeholder="Doctor" id="occupation" name="occupation"/>
              </div>
              <div class="form-group col-sm-4">
                <label for="income">Annual Income</label>
                <select id="income" name="income" class="form-control">
                  <option value="$0-$10,000">$0 - $10,000</option>
                  <option value="$10,001-$20,000">$10,001 - $20,000</option>
                  <option value="$20,001-$30,000">$20,001 - $30,000</option>
                  <option value="$30,001-$30,000">$30,001 - $40,000</option>
                  <option value="$50,000">$50,000+</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-sm-4">
                <label for="bname">Business Name</label>
                <input required type="text" class="form-control" placeholder="Oran Ltd." name="bname" id="bname"/>
              </div>
              <div class="form-group col-sm-4">
                <label for="bphone">Phone Number</label>
                <input required type="text" class="form-control" placeholder="+1 (246)888-4578" name="bphone" id="bphone"/>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-sm-12">
                <label for="baddress">Business Address</label>
                <input required type="text" class="form-control" placeholder="Harbor Road, St. Michael" name="baddress" id="baddress"/>
              </div>
            </div>
          </section>
          <input required type="hidden" name="user_id" value=<?echo $_SESSION['user']["id"]?> />
          <input required type="hidden" name="user_email" value=<?echo $_SESSION['user']["email"]?> />
          <input class="btn crm-btn-primary" type="Submit" id="parentBasicSubmit" value="Submit">
          <!-- <button id="pInfoSave" class="btn crm-btn-secondary">Save Progress</button> -->
          <!-- Button trigger modal -->
        </form>
      </div>
      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Register Student</h4>
            </div>
            <div class="modal-body">
              Do you want to register your child now?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn crm-btn-secondary" data-dismiss="modal">No</button>
              <button type="button" class="btn crm-btn-primary" id="modalConfirm">Yes</button>
            </div>
          </div>
        </div>
      </div>
    </section>
    <?php
      require('../common/footer.php');
    ?>
    <script>

      $("#parentInfoAlert").hide();

      $("#pInfoSave").click(function(e){
        e.preventDefault();
        console.log("pInfoSave clicked!");
        $('#myModal').modal('show');
      });

      $("#modalConfirm").click(function(e){
        window.location = "http://localhost/schoolcrm/pages/studentbasic.php";
      });

      var form = $('#parentInfoForm');
      $(form).submit(function(e){
        e.preventDefault();
        var formData = $(form).serialize();

        $.ajax({
          type: 'POST',
          url: '../scripts/handleParentInfo.php',
          data: formData
        }).done(function(response){
          console.log('handleParentInfo script');
          console.log(response);
          $("#parentInfoAlert")
            .show()
            .addClass("alert-success")
            .text(response);

          //show the modal window asking parent to add a student
          $('#myModal').modal('show');
          // window.location = "http://localhost/schoolcrm/pages/home.php";
        }).fail(function(error){
          console.log("error occurred");
          console.log(error);
          $("#parentInfoAlert")
            .show()
            .addClass("alert-danger")
            .text(error.responseText);
        });
      });
    </script>
  </body>
</html>
