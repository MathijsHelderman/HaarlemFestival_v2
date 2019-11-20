<?php !@include_once(VIEWS . "common" . DS . "header.php");?>
  <section class="">
    <h1 class="maintenance_title">Sorry for this inconvenience!</h1>

    <p class="maintenance_message">
      <?php echo MAINTENANCE_MESSAGE; ?>
    </p>

    <p class="maintenance_time">Expected time to be back online:
      <?php echo MAINTENANCE_TIME; ?>
    </p>
  </section>
<?php !@include_once(VIEWS . "common" . DS . "footer.php");?>
