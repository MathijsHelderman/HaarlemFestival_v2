<?php declare(strict_types=1);
  /**
   * Model of an User
   */
  class User extends Model
  {
    // fields
    private $id;
    private $email;
    private $pwdhash;
    private $ver_code;
    private $ver_code_expiry;
    private $verified;
    private $access_level;
    private $person;

    /**
     * User constructor
     * @param int            $id              login_id
     * @param string         $email           username/email
     * @param string         $pwdhash         hashed password
     * @param string         $ver_code        verification code
     * @param DateTime       $ver_code_expiry verification code expiry date
     * @param int            $verified        signifies if the account is verified
     * @param int            $access_level    access level
     * @param Person         $person          the person data
     */
    function __construct(int $id, string $email,
            string $pwdhash, string $ver_code = NULL,
            DateTime $ver_code_expiry = NULL, int $verified,
            int $access_level, Person $person)
    {
      parent::__construct();
      $this->id = $id;
      $this->email = $email;
      $this->pwdhash = $pwdhash;
      $this->ver_code = $ver_code;
      $this->ver_code_expiry = $ver_code_expiry;
      $this->verified = $verified;
      $this->access_level = $access_level;
      $this->person = $person;
    }

    // getters
    public function getId(): int { return $this->id; }
    public function getEmail(): string { return $this->email; }
    public function getPwdhash(): string { return $this->pwdhash; }
    public function getVerCode(): string { return $this->ver_code; }
    public function getVerCodeExpiry(): DateTime { return $this->ver_code_expiry; }
    public function getVerified(): int { return $this->verified; }
    public function getAccessLevel(): int { return $this->access_level; }
    public function getPerson(): Person { return $this->person; }

    // Define an empty magic set method so no unwanted parameters can be created
    public function __set($a,$b){}
  }
?>
