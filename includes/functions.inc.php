<?php declare(strict_types=1);
  /**
   * Method returning an array indexed by the id of the objects in the array
   * @param  array $arr array of objects
   *        !! Make sure the objects have a "getId()" function to retrieve the id !!
   * @return array return the indexed by id array
   * @return NULL  if array was found to be empty
   */
  function arrayWithIdAsKey(?array $arr): ?array
  {
    if (isset($arr) && !empty($arr))
    {
      $arrayWithIdAsKey;
      foreach ($arr as $a) {
        $arrayWithIdAsKey[$a->getId()] = $a;
      }
      unset($a);
      return $arrayWithIdAsKey;
    } else {
      return NULL;
    }
  }

  /**
   * Displays the javascript alert message from within php
   * @param string $message The message to be displayed in the alert
   */
  function alertMessage(string $message)
  {
    if(isset($message) && !empty($message)) {
      echo '<script type="text/javascript">alert("' . $message . '");</script>';
    }
  }

  /**
   * Random string generator
   * @param  int $numbersOfCharacters how many random characters
   * @param  string $keySpace what characters should be used for randomization
   *     If no keyspace is given, standerd keyspace is:
   *     numbers, small letters and big letters.
   * @return string randomized string of characters defined in $keySpace of length $numbersOfCharacters
   */
  function createRandomString(int $numbersOfCharacters,
          string $keySpace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'): string
  {
    $pieces = [];
    $max = mb_strlen($keySpace, '8bit') - 1;
    for ($i = 0; $i < $numbersOfCharacters; ++$i) {
        $pieces [] = $keySpace[random_int(0, $max)];
    }
    return implode('', $pieces);
  }

  /* ---------------------------------------------------------------------------
   * ONLY FOR DEBUGGING
   */
   /**
    * Function for writing to the browser console with php
    * used for debugging (only?).
    * @param  string $message the message to be printed to the console
    */
  function writeToConsole(string $message) {
    if(isset($message) && !empty($message)) {
      echo '<script type="text/javascript">console.log("' . $message . '");</script>';
    }
  }
?>
