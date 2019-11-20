<section class="">
  <form action="/Login/do_forgottenPassword" method="POST">
    <h2>Forgotten password:</h2>

    <p>Did you forget your password? Please enter your email below. You will get
    an email from us with a link to reset your password. This link will stay valid for 2 calender days!</p>

    <label>Email:</label>
    <!-- Display a warning if that's needed -->
    <?php
      if (@isset($_SESSION['errorEmail']) || !empty($_SESSION['errorEmail'])) {
        echo '<label class="error">' . $_SESSION['errorEmail'] . '</label>';
        unset($_SESSION['errorEmail']);
      }
    ?>
    <input type="email" name="email" autocomplete="new-password" required>

    <div class="">
      <button type="submit" name="forgotButton" class="btn" id="forgotButton">Send request</button>
    </div>
  </form>
</section>

<?php
  // Add the js files at the bottom of the page
  // First load the generic js files.
  loadResource(VIEWS . "common". DS. "scripts.php");
  // Then load the page specific scripts. These may depend on the generic
  // scripts, therefore they are loaded after those.
?>
