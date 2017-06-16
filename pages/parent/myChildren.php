<?php
 session_start();
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
  <body style="background-color: #3B3738">
    <?php
      require('./header.php');
    ?>
    <section class="container-fluid crm-container">
      <div id="student_apps_container">
        <h2>My Children</h2>
        Below are a list of your children that have been accepted as students of the instituation. <br/>Click on the
        <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
        next to student's name to view their academic progress.
        <table class="table table-bordered table-striped" id="applications_table" style="margin-top: 24px">
          <thead>
            <tr>
              <th>First Name</th>
              <th>Middle Name</th>
              <th>Last Name</th>
              <th>Age</th>
              <th colspan="2"> </th>
            </tr>
          </thead>
          <tbody id="applications_table_body">
          </tbody>
        </table>
      </div>
    </section>
    <?php
      require('../../common/footer.php');
    ?>
    <!-- <div class="modal fade" id="viewApplicationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="applicationModalTitle"></h4>
          </div>
          <div class="modal-body" id="applicationModalBody">

          </div>
          <div class="modal-footer">
            <button type="button" class="btn crm-btn-secondary" data-dismiss="modal">Accept</button>
            <button type="button" class="btn crm-btn-primary" id="declineModalConfirm">Reject</button>
          </div>
        </div>
      </div>
    </div> -->
    <script>
      var students, chosenApplication;
      $.ajax({
          type: 'GET',
          url: '../../scripts/parentGetApplications.php',
        }).done(function(response){
          // console.log(response);
          students = JSON.parse(response);
          // console.log('applications', applications);

          students = students.filter(function(student){
            return student.is_accepted === "1";
          });

          var tblHTML = '';
          students.forEach(function(student, index){
            var completed = Boolean(parseInt(student.is_complete));
            tblHTML += '<tr><td>'+student.fname+'</td><td>'+student.mname+'</td><td>'+student.lname+'</td><td>'+student.age+'</td><td><span onClick="viewApplication('+student.id+')" class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></td></tr>';
          });

          $("#applications_table_body").append(tblHTML);

          /*
          <th>First Name</th>
          <th>Last Name</th>
          <th>Age</th>
          <th>Completed</th>
          <th>Status</th>
          <th colspan="2"> </th>
          */
        }).fail(function(error){
          console.log("error occurred");
          console.log(error);
        });

        function viewApplication(id){
          console.log('view application ',id);
          chosenApplication = id;
          // $('#viewApplicationModal').modal('show');
          window.location = "http://localhost/schoolcrm/pages/parent/academicReport.php?id="+id;
        }
    </script>
  </body>
</html>
