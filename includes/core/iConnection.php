<?php declare(strict_types=1);
  /**
   * Interface for every database connector
   */
  interface iConnection
  {
    public function startConnection();
    public function stopConnection();
  }
?>
