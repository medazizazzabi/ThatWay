<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Vehicles
 *
 * @ORM\Table(name="vehicles", indexes={@ORM\Index(name="RouteID", columns={"RouteID"})})
 * @ORM\Entity
 */
class Vehicles
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
     * @ORM\Column(name="Type", type="string", length=0, nullable=false)
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="Capacity", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $capacity;

    /**
     * @var array|null
     *
     * @ORM\Column(name="AccessibilityFeatures", type="simple_array", length=0, nullable=true, options={"default"="'none'"})
     */
    private $accessibilityfeatures = '\'none\'';

    /**
     * @var \Routes
     *
     * @ORM\ManyToOne(targetEntity="Routes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="RouteID", referencedColumnName="ID")
     * })
     */
    private $routeid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): self
    {
        $this->capacity = $capacity;

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

    public function getRouteid(): ?Routes
    {
        return $this->routeid;
    }

    public function setRouteid(?Routes $routeid): self
    {
        $this->routeid = $routeid;

        return $this;
    }


}
