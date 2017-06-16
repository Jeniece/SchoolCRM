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
    <header id="headerContainer">
      This is a header
    </header>
    <section class="container-fluid crm-container">
      <div id="student_apps_container">
        <table class="table table-bordered table-striped" id="applications_table">
          <thead>
            <tr>
              <th>First Name</th>
              <th>Middle Name</th>
              <th>Last Name</th>
              <th>Age</th>
              <th>Status</th>
              <th colspan="2"> </th>
            </tr>
          </thead>
          <tbody id="applications_table_body">
          </tbody>
        </table>
      </div>
    </section>
    <div id="footerContainer">
      This is the footer
    </div>
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
          url: '../../scripts/getApplications.php',
        }).done(function(response){
          // console.log(response);
          applications = JSON.parse(response);
          // console.log('applications', applications);

          var tblHTML = '';
          applications.forEach(function(app, index){
            // console.log('applications', application);
            tblHTML += '<tr><td>'+app.fname+'</td><td>'+app.mname+'</td><td>'+app.lname+'</td><td>'+app.age+'</td><td>'+app.status+'</td><td><span onClick="viewApplication('+app.id+')" class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></td></tr>';
          });

          $("#applications_table_body").append(tblHTML);

        }).fail(function(error){
          console.log("error occurred");
          console.log(error);
        });

        function viewApplication(id){
          console.log('view application ',id);
          chosenApplication = id;
          // $('#viewApplicationModal').modal('show');
          window.location = "http://localhost/schoolcrm/pages/teacher/viewApplication.php?id="+id;
        }
    </script>
  </body>
</html>
