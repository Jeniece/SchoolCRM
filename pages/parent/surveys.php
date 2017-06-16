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
      <div id="pUploadSurveySection">
        <header>Completed a survey? upload here</header>
        <form id="pUploadSurveyForm" action="../../scripts/parentUploadSurvey.php" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label>Upload Survey</label>
            <input type="file" name="survey"/>
          </div>

          <input type="submit" value="Submit" class="btn crm-btn-primary"/>
        </form>
      </div>
      <div id="pDisplaySurveySection">
        <header>Available Surveys</header>
        <table class="table table-bordered table-striped" id="applications_table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Survey Name</th>
              <th>Date Created</th>
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
    <script>
      // var applications, chosenApplication;
      $.ajax({
          type: 'GET',
          url: '../../scripts/getSurveys.php',
        }).done(function(response){
          console.log(response);
          var surveys = JSON.parse(response);
          console.log('surveys', surveys);

          var tblHTML = '';

          surveys.forEach(function(survey, index){
            var dateCreated = new Date(parseInt(survey.created))
            tblHTML += '<tr><td>'+survey.id+'</td><td>'+survey.name+'</td><td>'+dateCreated+'</td><td><a href="http://localhost/schoolcrm/scripts/downloadSurvey.php?survey_id='+survey.id+'"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span></a></td></tr>';
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

        function downloadSurvey(id){
          console.log(id);
          $.ajax({
              type: 'POST',
              url: '../../scripts/downloadSurvey.php',
              data: {
                survey_id: id,
              }
            }).done(function(response){
              console.log('response', response);
            }).fail(function(error){
              console.log("error occurred");
              console.log(error);
            });
        }
    </script>
  </body>
</html>
