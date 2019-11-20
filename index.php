<?php
// error_reporting(E_ALL);

// DEBUGGING:
// Depending on production run or development run
// turn display_errors on or off.
ini_set('display_errors', 0);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// ini_set('log_errors', 1);

/**
 * Paths defines for whole application
 * @var string paths
 */
  define('DS', DIRECTORY_SEPARATOR);
  define('ROOT', dirname(__FILE__) . DS);
  define('INCLUDES', ROOT . 'includes' . DS);

  try {
    if (
      (@!include_once(INCLUDES . "includes.inc.php"))
    ) { // @ - to suppress warnings,
      throw new Exception();
    }
    else if (
      !file_exists(INCLUDES . "includes.inc.php")
    ) {
      throw new Exception();
    }
    else {
      require_once(INCLUDES . "includes.inc.php");
    }
  } catch(\Exception $e) {
    echo  "Couldn't load resources!";
    exit();
  }

  // Start the session at the beginning of the Application
  // so it can be used throught the whole application.
  session_start();

  // In case there needs to be maintenance on the application
  define("MAINTENANCE", false);    // IF WORKING ON APP: true
  define("MAINTENANCE_MESSAGE", "We are currently doing some
    maintenance on the application. Please come back later!");
  define("MAINTENANCE_TIME", "01-01-12020 00:00");

  // Start the application
  new Application;
?>
