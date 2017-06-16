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
      <div id="applicationForm">
        <div class="row" style="padding-bottom: 12px">
          <div class="col-sm-4">
            <img id="preview_photo_id" src=""/>
          </div>
          <div class="col-sm-8">
            <div id="nameContainer">
              <span id="appname"></span>
            </div>
          </div>
        </div>
        <div class="row application-info-row">
          <div class="col-sm-6">
            <label>Age:</label>
            <span id="appage"></span>
          </div>
          <div class="col-sm-6 application-info-row">
            <label>Gender:</label>
            <span id="appgender"></span>
          </div>
        </div>
        <div class="row application-info-row">
          <div class="col-sm-6">
            <label>Religion:</label>
            <span id="appreligion"></span>
          </div>
          <div class="col-sm-6">
            <label>Nationality:</label>
            <span id="appnationality"></span>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12 app-parents-table">
            <header>Parents</header>
            <table class="table table-bordered table-striped" id="app_parents">
              <thead>
                <tr>
                  <th>Email</th>
                  <th>First Name</th>
                  <th>Middle Name</th>
                  <th>Last Name</th>
                  <th>Relation</th>
                </tr>
              </thead>
              <tbody id="app_parents_body">
              </tbody>
            </table>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12" id="uploaded_docs">
            <header>Uploaded Documents</header>
            <table class="table table-bordered table-striped" id="app_docs">
              <thead>
                <tr>
                  <th style="width:50px">Id</th>
                  <th>Name</th>
                  <th style="width:75px"> </th>
                </tr>
              </thead>
              <tbody id="app_docs_body">
                <tr>
                  <td>1.</td>
                  <td>Photo Identification</td>
                  <td><span id="app_docs_view_photo" class="glyphicon glyphicon-eye-open" aria-hidden="true" onClick="showPhotoId()"></span></td>
                </tr>
                <tr>
                  <td>2.</td>
                  <td>Birth Certificate</td>
                  <td><span id="app_docs_view_certificate" class="glyphicon glyphicon-eye-open" aria-hidden="true" onClick="showBirthCertificate()"></span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="row" style="margin-top: 18px">
          <div class="col-sm-4 col-sm-offset-8" style="text-align: right">
            <button class="btn crm-btn-primary" id="btn_app_accept">Accept</button>
            <button class="btn crm-btn-secondary" id="btn_app_reject">Reject</button>
          </div>
        </div>
      </div>
    </section>
    <div id="footerContainer">
      This is the footer
    </div>
    <div class="modal fade" id="photoIdModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" style="width:760px"role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Photo Identification</h4>
          </div>
          <div class="modal-body">
            <img id="photoId" src="" />
          </div>
          <div class="modal-footer">
            <button type="button" class="btn crm-btn-primary" id="photoIdClose" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="birthCertificateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" style="width:760px" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Birth Certificate</h4>
          </div>
          <div class="modal-body" id="applicationModalBody">
            <img id="birthCertificate" src="" />
          </div>
          <div class="modal-footer">
            <button type="button" class="btn crm-btn-primary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <script>
      $.ajax({
          type: 'GET',
          url: '../../scripts/getStudent.php?id='+<?php echo $_GET['id']?>,
        }).done(function(response){
          console.log(response);
          var results = JSON.parse(response);
          var student = results[0];
          console.log(student.fname);
          console.log(student.photo_id, student.birth_certificate);

          //../student/documents/wolf1493648057.jpg
          /*
          <div>
            <strong>Middle Name:</strong><span id="appmname"></span>
          </div>
          <div>
            <strong>Last Name:</strong><span id="applname"></span>
          </div>
          */
          $('#preview_photo_id').attr('src', '../'+student.photo_id);
          $("#birthCertificate").attr("src", '../'+student.birth_certificate);
          $("#photoId").attr("src", '../'+student.photo_id);
          $('').click(function(){

          });
          $('#appname').html( student.fname + ' ' + student.mname + ' ' + student.lname);
          $('#appage').html( student.age );
          $('#appgender').html( student.gender );
          $('#appreligion').html( student.religion );
          $('#appnationality').html( student.nationality );
          // $('#appmname').html( student.mname || 'undefined');
          // $('#applname').html( student.lname || 'undefined');
          var parents = student.parents;
          var tblHTML = '';

          if(!parents){
            tblHTML += '<tr><td colspan="5">No parent information available</td>'
          } else {
            parents.forEach(function(parent, index){
              // console.log('applications', application);
              tblHTML += '<tr><td>'+parent.email+'</td><td>'+parent.fname+'</td><td>'+parent.mname+'</td><td>'+parent.lname+'</td><td>'+parent.relation+'</td></tr>';
            });
          }

          $("#app_parents_body").append(tblHTML);


          var photo_id = student.photo_id;
          var birth_certificate = student.birth_certificate;

          $('#btn_app_accept').click(function(){
            $.ajax({
                type: 'POST',
                url: '../../scripts/processStudentApplication.php',
                data: {
                  id: student.id,
                  mode: 'accept',
                },
              }).done(function(response){
                console.log(response);
                window.location = "http://localhost/schoolcrm/pages/teacher/applications.php";
                // var results = JSON.parse(response);

              }).fail(function(error){
                console.log("error occurred");
                console.log(error.responseText);
                // console.log(error.responseText);
              });
          });

          $('#btn_app_reject').click(function(){
            $.ajax({
                type: 'POST',
                url: '../../scripts/processStudentApplication.php',
                data: {
                  id: student.id,
                  mode: 'reject',
                },
              }).done(function(response){
                console.log(response);
                // var results = JSON.parse(response);
                console.log(response);
                window.location = "http://localhost/schoolcrm/pages/teacher/applications.php";

              }).fail(function(error){
                console.log("error occurred");
                console.log(error.responseText);
                // console.log(error.responseText);
              });
          });

        }).fail(function(error){
          console.log("error occurred");
          console.log(error);
          // console.log(error.responseText);
        });

        function showBirthCertificate(){
          $('#birthCertificateModal').modal('show');
        }

        function showPhotoId(){
          $('#photoIdModal').modal('show');
        }

    </script>
  </body>
</html>
