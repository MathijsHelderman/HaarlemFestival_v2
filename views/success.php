<section class="">
  <h3>Success!</h3>
  <p>
    <?php
      if (isset($_SESSION['successPageMessage']) && !empty($_SESSION['successPageMessage'])) {
        header("refresh:5;url=/Login/index"); //wait for 5 seconds before redirecting
        echo $_SESSION['successPageMessage'];
        echo " You should be automatically redirected in 5 seconds." .
          " Otherwise click <a href='/Login/index'>here</a>.";
        exit();
      }
      else {
        echo "Unkown success!";
        exit();
      }
    ?>
  </p>
</section>
