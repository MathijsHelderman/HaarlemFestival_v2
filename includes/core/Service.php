<?php
/**
 * Core Service class
 */
abstract class Service
{
  protected $invalidChars = "<>!#$%^&*+[]{}?:;|'\"\\/~`=";
  protected $messages = [
    'empty' => "Field was empty!",
    'invalidChar' => "These characters are not allowed: <>!#$%^&*+[]{}?:;|'\"\\/~`=",
      'invalidId' => "There was something wrong with the selected option.",
      'invalidEmail' => "Not a valid email.",
      'invalidIban' => "Not a valid IBAN.",
      'noString' => "Input was not recognized.",
      'noInt' => "Not a whole number (integer).",
      'noFloat' => "Not a point number.",
      'notPositive' => "Input needs to be higher than 0."];

  function __construct()
  {
    // code...
  }

  // INPUT LOGIC

  /**
   * Function getting the generic messages used in controllers.
   * @param  string $type specifing which message is to be returned
   * @return string       the message
   * @return NULL         if the message was not found in $this->messages
   */
  protected function getMessage(string $type): ?string {
    return (array_key_exists($type,$this->messages)) ? $this->messages[$type] : NULL;
  }


    /**
     * Checks if an input isset and not empty.
     * @param  string $input
     * @param  NULL   $input
     * @return bool           true if isset and NOT empty
     */
    protected function checkIssetAndNotEmpty(?string $input): bool {
      return (isset($input) && !empty($input));
    }

    /**
     * Check if the input is a valid email address
     * @param  string $input possible email address
     * @return bool          true if valid email
     */
    private function checkEmail(string $input): bool {
      return (filter_var($input, FILTER_VALIDATE_EMAIL) !== false);
    }

    /**
     * This method checks any text input that's given by the user on
     * invalid characters. As this input can only be an email address
     * or name of something, a lot of the special characters are not allowed.
     * The characters that are not allowed are defined in $this->invalidChars.
     * @param  string $input  any input by the user
     * @return bool           returns true if the input is valid and
     *                        "passed" this test.
     */
    private function checkChars(string $input): bool {
      // Check if the input is possibly an email address
      // if not check for the characters that are not allowed as defined
      // in $invalidChars.
      if (strpos($input, '@') > -1) {
        return $this->checkEmail($input);
      }
      else {
        $array = str_split($this->invalidChars);
        foreach ($array as $key => $invalidChar) {
          if (strpos($input, $invalidChar) > -1) {
              // If one of the characters out of invalidChars was found
              // in the string, immediatly return false: the input did
              // not pass the test.
              return false;
          }
        }
        return true;
      }
    }

    /**
     * This method checks if the selected option has a
     * correct "value" of an id of an object. The ids of
     * objects are always above 0 as MySQL auto increment
     * starts at 1. An invalid intval() conversion will return 0
     * and therefore this method will know if the id was invalid.
     * @param  int  $input
     * @return bool
     */
    private function checkId(int $input): bool {
      return $this->checkHigherThanZero($input);
    }

    /**
     * This method uses the php-iban library made by globalcitizen
     * to check if the given input is a valid IBAN. The library can
     * be found in the "vendor" folder.
     * @param  string $input
     * @return bool          true if the input is a valid IBAN.
     */
    private function checkIBAN(string $input): bool {
      // Load the php-iban library.
      require_once(VENDOR . 'globalcitizen' . DS .
              'php-iban' . DS .'php-iban.php');
      return verify_iban($input,$machine_format_only=false);
    }

    /**
     * This method checks if an integer or float equals
     * or is higher than 0. If the intval method was used on anything
     * other than an actual int, like string, null, double or anything else,
     * the result will always be 0. It is therefore not possible to check
     * if the input was anything other than an int. But if 0 or null was allowed
     * it doesn't really matter, the result will be 0.
     * @param  int/float $input
     * @return bool             true if the number is 0 or higher.
     */
    private function checkZeroOrHigher($input): bool {
      return ($input >= 0);
    }
    /**
     * This method checks if an integer or float is higher than 0.
     * @param  int/float $input
     * @return bool             true if the number is higher than 0.
     */
    private function checkHigherThanZero($input): bool {
      return ($input > 0);
    }

