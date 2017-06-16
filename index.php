<?php
  session_start();

  if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
    header('Location: http://localhost/schoolcrm/pages/login.php');
  } else {
    //redirect to correct page base on user type
    if($_SESSION['user']['type'] == 'parent')
      header('Location: http://localhost/schoolcrm/pages/parent/home.php');
    else if($_SESSION['user']['type'] == 'teacher')
      header('Location: http://localhost/schoolcrm/pages/teacher/home.php');
    else
      header('Location: http://localhost/schoolcrm/pages/login.php');
  }
?>
