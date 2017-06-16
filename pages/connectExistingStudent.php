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
      Header!
    </header>
    <section class="container-fluid crm-container">
      <form id="studentSearchForm" class="form-horizontal" action="../scripts/searchStudent.php" method="post">
        <input class="form-control input-lg" type="text" placeholder="Enter first name" name='fname'/>
        <input class="form-control input-lg" type="text" placeholder="Enter last name" name='lname'/>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
    </section>
    <?php
      require('../common/footer.php');
    ?>
    <script>
      // var form = $('#loginForm');
      // $(form).submit(function(e){
      //   e.preventDefault();
      //   var formData = $(form).serialize();
      //
      //   $.ajax({
      //     type: 'POST',
      //     url: '../scripts/login.php',
      //     data: formData
      //   }).done(function(response){
      //     console.log('login scrip form');
      //     console.log(response);
      //     window.location = "http://localhost/schoolcrm/pages/home.php";
      //   }).fail(function(error){
      //     console.log("error occurred");
      //     console.log(error);
      //     $("#loginAlert")
      //       .addClass("alert-danger")
      //       .text(error.responseText);
      //   });
      //   // console.log('login button clicked');
      //   // var email = $('#iptEmail')[0].value;
      //   // var password = $('#iptPassword')[0].value;
      //   // console.log(email, password);
      // });
    </script>
  </body>
</html>
