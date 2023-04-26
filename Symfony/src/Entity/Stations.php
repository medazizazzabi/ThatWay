<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Stations
 *
 * @ORM\Table(name="stations")
 * @ORM\Entity
 */
class Stations
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
     * @var point
     *
     * @ORM\Column(name="Location", type="point", nullable=false)
     */
    private $location;

    /**
     * @var string
     *
     * @ORM\Column(name="Status", type="string", length=0, nullable=false)
     */
    private $status;

    /**
     * @var array|null
     *
     * @ORM\Column(name="AccessibilityFeatures", type="simple_array", length=0, nullable=true, options={"default"="'none'"})
     */
    private $accessibilityfeatures = '\'none\'';

    /**
     * @var array|null
     *
     * @ORM\Column(name="Facilities", type="simple_array", length=0, nullable=true, options={"default"="'none'"})
     */
    private $facilities = '\'none\'';

    /**
     * @var string|null
     *
     * @ORM\Column(name="OperatingHours", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $operatinghours = 'NULL';

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

    public function getLocation()
    {
        return $this->location;
    }

    public function setLocation($location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getAccessibilityfeatures(): array
    {
        return $this->accessibilityfeatures;
    }

    public function setAccessibilityfeatures(?array $accessibilityfeatures): self
    {
        $this->accessibilityfeatures = $accessibilityfeatures;

        return $this;
    }

    public function getFacilities(): array
    {
        return $this->facilities;
    }

    public function setFacilities(?array $facilities): self
    {
        $this->facilities = $facilities;

        return $this;
    }

    public function getOperatinghours(): ?string
    {
        return $this->operatinghours;
    }

    public function setOperatinghours(?string $operatinghours): self
    {
        $this->operatinghours = $operatinghours;

        return $this;
    }


}
