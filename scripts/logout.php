<?php
  session_start();
  $_SESSION = array();

  session_destroy();
  header('Location: http://localhost/schoolcrm/pages/login.php');
?>
