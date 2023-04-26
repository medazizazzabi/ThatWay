<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Loyaltypointshistory
 *
 * @ORM\Table(name="loyaltypointshistory", indexes={@ORM\Index(name="UserID", columns={"UserID"})})
 * @ORM\Entity
 */
class Loyaltypointshistory
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
     * @var int
     *
     * @ORM\Column(name="PointsChange", type="integer", nullable=false)
     */
    private $pointschange;

    /**
     * @var string
     *
     * @ORM\Column(name="ChangeType", type="string", length=0, nullable=false)
     */
    private $changetype;

    /**
     * @var string
     *
     * @ORM\Column(name="RelatedEntity", type="string", length=0, nullable=false)
     */
    private $relatedentity;

    /**
     * @var int
     *
     * @ORM\Column(name="EntityID", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $entityid;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Timestamp", type="datetime", nullable=false, options={"default"="current_timestamp()"})
     */
    private $timestamp = 'current_timestamp()';

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="UserID", referencedColumnName="ID")
     * })
     */
    private $userid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPointschange(): ?int
    {
        return $this->pointschange;
    }

    public function setPointschange(int $pointschange): self
    {
        $this->pointschange = $pointschange;

        return $this;
    }

    public function getChangetype(): ?string
    {
        return $this->changetype;
    }

    public function setChangetype(string $changetype): self
    {
        $this->changetype = $changetype;

        return $this;
    }

    public function getRelatedentity(): ?string
    {
        return $this->relatedentity;
    }

    public function setRelatedentity(string $relatedentity): self
    {
        $this->relatedentity = $relatedentity;

        return $this;
    }

    public function getEntityid(): ?int
    {
        return $this->entityid;
    }

    public function setEntityid(int $entityid): self
    {
        $this->entityid = $entityid;

        return $this;
    }

    public function getTimestamp(): ?\DateTimeInterface
    {
        return $this->timestamp;
    }

    public function setTimestamp(\DateTimeInterface $timestamp): self
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    public function getUserid(): ?Users
    {
        return $this->userid;
    }

    public function setUserid(?Users $userid): self
    {
        $this->userid = $userid;

        return $this;
    }


}
