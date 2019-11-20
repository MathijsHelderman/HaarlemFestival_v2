<?php declare(strict_types=1);
/**
 *  Controller of the success pages
 */
class Success_Controller extends Controller
{
  public function index() {
    $this->setView('success.php', [], 2);
    $this->view->render(true,false);
  }
}

?>
