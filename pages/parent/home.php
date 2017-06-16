<?php
  session_start();
  // print_r($_SESSION);
  // var_dump($_SESSION['user']);

  $displayName = $_SESSION['user']['email'];
  $profileComplete= $_SESSION['user']['hasCompletedInfo'];
  if(isset($_SESSION['user']['fname']) && !empty($_SESSION['user']['fname'])){
    $displayName = $_SESSION['user']['fname'];
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
      <div class="row" id="homeContainer">
        <main class="col-sm-8">
          <article>
            <h3>Welcome <?php echo $displayName;?></h3>
            <p style="font-size:18px">
              <span class="glyphicon glyphicon-warning-sign" aria-hidden="true" style="color: red; margin-right: 6px;"></span>
              <a href="http://localhost/schoolcrm/pages/parentbasic.php">Stop! Click here to complete your profile information.</a>
              <div style="display: <?php if($profileComplete == 0) echo 'none'; else echo 'initial';?>">
                xyz
              </div>
            </p>
          </article>
        </main>
        <aside class="col-sm-3 col-sm-offset-1">
          <header>Recent Activity</header>
          <div id="recent_news_body">

          </div>
        </aside>
        <!-- <div class="col-md-3">
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
        </div> -->
      </div>
    </section>

    <?php
      require('../../common/footer.php');
    ?>
    <script>
      $.ajax({
          type: 'GET',
          url: '../../scripts/getRecentActivity.php',
        }).done(function(response){
          // console.log(response);
          var articles = JSON.parse(response);


          var tblHTML = '';
          articles.forEach(function(article, index){
            tblHTML += '<div class="post">'+ article.article +'</div>'
          });

          $("#recent_news_body").append(tblHTML);

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
    </script>
  </body>
</html>
