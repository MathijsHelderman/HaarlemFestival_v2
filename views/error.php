<?php

  ob_start(); // Got header errors so this fixes that...

  function doStuff() {

    if ($_SESSION['lastPageIsIndex']) {
      echo "Something wrong, pages cannot load. Please try again later!" .
        " You can try to click <a href='/Login/index'>here</a>.";
    }
    else if (isset($_SESSION['errorPageMessage']) && !empty($_SESSION['errorPageMessage'])) {
      header("refresh:5;url=/Login/index"); //wait for 5 seconds before redirecting
      $_SESSION['lastPageIsIndex'] = true; // Cannot risk an endless header when the index page doesn't load
      echo $_SESSION['errorPageMessage'] . " You should be automatically redirected in 5 seconds." .
        " Otherwise click <a href='/Login/index'>here</a>.";
      exit();
    }
    else {
      header("refresh:3;url=/Login/index"); //wait for 3 seconds before redirecting
      $_SESSION['lastPageIsIndex'] = true; // Cannot risk an endless header when the index page doesn't load
      echo "Unknown error, you should be automatically redirected in 3 seconds." .
         " Otherwise click <a href='/Login/index'>here</a>.";
      exit();
    }

    ob_flush();
  }
?>

<section class="error">
  <h3>Oeps!</h3>
  <p class="errorBericht">
    <?php
      doStuff();
    ?>
  </p>
</section>
