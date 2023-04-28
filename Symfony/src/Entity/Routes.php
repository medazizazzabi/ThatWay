<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Routes
 *
 * @ORM\Table(name="routes")
 * @ORM\Entity
 */
class Routes
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="Mode", type="string", length=0, nullable=false)
     */
    private $mode;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="RouteDuration", type="time", nullable=false)
     */
    private $routeduration;

    /**
     * @var string
     *
     * @ORM\Column(name="Fare", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $fare;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getMode(): ?string
    {
        return $this->mode;
    }

    public function setMode(string $mode): self
    {
        $this->mode = $mode;

        return $this;
    }

    public function getRouteduration(): ?\DateTimeInterface
    {
        return $this->routeduration;
    }

    public function setRouteduration(\DateTimeInterface $routeduration): self
    {
        $this->routeduration = $routeduration;

        return $this;
    }

    public function getFare(): ?string
    {
        return $this->fare;
    }

    public function setFare(string $fare): self
    {
        $this->fare = $fare;

        return $this;
    }

    //add startStation and endStation properties
    /**
     * @var Stations
     *
     */
    private $startstationid;

    /**
     * @var Stations
     *
     */

    private $endstationid;

    //add getters and setters for startStation and endStation
    public function getStartstationid(): ?Stations
    {
        return $this->startstationid;
    }

    public function setStartstationid(?Stations $startstationid): self
    {
        $this->startstationid = $startstationid;

        return $this;
    }

    public function getEndstationid(): ?Stations
    {
        return $this->endstationid;
    }

    public function setEndstationid(?Stations $endstationid): self
    {
        $this->endstationid = $endstationid;

        return $this;
    }

    //add status property
    /**
     * @var string
     *
     */
    private $status;

    //add getter and setter for status
    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {

        $this->status = $status;

        return $this;
    }

}
