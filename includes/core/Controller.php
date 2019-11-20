<?php declare(strict_types=1);
/**
 * Core Controller class
 */
abstract class Controller
{
  protected $view;
  protected $loggedInUser;

  /**
   * The controllers act upon the parameters of the url. Their
   * primary responsibilities are displaying the right views.
   * By checking input and receiving boolean values from the
   * service layer, the right views are determined.
   * Set the logged in user as an object if the user is logged in.
   */
  public function __construct()
  {
    loadResource(MODELS . 'User.php');
    if (isset($_SESSION['logged_in_user']) &&
        !empty($_SESSION['logged_in_user']) &&
        $_SESSION['logged_in'] == true)
    {
      $this->loggedInUser = unserialize($_SESSION['logged_in_user']);
    } else {
      $this->loggedInUser = NULL;
    }
  }

  /**
   * If url parameters need to be checked and they are invalid,
   * stay ambiguous but tell the user there is something wrong with the url.
   * @param  string $additionalMessage another message to be displayed.
   */
  protected function invalidURL(string $additionalMessage = "") {
    $_SESSION['errorPageMessage'] = $additionalMessage . "\nThe url is invalid.";
    $this->redirect('Error', 'index', '?url=invalid');
  }

  // VIEWS LOGIC

  /**
   * Set the view with the path to the view, data of the view
   * @param string $view_file the name of the view, format:
   *    path to view from directory 'views'.
   *    !! Be sure to include '.php' or '.html', etc.
   *    !! Be sure to use "DS"'s (define of: 'DIRECTORY_SEPARATOR')
   *    if the view is in lower directories within views.
   * @param array  $view_data can be filled with data from the URL or data
   *    from the model(s).
   */
  protected function setView(string $view_file, array $view_data=[], int $metaNumber = 0)
  {
    $view_data['loggedInUser'] = $this->loggedInUser;
    $this->view = new View($view_file, $view_data, $metaNumber);
  }

  /**
   * This method immediatly renders the view as well
   *  !! WITH BANNER AND MENU !!
   * @param string  $view_file
   * @param array   $view_data
   * @param integer $metaNumber
   */
  protected function setViewRender(string $view_file, array $view_data=[], int $metaNumber = 0) {
    $this->setView($view_file, $view_data, $metaNumber);
    $this->view->render(true,true);
  }

  /**
   * This is a generic redirect function
   * @param  string $controller
   * @param  string $action
   * @param  string $params IMPORTANT!! => needs to start with
   *                        either "DIRECTORY_SEPARATOR" or a question mark: "?",
   *                        otherwise a question mark "?" will be added between
   *                        the action and the parameters
   */
  protected function redirect(string $controller, string $action, string $params="")
  {
    if ($params == "") {
      header("location:".DS.$controller.DS.$action);
    } else {
      // Check if $params starts with a DIRECTORY_SEPARATOR or ?
      if ($params[0] == DS || $params[0] == "?") {
        // put $params directly after the action as there is a seperator on index 0
        header("location:".DS.$controller.DS.$action.$params);
      } else {
      // add the "?" seperator to let the params be url parameters
      header("location:".DS.$controller.DS.$action."?".$params);
      }
    }
    exit();
  }

  /**
   * This is a generic redirect function with a delay. The delay can
   * make sure that certain actions will still be performed before
   * the redirect.
   * @param  float  $delay  how much delay in seconds
   * @param  string $controller
   * @param  string $action
   * @param  string $params IMPORTANT!! => needs to start with
   *                        either "DIRECTORY_SEPARATOR" or a question mark: "?",
   *                        otherwise a question mark "?" will be added between
   *                        the action and the parameters
   */
  protected function redirectWithDelay(float $delay, string $controller, string $action, string $params="")
  {
    if ($params == "") {
      header("refresh:".$delay.";url=".DS.$controller.DS.$action);
    } else {
      // Check if $params starts with a DIRECTORY_SEPARATOR or ?
      if ($params[0] == DS || $params[0] == "?") {
        // put $params directly after the action as there is a seperator on index 0
        header("refresh:".$delay.";url=".DS.$controller.DS.$action.$params);
      } else {
      // add the "?" seperator to let the params be url parameters
      header("refresh:".$delay.";url=".DS.$controller.DS.$action."?".$params); 
      }
    }
    exit();
  }

