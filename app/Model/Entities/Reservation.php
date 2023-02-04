<?php

namespace App\Model\Entities;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

#[Entity]
class Reservation
{
    #[Id]
    #[Column(type: Types::INTEGER, nullable: false)]
    #[GeneratedValue]
    protected int $id;

    #[Column(type: Types::STRING, nullable: true)]
    public ?string $agency;

    #[Column(type: Types::STRING, nullable: true)]
    public ?string $name;

    #[Column(type: Types::TEXT, nullable: true)]
    public ?string $info;

    #[Column(type: Types::TEXT, nullable: true)]
    public ?string $price;

    #[Column(type: Types::INTEGER, nullable: true)]
    public ?string $paid;

    #[Column(type: Types::TEXT, nullable: true)]
    public ?string $orderID;

    #[Column(type: Types::STRING, nullable: true)]
    public ?string $phone;

    #[Column(type: Types::STRING)]
    public ?string $email;

    #[Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    public ?\DateTimeInterface $emailDate;


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getAgency(): ?string
    {
        return $this->agency;
    }

    /**
     * @param string|null $agency
     */
    public function setAgency(?string $agency): void
    {
        $this->agency = $agency;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getInfo(): ?string
    {
        return $this->info;
    }

    /**
     * @param string|null $info
     */
    public function setInfo(?string $info): void
    {
        $this->info = $info;
    }

    /**
     * @return string|null
     */
    public function getPrice(): ?string
    {
        return $this->price;
    }

    /**
     * @param string|null $price
     */
    public function setPrice(?string $price): void
    {
        $this->price = $price;
    }

    /**
     * @return string|null
     */
    public function getPaid(): ?string
    {
        return $this->paid;
    }

    /**
     * @param string|null $paid
     */
    public function setPaid(?string $paid): void
    {
        $this->paid = $paid;
    }

    /**
     * @return string|null
     */
    public function getOrderID(): ?string
    {
        return $this->orderID;
    }

    /**
     * @param string|null $orderID
     */
    public function setOrderID(?string $orderID): void
    {
        $this->orderID = $orderID;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     */
    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getEmailDate(): ?\DateTimeInterface
    {
        return $this->emailDate;
    }

    /**
     * @param \DateTimeInterface|null $emailDate
     */
    public function setEmailDate(?\DateTimeInterface $emailDate): void
    {
        $this->emailDate = $emailDate;
    }

}