<?php declare(strict_types=1);
/**
 * Paths defines for whole application
 * @var string paths
 */
  // define('ROOT', dirname(__DIR__) . DS);
  define('MODELS', ROOT . 'models' . DS);
  define('VIEWS', ROOT . 'views' . DS);
  define('CONTROLLERS', ROOT . 'controllers' . DS);
  define('SERVICES', ROOT . 'services' . DS);
  define('REPOSITORIES', ROOT . 'repositories' . DS);
  define('PUBLICS', ROOT . 'publics' . DS);
  define('CORE', INCLUDES . 'core' . DS);
  define('HANDLERS', INCLUDES . 'handlers' . DS);
  define('SESSIONS', INCLUDES . 'sessions' . DS);
  define('CSS', PUBLICS . 'css' . DS);
  define('IMAGES', PUBLICS . 'images' . DS);
  define('JS', PUBLICS . 'js' . DS);
  define('PLUGINS', PUBLICS . 'plugins' . DS);
  define('VENDOR', ROOT . 'vendor' . DS);

  $directories = array(ROOT, MODELS, VIEWS, CONTROLLERS, SERVICES, REPOSITORIES,
                      PUBLICS, CORE, HANDLERS, SESSIONS, CSS, IMAGES, JS,
                      PLUGINS, VENDOR);

  // Autoloader paths
  set_include_path(get_include_path() . PATH_SEPARATOR . implode(PATH_SEPARATOR, $directories));

  // Autoloader
  spl_autoload_register('myAutoloader');

  // Tries to require the class.
  function myAutoloader($className)
  {
    // Array of directories where the autoloader should look through
    $directories = array(ROOT, MODELS, VIEWS, CONTROLLERS, SERVICES, REPOSITORIES,
                        PUBLICS, CORE, HANDLERS, SESSIONS, CSS, IMAGES, JS,
                        PLUGINS, VENDOR);
    foreach ($directories as $dir) {
      if (file_exists($dir.$className.'.php')) {
          require_once($dir.$className.'.php');
          return;
      }
    }
  }

  /**
   * Generic function handling the loading of SPECIFIC files and resources from
   * the project. Not meant to be used as a probe to see if the file exists or not.
   * Will throw an error if the file could not be found.
   * @param  string $filePath whole filepath
   */
  function loadResource(string $filePath)
  {
    try {
      if (
        (@!include_once($filePath))
      ) { // @ - to suppress warnings,
        throw new Exception();
      }
      else if (
        !file_exists($filePath)
      ) {
        throw new Exception();
      }
      else {
        require_once($filePath);
      }
    } catch(\Exception $e) {
      echo  "Couldn't load resources!";
      exit();
    }
  }

  // 1: If the autoloader fails, the error page should still be
  // accessable.
  // 2: In the file 'functions.inc.php' are generic functions to be used throughout
  // the whole application, therefore, it is included here.
  // 3: The models User and Person are included here because
  // the session is started below here and with the serialize en unserialize
  // methods used when logging in, it needs the models before the session
  // is started.
  loadResource(CORE . "Application.php");
  loadResource(CORE . "Controller.php");
  loadResource(CONTROLLERS . "Error_Controller.php");
  loadResource(INCLUDES . "functions.inc.php");
  loadResource(CORE . "Model.php");
  loadResource(MODELS . "User.php");
  loadResource(MODELS . "Person.php");
?>
