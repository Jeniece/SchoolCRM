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
  <body>
    <header id="headerContainer">
      This is a header
    </header>
    <section class="container-fluid crm-container">
      <div id="createSurveySection">
        <form id="uploadSurveyForm" action="../../scripts/createSurvey.php" method="post" enctype="multipart/form-data">
          <header>Upload a new survey</header>
          <div class="form-group">
            <label for="survey_name">Survey Name</label>
            <input class="form-control" id="survey_name" style="width:240px" name="survey_name" placeholder="Test Survey" required />
          </div>
          <div class="form-group">
            <label for="survey">Submit Survey</label>
            <input type="file" name="survey" id="survey"/>
          </div>

          <input type="submit" value="Submit" class="btn crm-btn-primary"/>
        </form>
      </div>
      <div id="displaySurveysSection">
        <header>Existing Surveys</header>
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
    <div id="footerContainer">
      This is the footer
    </div>
    <script>
      console.log("hello");
      $.ajax({
          type: 'GET',
          url: '../../scripts/getSurveys.php',
        }).done(function(response){
          console.log(response);
          var surveys = JSON.parse(response);
          console.log('surveys', surveys);

          var tblHTML = '';
          surveys.forEach(function(survey, index){
            tblHTML += '<tr><td>'+survey.id+'</td><td>'+survey.name+'</td><td>'+survey.created+'</td><td><a href="http://localhost/schoolcrm/scripts/downloadSurvey.php?survey_id='+survey.id+'"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span></a></td></tr>';
          });

          $("#applications_table_body").append(tblHTML);

        }).fail(function(error){
          console.log("error occurred");
          console.log(error);
        });

    </script>
  </body>
</html>
