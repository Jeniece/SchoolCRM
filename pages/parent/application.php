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
    <?php
      require('./header.php');
    ?>
    <section class="container-fluid crm-container">
      <div class="genericContainer">
        <header>
          Applications Center
        </header>
        <section>
          The applications section is the central hub for all application functionality. Functionality includes the following:
          <article>
            <h4>Create Application</h4>
            <p>
              Create a student application for the current academic year. This requires entering basic information and submitting documents
              for the prospective student.
              <a href="http://localhost/schoolcrm/pages/studentbasic.php">Create an application for a prospective student.</a>
            </p>
          </article>
          <article>
            <h4>Edit and View Applications</h4>
            <p>
              View student applications that are currently being processed. These applications can then be edited and resubmitted.
              <a href="http://localhost/schoolcrm/pages/parent/viewApplications.php">View an application being processed.</a>
            </p>
          </article>
          <!-- <article>
            <h4>Waitlist</h4>
            <p>
              Add your child to list of prospective students for an academic year commencing in the future.
              <a href="#">Add child to waiting list</a>
            </p>
          </article> -->
        </section>
      </div>
    </section>
    <?php
      require('../../common/footer.php');
    ?>
  </body>
</html>
