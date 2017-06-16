<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>School CRM</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/schoolcrm.css" />
    <script src="../js/jquery-3.1.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
  </head>
  <body>
    <header id="headerContainer">
      This is a header
    </header>
    <section class="container-fluid crm-container">
      <div id="addStudentSuccess">
        Successfully Added Student
      </div>
    </section>
    <?php
      require('../common/footer.php');
    ?>
  </body>
</html>
