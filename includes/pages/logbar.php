<div class="user_bar">
  <form name="logout" method="POST" action="/logout.php">
    <span><?php echo $current_user->get_email();?></span>
    <button type="submit" name="logout">
      <span class="icon-arrow-right2"></span>
    </button>
  </form>
</div>
