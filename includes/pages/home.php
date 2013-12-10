<?php
// Set default title
$title = "Stuph";

  if (isset($_GET['id'])) {
    $item_ids = trim($_GET['id']);
    $item_ids = explode('t', $item_ids);

    if (isset($_GET['op']) && $_GET['op'] == "trash") {
      foreach ($item_ids as $id)
        $current_user->trash_item($id);
    }

    if (isset($_GET['op']) && $_GET['op'] == "pileup") {
      if (!empty($_POST)) {
        $pile_title = str_replace(' ', '', $_POST['tag_body']);
        $current_user->create_pile($item_ids, $pile_title);
      }
    }

    if (isset($_GET['op']) && $_GET['op'] == "delpile") {
        $current_user->delete_pile($item_ids[0]);
    }

    if (isset($_GET['op']) && $_GET['op'] == "editpile") {
        $current_user->edit_pile($item_ids[0], $item_ids[1]);
    }
  }

  if (isset($_GET['pile'])) {
    foreach ($current_user->get_piles() as $pile) {
      if ($pile->name == $_GET['pile']) {
        $title = $pile->name;
        $current_user->stuph_size = count($pile->s_ids);

        $stuph = $current_user->get_stuph();

        foreach($stuph as $thing)
          if (in_array($thing->get_id(), $pile->s_ids))
            $list[] = $thing;
      }
    }
  }
  else {
    $list = $current_user->get_stuph();
  }
?>

<script src="/js/handleChecks.js"></script>

<?php
  include 'includes/widgets/piles.php';
?>

<div class="widget" id="home">
<div class="home_title">
<span><?php echo $title . ' : ' . $current_user->stuph_size;?> items
<div id="tools" class="widget tools">
  <span class="delete icon-remove2" style="cursor:pointer" title="delete selected" onclick="handle_trash()"></span>

  <span class="icon-drawer2" title="create new pile" onclick="showTagInput()"></span>
  <form name="pile_form" method="POST" style="display:initial" onsubmit="handle_action()">
    <span id="new_pile" class="new_pile">
      <input name="tag_body" id="tag_input" type="text"></input>
      <input id="tag_submit" type="submit" style="display:none;"></input>
    </span>
  </form>
</div>
</span>
</div>

<?php
foreach ($list as $item) {
?>
  <div id="list_item<?php echo $item->get_id()?>" class="list_item" oncontextmenu="getPositions(this.event, <?php echo $item->get_id();?>); return false;">
    <span id="selector"></span>
    <span id="check">
      <input id="<?php echo $item->get_id()?>" type="checkbox" name="item" value="<?php echo $item->get_id();?>" onchange="handle_checks(this.value)">
      </input>
      <label for="<?php echo $item->get_id()?>"\</label>
    </span>
    <span id="date"><?php echo $item->get_timestamp();?></span>
    <a href="/add/<?php echo $item->get_id();?>">
      <span id="list_title"><?php echo $item->get_title();?></span>
    </a>
    <span class="item_tools">
      <a title="right click to add to a pile" oncontextmenu="getPositions(this.event, <?php echo $item->get_id();?>); return false;">
        <span class="icon-drawer2"></span>
      </a>
      <a href="/home/trash/<?php echo $item->get_id();?>" title="trash">
        <span class="icon-remove2" ></span>
      </a>
    </span>
  </div>

  <div id="pile_list<?php echo $item->get_id();?>" class="pile_list">
    <?php
    foreach ($current_user->get_piles() as $pile) {
    ?>
    <a href="/home/editpile/<?php echo $pile->id . 't' . $item->get_id();?>" title="click to add to this pile">
      <span><?php echo $pile->name;?></span>
    </a>
    <?php
    }
    ?>
  </div>
<?php
}
//end foreach statment
?>
</div>