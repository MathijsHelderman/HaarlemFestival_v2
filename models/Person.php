<?php declare(strict_types=1);
  /**
   * Model of a person
   */
  class Person extends Model implements JsonSerializable
  {
    // fields
    private $id;
    private $first_name;
    private $last_name;
    private $address;
    private $added_by;
    private $date_added;

  /**
   * Person constructor
   * @param int      $id
   * @param string   $first_name    first name
   * @param string   $last_name     last name
   * @param Address  $address       address
   * @param int      $added_by      added_by
   * @param DateTime $date_added    datetime of addition to database
   */
    function __construct(int $id, string $first_name,
            string $last_name, Address $address,
            int $added_by, DateTime $date_added)
    {
      parent::__construct();
      $this->id = $id;
      $this->first_name = $first_name;
      $this->last_name = $last_name;
      $this->address = $address;
      $this->added_by = $added_by;
      $this->date_added = $date_added;
    }

    // getters
    public function getId(): int { return $this->id; }
    public function getFirstName(): string { return $this->first_name; }
    public function getLastName(): string { return $this->last_name; }
    public function getAddress(): string { return $this->address; }
    public function getAddedBy(): int { return $this->added_by; }
    public function getDateAdded(): DateTime { return $this->date_added; }

    public function getName(): string { return $this->first_name + $this->last_name; }

    // Define the magic set method so no unwanted parameters are created
    public function __set($a,$b){}

    public function jsonSerialize() {
        return (object) get_object_vars($this);
    }
  }
?>
