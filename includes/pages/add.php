<?php
  $tags = array();

  if (!empty($_POST)) {
    $id = trim($_GET['id']);

    // Note data
    if (isset($_POST['content']))
      $body = $_POST['content'];

    // Tag data
    if (isset($_POST['tag_body']))
      $tag_body = $_POST['tag_body'];

    if ($_GET['op'] == "new")
      $current_user->add_item($body);

    else if ($_GET['op'] == "update")
      $current_user->update_item($id, $body);

    else if ($_GET['op'] == "newtag")
      $current_user->add_tag($id, $tag_body);
  }
  else {
  //set form action
  $action = "/add/new/0000";

  if (isset($_GET['id'])) {
    // Tag handling
    if (isset($_GET['op']) && $_GET['op'] == "rmtag") {
      $url = explode('s', $_GET['id']);
      $t_id = $url[0];
      $s_id = $url[1];

      $current_user->rm_tag($t_id);
      $session->redirect('/add/' . $s_id);
    }

    $data = $current_user->get_stuph();

    foreach ($data as $item) {
      if ($item->get_id() == $_GET['id']) {
        $div_inner_html = $item->get_body();
        $tags = $item->get_tags();
        $action = "/add/update/" . $item->get_id();
      }
    }
  }
?>

<script>
  function getContent() {
    document.getElementById("t_area").value = document.getElementById("add").innerHTML;
  }

  function showTagInput() {
    document.getElementById("new_tag").removeAttribute("class");
    document.getElementById("new_tag").setAttribute('class', 'tag');
    document.getElementById("tag_input").focus();
  }
</script>

<span class="page_title">Add - Edit</span>
<div class="tags">
<?php
  foreach ($tags as $tag) {
?>
  <span class="tag"><?php echo $tag->name;?>&nbsp;
    <a href="/add/rmtag/<?php echo $tag->id . 's' . $_GET['id'];?>">
      <span class="icon-close"></span>
    </a>
  </span>
<?
  }
?>
<?php
  if (isset($_GET['id'])) { ?>
  <span class="icon-plus" style="cursor:pointer" onclick="showTagInput()"></span>
  <?php } ?>
  <form style="display:initial" method="POST" action="/add/newtag/<?php echo $_GET['id']?>">
    <span id="new_tag" class="tag new_tag">
      <input name="tag_body" id="tag_input" type="text"></input>
      <input id="tag_submit" type="submit" style="display:none;"></input>
    </span>
  </form>
</div>
<div class="widget" id="add" contenteditable="true">
  <?php
  if (isset($div_inner_html))
    echo $div_inner_html;
  ?>
</div>

<form method="POST" action="<?php echo $action;?>" onsubmit="return getContent()">
    <textarea name="content" id="t_area" style="display:none"></textarea>
    <button class="add_submit" type="submit" name="submit">
      <span>SAVE</span>
      <span class="icon-arrow-up-right2"></span>
    </button>
</form>

<?php
// end else
}
?>