  /**
   * Checks if the user is logged in
   * @param  User $user the user to be checked
   *
   * @return bool true if user is logged_in
   */
  protected function checkLoggedIn(?User $user): bool
  {
    if (isset($user) && !empty($user)) {
      return ($user != NULL && $_SESSION['logged_in'] == true);
    } else { return false; }
  }

  /**
   * Checks if the user account is verified, access level does not matter
   * for this check
   * @param  User $user the user to be checked
   *
   * @return bool returns true if account is (not not) verified
   */
  private function checkVerified(?User $user): bool
  {
    return (isset($user) && $user->getVerified() > 0);
  }

  /**
   * Checks if the user is both logged in and has a verified account
   * @param  User $user the user to be checked
   *
   * @return bool
   */
  protected function checkLoggedInVerified(?User $user): bool
  {
    return ($this->checkLoggedIn($user) && $this->checkVerified($user));
  }

  /**
   * Method checking the security level of the user
   * !!! goes up for more privileges
   * @param  User $user
   * @param  int         $level
   *                          1: FM/UM
   *                          2: ADMINf
   * @return bool true if user has access
   */
  private function checkSecurityLevel(User $user, int $level): bool
  {
    // Everybody can see anything below level 1 so only above is worth checking
    return ($level > 1 && $user->getVerified() >= $level);
  }

  /**
   * Check securitylevel and loggedin and verified
   * @param  ?User $user
   * @param  int         $level security level
   * @return bool        true   if the user has access
   */
  protected function checkLoggedInVerifiedSecLev(?User $user, int $level): bool
  {
    return ($this->checkLoggedInVerified($user) && $this->checkSecurityLevel($user,$level));
  }

  /**
   *
   * When the view is also given and rendered, the application also handles the
   * cases when the user is not logged in / verified or has the correct security rights.
   * These methods are below.
   *
   */

  /**
   * Method to be called when view needs to be rendered
   * with a logged in check only
   * @param  string  $view_file
   * @param  array   $view_data
   * @param  integer $metaNumber check publics/metas.inc.php
   *                             to see which number should be
   *                             the metatags for this viewfile
   */
  protected function checkLoggedInSetViewRender(string $view_file, array $view_data=[], int $metaNumber = 0)
  {
    if ($this->checkLoggedIn($this->loggedInUser)) {
      $this->setView($view_file, $view_data, $metaNumber);
      $this->view->render(true,true);
    } else {
      session_destroy();
      $this->redirect("Login", "index", '?user!=logged_in');
    }
  }

  /**
   * Method to be called when view needs to be rendered
   * with a logged in check and a verified check
   * @param  string  $view_file
   * @param  array   $view_data
   * @param  integer $metaNumber check publics/metas.inc.php
   *                             to see which number should be
   *                             the metatags for this viewfile
   */
  protected function checkLoggedInVerifiedSetViewRender(string $view_file, array $view_data=[], int $metaNumber = 0)
  {
    if ($this->checkLoggedInVerified($this->loggedInUser)) {
      $this->setView($view_file, $view_data, $metaNumber);
      $this->view->render(true,true);
    } else {
      $this->redirect("Home", "index");
    }
  }

  /**
   * Method to be called when view needs to be rendered
   * with a logged in check and a verified check and
   * a security check!
   * @param  int     $level      security level
   * @param  string  $view_file
   * @param  array   $view_data
   * @param  integer $metaNumber check publics/metas.inc.php
   *                             to see which number should be
   *                             the metatags for this viewfile
   * @return bool    return true if user has access
   */
  protected function checkLoggedInVerifiedSecLevSetViewRender(int $level, string $view_file, array $view_data=[], int $metaNumber = 0)
  {
    if ($this->checkLoggedInVerifiedSecLev($this->loggedInUser, $level)) {
      $this->setView($view_file, $view_data, $metaNumber);
      $this->view->render(true,true);
    } else { $this->redirect("Home", "index"); }
  }
}


?>
