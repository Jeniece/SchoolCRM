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
        <header>Student Center</header>
        This section is the central hub for student functionality. Functionality includes the following:
        <section>
          <article>
            <h4>View Enrolled Child/Children</h4>
            <p>
              View information about your children that have been accepted as students for the current academic year.
              <a href="http://localhost/schoolcrm/pages/parent/myChildren.php">View my students.</a>
            </p>
          </article>
          <article>
            <h4>Link a Student</h4>
            <p>
              Your child may already be in our system. Perform a search against our database to check if your child exists and
              link that student to your profile.
              <a href="http://localhost/schoolcrm/pages/parent/studentSearch.php">Link a student.</a>
            </p>
          </article>
        </section>
      </div>
    </section>
    <?php
      require('../../common/footer.php');
    ?>
  </body>
</html>
