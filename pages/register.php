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
  <body style="background-color: #3B3738">
    <section id="registerContainer">
      <div id="registerFormContainer">
        <form class="registerForm" action="../scripts/register.php" method="post">
          <div class="form-group">
            <label for="registerEmail" class="control-label"> Email </label>
            <input type="email" class="form-control" id="registerEmail" placeholder="example@gmail.com" name="email">
          </div>
          <div class="form-group">
            <label for="registerPassword" class=" control-label"> Password </label>
            <input type="password" class="form-control" id="registerPassword" placeholder="****************" name="password">
          </div>
          <div class="form-group">
            <label for="registerConfirm" class=" control-label"> Confirm Password </label>
            <input type="password" class="form-control" id="registerConfirm" placeholder="****************" name="confirm">
          </div>
          <div class="form-group">
            <label for="registerConfirm" class=" control-label"> Account Type </label>
            <select class="form-control" id="account_type" name="account_type">
              <option value="parent">Parent</option>
              <option value="teacher">Teacher</option>
            </select>
          </div>
          <div class="form-group">
            <div id="registerBtn">
              <a href="http://localhost/schoolcrm/pages/login.php" style="margin-right:75px">Take me to the login page</a>
              <button type="submit" class="btn btn-primary">Register</button>
            </div>
          </div>
        </form>
      </div>
    </section>
  </body>
