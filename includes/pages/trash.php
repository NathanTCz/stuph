<?php
  if (isset($_GET['id'])) {
    $id = trim($_GET['id']);
    if ($_GET['op'] == "restore")
      $current_user->restore_item($id);
    else if ($_GET['op'] == "delete")
      $current_user->delete_item($id);
  }
?>

<span class="page_title">Trash : <?php echo $current_user->trash_size;?> items</span>
<div class="widget" id="trash">
<?php
$list = $current_user->get_trash();

foreach ($list as $item) {
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
<?php
}
//end foreach statment
?>
</div>

