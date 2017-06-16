<?php
  session_start();
  // print_r($_SESSION);
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
    <section class="container-fluid">
      <div id="loginAlert" class="alert">
        Testing alert!
      </div>
      <div id="loginFormContainer">
        <form id="loginForm" action="../scripts/login.php" method="post">
          <div class="form-group">
            <label style="font-size: 16px;">Login Type</label><br />
            <label class="radio-inline">
              <input type="radio" name="user_type" id="parent_radio" value="parent" checked> Parent
            </label>
            <label class="radio-inline">
              <input type="radio" name="user_type" id="teacher_radio" value="teacher"> Teacher
            </label>
          </div>
          <div class="form-group">
            <label for="iptEmail" class="control-label" style="font-size: 16px;"> Email </label>
            <input type="email" class="form-control" id="iptEmail" placeholder="example@gmail.com" name="email">
          </div>
          <div class="form-group">
            <label for="iptPassword" class="control-label" style="font-size: 16px;"> Password </label>
            <input type="password" class="form-control" id="iptPassword" placeholder="****************" name="password">
          </div>
          <div class="form-group">
            <button id="loginBtn" type="Submit" class="btn">Login</button>
            <div id="forgotPass">
              <a href="#">Forgot Password</a>
            </div>
            <div style="text-align: center">
              <a href="http://localhost/schoolcrm/pages/register.php">Register</a>
            </div>
          </div>
          <!-- <div class="row">
            <div class="col-sm-8">
              <a href="#">Forgot Password</a>
            </div>
              <button type="Submit" class="btn btn-primary">Login</button>
            </div> -->
          </div>
          <!-- <div class="form-group">
            <div class="col-sm-offset-2 col-sm-6">
              <a href="#">Forgot Password</a>
            </div>
            <div class="col-sm-offset-1 col-sm-3">
              <div id="loginBtn">
                <button type="submit" class="btn btn-primary">Login</button>
              </div>
            </div>
          </div> -->
        </form>
      </div>
    </section>
    <script>
      var form = $('#loginForm');
      $(form).submit(function(e){
        e.preventDefault();
        var formData = $(form).serialize();

        $.ajax({
          type: 'POST',
          url: '../scripts/login.php',
          data: formData
        }).done(function(response){
          console.log('login scrip form');
          console.log(response);
          if(response === 'parent')
            window.location = "http://localhost/schoolcrm/pages/parent/home.php";
          else
            window.location = "http://localhost/schoolcrm/pages/teacher/home.php"
        }).fail(function(error){
          console.log("error occurred");
          console.log(error);
          $("#loginAlert")
            .addClass("alert-danger")
            .text(error.responseText);
        });
        // console.log('login button clicked');
        // var email = $('#iptEmail')[0].value;
        // var password = $('#iptPassword')[0].value;
        // console.log(email, password);
      });
    </script>
  </body>
</html>
