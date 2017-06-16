<?php
  session_start();
  // print_r($_SESSION);
  // var_dump($_SESSION['user']);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>School CRM</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../../css/schoolcrm.css" />
    <script src="../../js/jquery-3.1.1.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
  </head>
  <body>
    <?php
      require('./header.php');
    ?>
    <section class="container-fluid crm-container">
      <div class="alert alert-danger" id="studentNotFoundAlert">
        Student Not Found
      </div>
      <div id="studentSearchContainer">
        <div id="searchStudentBar">
          <form action="../../scripts/searchStudent.php" method="post" id="studentSearchForm" >
            <div class="row">
              <div class="form-group col-sm-4">
                <label for="iptPassword" class="control-label" style="font-size: 16px;"> First Name </label>
                <input type="text" placeholder="John" class="form-control" name="fname"/>
              </div>
              <div class="form-group col-sm-4">
                <label for="iptPassword" class="control-label" style="font-size: 16px;"> Middle Name </label>
                <input type="text" placeholder="Unknown" class="form-control" name="mname"/>
              </div>
              <div class="form-group col-sm-4">
                <label for="iptPassword" class="control-label" style="font-size: 16px;"> Last Name </label>
                <input type="text" placeholder="Doe" class="form-control" name="lname"/>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-sm-4">
                <button type="submit" class="btn crm-btn-primary" data-dismiss="modal">Search</button>
              </div>
            </div>
          </form>
        </div>
        <div id="searchResults">
          <header>
            Search Results
          </header>
          <section>
            Are you related to the student below? <button class="btn crm-btn-primary" id="studentSearchConfirm">Yes</button><button class="btn crm-btn-secondary" id="studentSearchDecline">No</button>
            <div style="font-size: 18px; margin-bottom: 12px"><strong>Student Basic Information</strong></div>
            <div class="row">
              <div class="col-sm-4">
                <label>First Name:</label>
                <span id="studentFirstName"></span>
              </div>
              <div class="col-sm-4">
                <label>Middle Name:</label>
                <span id="studentMiddleName"></span>
              </div>
              <div class="col-sm-4">
                <label>Last Name:</label>
                <span id="studentLastName"></span>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-4">
                <label>Age:</label>
                <span id="studentAge"></span>
              </div>
              <div class="col-sm-4">
                <label>Gender:</label>
                <span id="studentGender"></span>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-4">
                <label>Nationality:</label>
                <span id="studentNationality"></span>
              </div>
              <div class="col-sm-4">
                <label>Religion:</label>
                <span id="studentReligion"></span>
              </div>
            </div>
            <div class="parentInformation">
              <div style="font-size: 18px; margin-bottom: 12px"><strong>Parent Information</strong></div>
              <table id="parent_table" class="table">
                <tr>
                  <th>Email</th>
                  <th>First Name</th>
                  <th>Middle Name</th>
                  <th>Last Name</th>
                  <th>Relation</th>
                </tr>
              </table>
            </div>
          </section>
        </div>
      </div>
    </section>
    <div class="modal fade" id="addStudentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog crm-modal-760" role="document">
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
            <button type="button" class="btn crm-btn-primary" id="declineModalConfirm">Yes</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="linkStudentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Register Student</h4>
          </div>
          <div class="modal-body">
            <form action="" method="post" id="parentRelationForm">
              <div class="form-group">
                <label>Relation</label>
                <select class="form-control" id="parentRelation" name="relation" required>
                  <option value="father">Father</option>
                  <option value="mother">Mother</option>
                  <option value="guardian">Guardian</option>
                </select>
              </div>
              <input type="hidden" name="parent_id" value=<?echo $_SESSION['user']["id"]?> />
              <input type="hidden" name="student_id" id="studentId"/>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn crm-btn-secondary" data-dismiss="modal">No</button>
            <button type="button" class="btn crm-btn-primary" id="linkModalConfirm">Yes</button>
          </div>
        </div>
      </div>
    </div>
    <?php
      require('../../common/footer.php');
    ?>
    <script>
      $('#searchResults').hide();
      $('#studentNotFoundAlert').hide();
      $("#studentSearchConfirm").click(function(e){
        e.preventDefault();
        $('#linkStudentModal').modal('show');
      });

      $("#studentSearchDecline").click(function(e){
        e.preventDefault();
        $('#addStudentModal').modal('show');
      });

      $("#linkModalConfirm").click(function(e){
        e.preventDefault();
        $('#parentRelationForm').submit();
      });

      $("#declineModalConfirm").click(function(e){
        e.preventDefault();
        window.location = "http://localhost/schoolcrm/pages/studentbasic.php";
      });

      var form = $('#studentSearchForm');
      $(form).submit(function(e){
        e.preventDefault();
        var formData = $(form).serialize();

        $.ajax({
          type: 'POST',
          url: '../../scripts/searchStudent.php',
          data: formData
        }).done(function(response){
          console.log(response);
          var data = JSON.parse(response);

          var student = data[0];
          console.log('student', student);

          $('#studentFirstName').html(student.fname || 'undefined');
          $('#studentMiddleName').html(student.mname || 'unknown');
          $('#studentLastName').html(student.lname || 'unknown');
          $('#studentAge').html(student.age || 'unknown');
          $('#studentGender').html(student.gender || 'unknown');
          $('#studentNationality').html(student.nationality || 'unknown');
          $('#studentReligion').html(student.religion || 'unknown');
          $('#studentId').val(student.id);

          //append parent information

          var parents = student.parents;

          var tblHTML = '';
          parents.forEach(function(parent, index){
            console.log('parent', parent);
            tblHTML += '<tr><td>'+parent.email+'</td><td>'+parent.fname+'</td><td>'+parent.mname+'</td><td>'+parent.lname+'</td><td>'+parent.relation+'</td></tr>';
          });

          $("#parent_table").append(tblHTML);

          $('#searchResults').show();
          $('#studentNotFoundAlert').hide();
        }).fail(function(error){
          console.log("error occurred");
          console.log(error.responseText);
          $('#studentNotFoundAlert').show();
        });
      });

      var relationForm = $('#parentRelationForm');
      $(relationForm).submit(function(e){
        e.preventDefault();
        var formData = $(relationForm).serialize();

        $.ajax({
          type: 'POST',
          url: '../../scripts/linkExistingStudent.php',
          data: formData
        }).done(function(response){
          console.log(response);

          // var student = data[0];
          // console.log('student', student);
        }).fail(function(error){
          console.log("error occurred");
          console.log(error.responseText);
        });
      });
    </script>
  </body>
</html>
