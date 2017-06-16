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
    <style>
      #applicationHeader{
        margin-bottom: 24px;
      }
      #applicationHeader header{
        font-size: 24px;
        font-weight: bold;
      }

      #parentViewApplication{
        font-size: 14px;
      }

      .disableIcon{
        color: rgba(0,0,0,0.2);
        cursor: not-allowed !important;
      }
      /*#buttons{

      }*/
    </style>
  </head>
  <body style="background-color: #3B3738">
    <?php
      require('./header.php');
    ?>
    <section class="container-fluid crm-container">
      <div id="parentViewApplication">
        <div class="row" id="applicationHeader">
          <header class="col-sm-4">Student Application</header>
          <!-- <div class="col-sm-6">
            <div class="row">
              <div class="col-sm-3">Incomplete</div>
              <div class="col-sm-3">Wishlist</div>
              <div class="col-sm-3">Accepted</div>
              <div class="col-sm-3">Unaccepted</div>
            </div>
          </div> -->
        </div>
        <div class="row" style="margin-bottom: 6px">
          <div class="col-sm-4">
            <label>First Name:</label>
            <span id="fname"></span>
          </div>
          <div class="col-sm-4">
            <label>Middle Name:</label>
            <span id="mname"></span>
          </div>
          <div class="col-sm-4">
            <label>Last Name:</label>
            <span id="lname"></span>
          </div>
        </div>
        <div class="row" style="margin-bottom: 6px">
          <div class="col-sm-6">
            <label>Age:</label>
            <span id="age"></span>
          </div>
          <div class="col-sm-6">
            <label>Gender:</label>
            <span id="gender"></span>
          </div>
        </div>
        <div class="row" style="margin-bottom: 6px">
          <div class="col-sm-6">
            <label>Nationality:</label>
            <span id="nationality"></span>
          </div>
          <div class="col-sm-6">
            <label>Religion:</label>
            <span id="religion"></span>
          </div>
        </div>
        <div class="row" style="margin-bottom: 6px">
          <div class="col-sm-6">
            <label>Enrollment Year:</label>
            <span id="enrollment_yr"></span>
          </div>
        </div>
        <div class="row" style="margin-top:36px">
          <div class="col-sm-12" id="uploaded_docs">
            <header>Uploaded Documents</header>
            <table class="table table-bordered table-striped" id="app_docs">
              <thead>
                <tr>
                  <th style="width:50px">Id</th>
                  <th>Name</th>
                  <th>Uploaded</th>
                  <th style="width:75px"> </th>
                </tr>
              </thead>
              <tbody id="app_docs_body">
                <tr>
                  <td>1.</td>
                  <td>Photo Identification</td>
                  <td><span id="has_upload_photo"></span></td>
                  <td><span id="app_docs_view_photo" class="glyphicon glyphicon-eye-open" aria-hidden="true" onClick="showPhotoId()"></span></td>
                </tr>
                <tr>
                  <td>2.</td>
                  <td>Birth Certificate</td>
                  <td id="has_upload_cert"><span></span></td>
                  <td><span id="app_docs_view_certificate" class="glyphicon glyphicon-eye-open" aria-hidden="true" onClick="showBirthCertificate()"></span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div id="buttons">
          <div class="row" style="margin-top: 136px">
            <div class="col-sm-4 col-sm-offset-8" style="text-align: right">
              <button class="btn crm-btn-primary" id="btn_edit">Edit</button>
            </div>
          </div>
        </div>
      </div>
    </section>
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
    <?php
      require('../../common/footer.php');
    ?>
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
          //
          //../student/documents/wolf1493648057.jpg
          /*
          <div>
            <strong>Middle Name:</strong><span id="appmname"></span>
          </div>
          <div>
            <strong>Last Name:</strong><span id="applname"></span>
          </div>
          */
          $photo_id = student.photo_id;
          $cert = student.birth_certificate;

          if(!$photo_id){
            $('#has_upload_photo').html('No');
            $('#app_docs_view_photo').addClass('disableIcon');
          } else {
            $('#has_upload_photo').html('Yes');
            $("#photoId").attr("src", '../'+student.photo_id);
          }

          if(!$cert){
            $('#has_upload_cert').html('No');
            $('#app_docs_view_certificate').addClass('disableIcon');
          } else {
            $('#has_upload_cert').html('Yes');
            $("#birthCertificate").attr("src", '../'+student.birth_certificate);
          }


          $('#fname').html(student.fname||'missing');
          $('#mname').html(student.mname||'missing');
          $('#lname').html(student.lname||'missing');
          $('#age').html( student.age ||'missing');
          $('#gender').html( student.gender ||'missing');
          $('#religion').html( student.religion ||'missing');
          $('#nationality').html( student.nationality||'missing');
          $('#enrollment_yr').html(student.enrollment_year || 'missing');
          // var parents = student.parents;
          var tblHTML = '';


          $("#app_parents_body").append(tblHTML);


          var photo_id = student.photo_id;
          var birth_certificate = student.birth_certificate;


          $('#btn_edit').click(function(){
            /*edit the student param, encode it and put in in url*/
            var temp = student;
            temp['parents']=null;
            var studentData = encodeURIComponent(JSON.stringify(temp));
            // console.log(studentData);
            window.location = "http://localhost/schoolcrm/pages/editStudentBasic.php?data="+studentData;
          });
          //
          // $('#btn_app_reject').click(function(){
          //   $.ajax({
          //       type: 'POST',
          //       url: '../../scripts/processStudentApplication.php',
          //       data: {
          //         id: student.id,
          //         mode: 'reject',
          //       },
          //     }).done(function(response){
          //       console.log(response);
          //       // var results = JSON.parse(response);
          //       console.log(response);
          //       window.location = "http://localhost/schoolcrm/pages/teacher/applications.php";
          //
          //     }).fail(function(error){
          //       console.log("error occurred");
          //       console.log(error.responseText);
          //       // console.log(error.responseText);
          //     });
          // });

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
