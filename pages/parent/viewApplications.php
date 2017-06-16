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
        <h3>View Applications</h3>
        <div style="margin-bottom: 24px">
          <strong>Below are student applications pending acceptance by the school administration. </strong>
        </div>
        <table class="table table-bordered table-striped" id="applications_table">
          <thead>
            <tr>
              <th>First Name</th>
              <th>Middle Name</th>
              <th>Last Name</th>
              <th>Age</th>
              <th>Completed</th>
              <th>Enroll Year</th>
              <th>Status</th>
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
      var applications, chosenApplication;
      $.ajax({
          type: 'GET',
          url: '../../scripts/parentGetApplications.php',
        }).done(function(response){
          // console.log(response);
          applications = JSON.parse(response);
          console.log('applications', applications);

          var tblHTML = '';
          applications.forEach(function(app, index){
            // console.log('applications', application);
            var completed = Boolean(parseInt(app.is_complete));
            tblHTML += '<tr><td>'+app.fname+'</td><td>'+app.mname+'</td><td>'+app.lname+'</td><td>'+app.age+'</td><td>'+completed+'</td><td>'+ app.enrollment_year + '</td><td>' + app.status+'</td><td><span onClick="viewApplication('+app.id+')" class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></td></tr>';
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
          window.location = "http://localhost/schoolcrm/pages/parent/viewApplication.php?id="+id;
        }
    </script>
  </body>
</html>