    /**
     * This method can check some input specified on the following types:
     *    1: 'string'
     *    2: 'id'
     *    3: 'email'
     *    4: 'iban'
     *    5: 'int'
     *    6: 'float'
     * If there is an error, it will put an according error message in the
     * given SESSION variable given by the parameter $errorSession.
     * If the input is as expected it will return true, otherwise false.
     * @param  string $type         which type the $input should be
     * @param  type   $input        any input to be checked
     * @param  string $errorSession the name of the SESSION variable that
     *                              should receive the error message in case
     *                              there is something wrong with the input.
     *                              Defaul: "". If no SESSION variables need to be set.
     * @param  bool   $nullable     if the input may be null: = true: default = false
     * @return bool                 true if the input is as expected.
     */
    protected function checkInput(string $type, $input, string $errorSession = "", bool $nullable = false): bool {
      switch ($type) {
        case 'string':
          if ($this->checkIssetAndNotEmpty($input)) {
            if (is_string($input)) {
              if ($this->checkChars($input)) {
                return true;
              } else {
                if ($errorSession !== "") {$_SESSION[$errorSession] = $this->getMessage('invalidChar');}
                return false;
              }
            } else {
              if ($errorSession !== "") {$_SESSION[$errorSession] = $this->getMessage('noString');}
              return false;
            }
          } else {
            if ($errorSession !== "") {$_SESSION[$errorSession] = $this->getMessage('empty');}
            return false;
          }
        case 'id':
          if (is_int($input)) {
            if ($this->checkId($input)) {
              return true;
            } else {
              if ($errorSession !== "") {$_SESSION[$errorSession] = $this->getMessage('invalidId');}
              return false;
            }
          } else {
            if ($errorSession !== "") {$_SESSION[$errorSession] = $this->getMessage('invalidId');}
            return false;
          }
        case 'email':
          if ($this->checkIssetAndNotEmpty($input)) {
            if (is_string($input)) {
              if ($this->checkEmail($input)) {
                return true;
              } else {
                if ($errorSession !== "") {$_SESSION[$errorSession] = $this->getMessage('invalidEmail');}
                return false;
              }
            } else {
              if ($errorSession !== "") {$_SESSION[$errorSession] = $this->getMessage('noString');}
              return false;
            }
          } else {
            if ($errorSession !== "") {$_SESSION[$errorSession] = $this->getMessage('empty');}
            return false;
          }
        case 'iban':
          if ($this->checkIssetAndNotEmpty($input)) {
            if (is_string($input)) {
              if ($this->checkIBAN($input)) {
                return true;
              } else {
                if ($errorSession !== "") {$_SESSION[$errorSession] = $this->getMessage('invalidIban');}
                return false;
              }
            } else {
              if ($errorSession !== "") {$_SESSION[$errorSession] = $this->getMessage('noString');}
              return false;
            }
          } else {
            if ($errorSession !== "") {$_SESSION[$errorSession] = $this->getMessage('empty');}
            return false;
          }
        case 'int':
          if (is_numeric($input) && is_int($input)) {
            // Check if null or 0 is allowed.
            if ($nullable) {
              if ($this->checkZeroOrHigher($input)) {
                return true;
              } else {
                if ($errorSession !== "") {$_SESSION[$errorSession] = $this->getMessage('notPositive');}
                return false;
              }
            } else {
              if ($this->checkHigherThanZero($input)) {
                return true;
              } else {
                if ($errorSession !== "") {$_SESSION[$errorSession] = $this->getMessage('notPositive');}
                return false;
              }
            }
          } else {
            if ($errorSession !== "") {$_SESSION[$errorSession] = $this->getMessage('noInt');}
            return false;
          }
        case 'float':
          if (is_numeric($input) && is_float($input)) {
            // Check if null or 0 is allowed.
            if ($nullable) {
              if ($this->checkZeroOrHigher($input)) {
                return true;
              } else {
                if ($errorSession !== "") {$_SESSION[$errorSession] = $this->getMessage('notPositive');}
                return false;
              }
            } else {
              if ($this->checkHigherThanZero($input)) {
                return true;
              } else {
                if ($errorSession !== "") {$_SESSION[$errorSession] = $this->getMessage('notPositive');}
                return false;
              }
            }
          } else {
            if ($errorSession !== "") {$_SESSION[$errorSession] = $this->getMessage('noFloat');}
            return false;
          }
        default:
          $_SESSION['errorPageMessage'] = "\nInput could not be checked!";
          $this->redirect('Error', 'index', '?input=unchecked');
      }
    }

 ?>
