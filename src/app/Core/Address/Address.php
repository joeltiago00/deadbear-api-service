<?php

namespace App\Core\Address;


class Address
{
    /**
     * @param string $street
     * @param string $number
     * @param string $neighborhood
     * @param string $zipcode
     * @param string $city
     * @param string $state
     * @param string $country
     */
    public function __construct(
        private readonly string $street,
        private readonly string $number,
        private readonly string $neighborhood,
        private readonly string $zipcode,
        private readonly string $city,
        private readonly string $state,
        private readonly string $country,
    ) { }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @return string
     */
    public function getNeighborhood(): string
    {
        return $this->neighborhood;
    }

    /**
     * @return string
     */
    public function getZipcode(): string
    {
        return $this->zipcode;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'country' => $this->country,
            'street' => $this->street,
            'street_number' => $this->number,
            'state' => $this->state,
            'city' => $this->city,
            'neighborhood' => $this->neighborhood,
            'zipcode' => $this->zipcode
        ];
    }
}
