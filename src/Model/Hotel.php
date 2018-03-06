<?php

namespace App\Model;

use JMS\Serializer\Annotation as Serializer;

class Hotel
{
    /**
     * @var string
     * @Serializer\SerializedName("name")
     * @Serializer\Type("string")
     */
    protected $name;

    /**
     * @var float
     * @Serializer\SerializedName("price")
     * @Serializer\Type("float")
     */
    protected $price;

    /**
     * @var string
     * @Serializer\SerializedName("city")
     * @Serializer\Type("string")
     */
    protected $city;

    /**
     * @var array
     * @Serializer\SerializedName("availability")
     * @Serializer\Type("array")
     */
    protected $availability;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return array
     */
    public function getAvailability(): array
    {
        return $this->availability;
    }

    /**
     * @param array $availability
     */
    public function setAvailability(array $availability): void
    {
        $this->availability = $availability;
    }
}