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
      <div id="student_profile_container" class="genericContainer">
        <div id="student_profile">
          <h3 style="margin-bottom: 24px">Student Profile</h3>
          <div class="row">
            <div class="col-sm-4">
              <img src='../../imgs/noimage.png' id='photoId'/>
            </div>
            <!-- <div class="col-sm-8" id="student_name" style="margin-top:36px; font-size: 2.5em;">
            </div> -->
            <div class="col-sm-8" style="margin-top: 36px;">
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
            </div>
          </div>
        </div>
        <div id="student_functions">
          <div style="margin-top: 24px;">
            <h4>Current Academic Report</h4>
            View the student's academic progress in all of their assigned subjects for the current academic year.
            <a href="">View report card.</a>
          </div>
          <div style="margin-top: 24px;">
            <h4>Extra Curricular Activities Report</h4>
            View the student's performance in extra curricular activities in which they were assigned.
            <a href="">View extra curricular activities performance.</a>
          </div>
          <div style="margin-top: 24px;">
            <h4>Notices</h4>
            View notes about your student that require urgent attention. <a href="">View problems.</a>
          </div>
        </div>
      </div>
    </section>
    <?php
      require('../../common/footer.php');
    ?>
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

          if($photo_id){
            $("#photoId").attr("src", '../'+student.photo_id);
          }

          var name = student.fname + ' ' + student.mname + ' ' + student.lname;
          $('#student_name').html(name || 'name not found');
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
          // console.log(error);
          console.log(error.responseText);
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
