<?php declare(strict_types=1);
  /**
   * Model of an address
   */
  class Address extends Model implements JsonSerializable
  {
    // fields
    private $id;
    private $street;
    private $house_number;
    private $house_number_addition;
    private $zipcode;
    private $city;
    private $state;
    private $country;

    function __construct(int $id, string $street,
            int $house_number, string $house_number_addition,
            string $zipcode, string $city, string $state, string $country)
    {
      parent::__construct();
      $this->id = $id;
      $this->street = $street;
      $this->house_number = $house_number;
      $this->house_number_addition = $house_number_addition;
      $this->zipcode = $zipcode;
      $this->city = $city;
      $this->state = $state;
      $this->country = $country;
    }

    // getters
    public function getId(): int { return $this->id; }
    public function getStreet(): string { return $this->street; }
    public function getHouseNumber(): int { return $this->house_number; }
    public function getHouseNumberAddition(): string { return $this->house_number_addition; }
    public function getZipcode(): string { return $this->zipcode; }
    public function getCity(): string { return $this->city; }
    public function getState(): string { return $this->state; }
    public function getCountry(): string { return $this->country; }

    // Define the magic set method so no unwanted parameters are created
    public function __set($a,$b){}

    public function jsonSerialize() {
        return (object) get_object_vars($this);
    }
}
?>
