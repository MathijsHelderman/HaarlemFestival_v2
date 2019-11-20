<?php declare(strict_types=1);
/**
 * Core Application class
 */
class Application
{
  protected $controller = 'Login_Controller'; // default to login controller
  protected $action = 'index'; // default to index page
  protected $params = []; // default empty array

  function __construct() {
    // Check if the maintenance page should be shown
    if (MAINTENANCE) {
      session_destroy();
      !@include_once(VIEWS . "maintenance.php");
      exit();
    } else {
      $this->parseURL(); // first parse the url

      // check if the controller exists and if so, call the controller and the action
      // and if there is, pass the params
      if (file_exists(CONTROLLERS . $this->controller . '.php')) {
        if (method_exists($this->controller, $this->action)) {
          if (!empty($this->params)) {
            call_user_func_array([new $this->controller,$this->action],[$this->params]);
          }
          else {
            call_user_func([new $this->controller,$this->action]);
          }
        }
        else {
          // If the controller is known but the action is not, go to index but
          // alert the user that the action was unkown and
          // add "action=unkown" to url to indicate the error
          $controller = str_replace("_Controller", "", $this->controller);
          header("refresh:0.1;url=".DS.$controller.DS.'index?action=unkown');
          alertMessage("This part of the URL is unknown: '".htmlentities($this->action)."', please check the url!");
        }
      }
      else {
        $_SESSION['errorPageMessage'] = "This URL is not recognized! Please try again!";
        call_user_func_array([new Error_Controller, "index"], ['?controller=unknown']);
      }
    }
  }

  /**
   * This function dissects the url into it's functional components
   * These components are:
   *  1. Controller
   *  2. Action
   *  3. Id(s) split on DIRECTORY_SEPARATOR
   *  4. String of parameters after "?", http request "GET"-able
   *  end
   * @return nothing the fields of this application class are set, namely:
   *  1. $this->controller
   *  2. $this->action
   *  3. $this->params
   */
  private function parseURL() {
    // First trim whitespace and backslashes from the ends of the url
    $req = trim($_SERVER['REQUEST_URI'], '/');
    if (!empty($req)) {
      // First seperate the url on the first question mark like the following:
      // controller/action(optional:/id etc.)?parameters
      $sepURL = explode('?', $req, 2);

      // Devide the components of the url by exploding on the backslashes
      $url = explode('/', $sepURL[0]);

    /* DEBUGGING!!!
     * Check with the URL if the first value is the controller or the
     * folder name of the project/application. Depending on that
     * unset the first index(es) of the $url[]
     * Make sure to keep this in mind in every other url in the app as well*/
      // echo "This is the url: " . $req;
      // unset($url[0]); // This case, unset
      // $url = array_values($url); // Reindex the array after the unset

      // Assign the controller and action
      $this->controller =
        (isset($url[0]) && !empty($url[0])) ? $url[0] . "_Controller" : "Login_Controller";
      $this->action =
        (isset($url[1]) && !empty($url[1])) ? $url[1] : "index";

      // Remove the controller and action, the rest of the url is params
      unset($url[0], $url[1]);

      // If set: push the optional parameters from after the question mark
      // to the parameter array
      // DEBUGGING: add back to url to be passed along to Controller or not, and just use $_GET?
      if (isset($sepURL[1]) && !empty($sepURL[1])) {
        array_push($url, $sepURL[1]);
      }

      $this->params = !empty($url) ? array_values($url) : [];
    }
  }
}

 ?>
