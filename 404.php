<?php
  require_once 'core/init.php';

  if (!$session->logged_in()) {
    $session->redirect("/web/login");
    exit;
  }
  else if ($session->logged_in()) {
    $current_user = new User($_SESSION['user']['email'], $_SESSION['user_id'], $_SESSION['user']['zipcode']);
  }

  include 'includes/main/header.php';
  include 'includes/pages/404.php';
  include 'includes/main/footer.php';
?>
