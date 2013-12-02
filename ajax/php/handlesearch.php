<?php
set_include_path('/var/www/stuphapp.com');

session_start();

require_once 'classes/Session.php';
require_once 'classes/Login.php';
require_once 'classes/User.php';

// Set default landing page
if (!isset($_GET['page'])) {
  $_GET['page'] = "home";
}

// GLOBAL VARIABLES
$ERRORS = array();

$session = new Session;

if (!$session->logged_in()) {
  $session->redirect("/web/login");
  exit;
}
else if ($session->logged_in()) {
  $current_user = new User($_SESSION['user']['email'], $_SESSION['user_id'], $_SESSION['user']['zipcode']);
}

if (isset($_GET['q'])) {
  $search = $_GET['q'];

$current_user->search($search);
}

$list = $current_user->get_stuph();

foreach ($list as $item) {
  if (!$item->trash) {
?>
  <div class="list_item">
    <span id="selector"></span>
    <span id="date"><?php echo $item->get_timestamp();?></span>
    <a href="/add/<?php echo $item->get_id();?>">
      <span id="list_title"><?php echo $item->get_title();?></span>
    </a>
    <a href="/home/<?php echo $item->get_id();?>" title="trash">
      <span class="delete icon-remove2" ></span>
    </a>
  </div>
<?php
  }
  else {
?>
  <div class="list_item">
    <span id="selector"></span>
    <span id="date"><?php echo $item->get_timestamp();?></span>
    <span id="list_title"><?php echo $item->get_title();?></span>
    <a href="/trash/delete/<?php echo $item->get_id();?>" title="delete">
      <span class="delete icon-remove2" ></span>
    </a>
    <a href="/trash/restore/<?php echo $item->get_id();?>" title="restore">
      <span class="delete icon-undo" ></span>
    </a>
  </div>
<?
  }
}
//end foreach statment
?>