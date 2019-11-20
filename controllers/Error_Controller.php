<?php declare(strict_types=1);
/**
 *  Controller of the error pages
 */
class Error_Controller extends Controller
{
  public function index() {
    $this->setView('error.php', [], 3);
    $this->view->render(true,false);
  }
}

?>
