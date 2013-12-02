<?php
  if (isset($_GET['page'])) {
    if ($_GET['page'] === "home") {
      $homeClassName = "active white";
    }

    else if ($_GET['page'] === "add") {
      $stuphClassName = "active";
    }

    else if ($_GET['page'] === "settings") {
      $setsClassName = "active";
    }
    
    else if ($_GET['page'] === "trash") {
      $trashClassName = "active";
    }
    else if ($_GET['page'] === "search") {
      $searchClassName = "active";
    }
  }
  else {
    $_GET['page'] = "home";
    $homeClassName = "active white";
  }
?>

<div class="nav">
  <span class="title">Stuph</span>
  <div class="nav_menu">
    <ul>
      <a href="/home">
        <li class="<?php echo $homeClassName;?>">
          <br>
          <span class="nav_icon icon-notebook"></span>
          <span>Notes</span>
          <div class="triangle"></div>
        </li>
      </a>
      <a href="/add">
        <li class="<?php echo $stuphClassName;?>">
          <br>
          <span class="nav_icon icon-pencil2"></span>
          <span>++Stuph</span>
          <div class="triangle"></div>
        </li>
      </a>
      <a href="/trash">
        <li class="<?php echo $trashClassName;?>">
          <br>
          <span class="nav_icon icon-remove2"></span>
          <span>Trash</span>
          <div class="triangle"></div>
        </li>
      </a>
      <a href="/search">
        <li class="<?php echo $searchClassName;?>">
          <br>
          <span class="nav_icon icon-search"></span>
          <span>Search</span>
          <div class="triangle"></div>
        </li>
      </a>
      <a href="/settings">
        <li class="<?php echo $setsClassName;?>">
          <br>
          <span class="nav_icon icon-settings"></span>
          <span>Settings</span>
          <div class="triangle"></div>
        </li>
      </a>
    </ul>
  </div>
</div>
