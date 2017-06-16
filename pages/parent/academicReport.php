<?php
  session_start();

  if(!isset($_GET['id']) && empty($_GET['id'])){
    die('Student id is required');
  }

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
      <div class="genericContainer">
        <label><strong>Select Academic Year</strong></label>
        <div style="width:100px; margin-bottom:18px">
          <select class='form-control' id='academicYearSelect'>
            <?php
              $currentYear = date("Y");
              $startYear = 2010;
              for($i=$startYear; $i<=$currentYear; $i++){
                if($i == $currentYear){
                  echo "<option selected>$i</option>";
                } else {
                  echo "<option>$i</option>";
                }
              }
            ?>
          </select>
        </div>
        <table class="table table-bordered table-striped" id="applications_table">
          <thead>
            <tr>
              <th>Subject Name</th>
              <th>Grade</th>
              <th>Percentage</th>
              <th>Notes</th>
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
    <script>
      var studentId;
      var academicYear = "2017";
      var academicRecords = [];

      function composeAcademicReport(records){
        // console.log();
        console.log(academicRecords);
        var academicYear = parseInt($("#academicYearSelect").val());
        var records = academicRecords.filter(function(record){
          var recordYear = parseInt(record.academic_year);
          console.log('years', academicYear, recordYear);
          return recordYear === academicYear;
        });

        var tblHTML = '';
        records.forEach(function(record, index){
          tblHTML += '<tr><td>'+record.subject_name+'</td><td>'+record.grade+'</td><td>'+record.percentage+'</td><td>'+record.notes+'</td></tr>';;
        });

        $("#applications_table_body").append(tblHTML);
      }

      $.ajax({
          type: 'GET',
          url: '../../scripts/getAcademicReport.php?id=<?php echo $_GET["id"];?>',
        }).done(function(response){
          // console.log(response);
          var records = JSON.parse(response);
          academicRecords = records;
          // console.log('records', records);

          composeAcademicReport();
        }).fail(function(error){
          console.log("error occurred");
          console.log(error);
        });

        $("#academicYearSelect").change(function(e){
          $("#applications_table_body").empty();
          composeAcademicReport();

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
