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
        <header>Survey Center</header>
        <section>
          <p>
            This section is the central hub for all survey functionality. This functionality includes:
          </p>
          <article>
            <h4>Manage Surveys</h4>
            <p>

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
