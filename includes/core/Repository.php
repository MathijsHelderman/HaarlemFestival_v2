<?php declare(strict_types=1);
/**
 * Core Repository class
 */
abstract class Repository
{
  protected $conn;

  public function __construct() {

  }

  protected function startConnection()
  {
    ////// InHolland
    // $dbhost = '';
    // $dbname = '';
    // $dbusername = '';
    // $dbpassword = '';
    // $charset = 'utf8mb4';

    $dbhost = 'localhost';
    $dbname = 'HaarlemFestival';
    $dbusername = 'root';
    $dbpassword = '';
    $charset = 'utf8mb4';

    try {
        $databasesourcename = "mysql:host=$dbhost;dbname=$dbname;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        $this->conn = new PDO($databasesourcename, $dbusername, $dbpassword, $options);
    } catch(\PDOException $e) {
      $_SESSION['errorPageMessage'] = "Error! Kan geen verbinding met de database maken.";
      header("location: /Error/index");
      exit();
    }
  }

  protected function closeConnection()
  {
    $this->conn = NULL;
  }

  /**
   * !!! DEBUGGING: This method is to be used until the database id columns
   * are converted to all be 'id'. !!!
   *
   * Generic function for getting all data of a specific object from
   * the database if there is a matching record by id.
   * !!! Only if the table in the database has a 'id' column !!!
   * @param  string $table  table name
   * @param  string $column column name of id column
   * @param  int    $id     id to be matched against
   * @return array         if matching object from the database was found
   * @return NULL           if no matching object was found
   */
  // protected function getOnId(string $table, string $column, int $id): ?array {
  //   try {
  //     $this->startConnection();
  //     $getObject = $this->conn->prepare(
  //       'SELECT * FROM :table
  //        WHERE :column = :id');
  //     $getObject->bindParam(':table', $table, PDO::PARAM_STR);
  //     $getObject->bindParam(':column', $column, PDO::PARAM_STR);
  //     $getObject->bindParam(':id', $id, PDO::PARAM_INT);
  //     $getObject->execute();
  //     $effectedRows = $getObject->rowCount();
  //
  //     if ($effectedRows > 0) {
  //       $object = $getObject->fetch();
  //       $getObject = NULL;
  //       $this->closeConnection();
  //       return $object;
  //     } else {
  //       return NULL;
  //     }
  //   } catch(\Exception $e) {
  //     $_SESSION['errorPageMessage'] = "Couldn't load resources!" ;
  //     header("location: /Error/index");
  //     exit();
  //   }
  // }

  /**
   * !!! DEBUGGING: This method is to be used when the database id columns
   * are converted to all be 'id'. !!!
   *
   * Generic function for getting all data of a specific object from
   * the database if there is a matching record by id.
   * !!! Only if the table in the database has a 'id' column !!!
   * @param  string $table table name
   * @param  int    $id    id to be matched against
   * @return array         if matching object from the database was found
   * @return NULL          if no matching object was found
   */
  // protected function getOnId(string $table, int $id): ?array {
  //   try {
  //     $this->startConnection();
  //     $getObject = $this->conn->prepare(
  //       'SELECT * FROM :table
  //        WHERE id = :id');
  //     $getObject->bindParam(':table', $table, PDO::PARAM_STR);
  //     $getObject->bindParam(':id', $id, PDO::PARAM_INT);
  //     $getObject->execute();
  //     $effectedRows = $getObject->rowCount();
  //
  //     if ($effectedRows > 0) {
  //       $object = $getObject->fetch();
  //       $getObject = NULL;
  //       $this->closeConnection();
  //       return $object;
  //     } else {
  //       return NULL;
  //     }
  //   } catch(\Exception $e) {
  //     $_SESSION['errorPageMessage'] = "Couldn't load resources!" ;
  //     header("location: /Error/index");
  //     exit();
  //   }
  // }

  /**
   * Generic function for getting all data of a specific object from
   * the database if there is a matching record by name.
   * !!! Only if the table in the database has a 'name' column !!!
   * @param  string $table table name
   * @param  string $name  name to be matched against
   * @return array         if matching object from the database was found
   * @return NULL          if no matching object was found
   */
  // protected function getOnName(string $table, string $name): ?array {
  //   try {
  //     $this->startConnection();
  //     $getObject = $this->conn->prepare(
  //       'SELECT * FROM :table
  //        WHERE name = :name');
  //     $getObject->bindParam(':table', $table, PDO::PARAM_STR);
  //     $getObject->bindParam(':name', $name, PDO::PARAM_STR);
  //     $getObject->execute();
  //     $effectedRows = $getObject->rowCount();
  //
  //     if ($effectedRows > 0) {
  //       $object = $getObject->fetch();
  //       $getObject = NULL;
  //       $this->closeConnection();
  //       return $object;
  //     } else {
  //       return NULL;
  //     }
  //   } catch(\Exception $e) {
  //     $_SESSION['errorPageMessage'] = "Couldn't load resources!" ;
  //     header("location: /Error/index");
  //     exit();
  //   }
  // }

  /**
   * Generic function getting all records from a table out of the database.
   * @param  string $table which table
   * @return array         if a matching table was found and there are
   *                       records in the table.
   * @return NULL          if no table was found, or no records were found
   */
  // protected function getAll(string $table): ?array {
  //   try {
  //     $this->startConnection();
  //     $getAll = $this->conn->prepare(
  //       'SELECT * FROM :table');
  //     $getAll->bindParam(':table', $table, PDO::PARAM_STR);
  //     $getAll->execute();
  //     $objects = $getAll->fetchAll();
  //     $getAll = NULL;
  //     $this->closeConnection();
  //     return (isset($objects) && !empty($objects)) ?
  //             $objects : NULL;
  //   } catch(\Exception $e) {
  //     $_SESSION['errorPageMessage'] = "Couldn't load resources!" ;
  //     header("location: /Error/index");
  //     exit();
  //   }
  // }
}
 ?>
