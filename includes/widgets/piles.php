<div class="widget" id="piles">
<span class="piles_title">Piles</span>
<?php
$piles = $current_user->get_piles();

foreach ($piles as $pile) {
  if (isset($_GET['pile']))
    $class = ($_GET['pile'] == $pile->name ? 'onpile' : '');
?>
<div class="top <?php echo $class;?>">
  <a href="/home/<?php echo $pile->name;?>">
    <span><?php echo strtoupper($pile->name);?></span>
  </a>

  <a href="/home/delpile/<?php echo $pile->id?>">
    <span class="icon-close" style="float:right;"></span>
  </a>
</div>
<?php
}
?>
</div>