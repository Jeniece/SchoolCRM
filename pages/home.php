<?php
  session_start();
  print_r($_SESSION);
  // var_dump($_SESSION['user']);
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
      <div class="row">
        <div class="col-md-3">
          <div>UserId: <?echo $_SESSION['user']["id"]?></div>
          <div>User Email: <?echo $_SESSION['user']["email"]?></div>
        </div>
        <div class="col-md-3">
          <a class="btn btn-warning" href="./parentbasic.php">Sign up</a>
        </div>
        <div class="col-md-3">
          <button class="btn btn-warning">A button</button>
        </div>
        <div class="col-md-3">
          <button class="btn btn-warning">Another button</button>
        </div>
      </div>
    </section>
    <?php
      require('../common/footer.php');
    ?>
  </body>
</html>
