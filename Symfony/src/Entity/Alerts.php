<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Alerts
 *
 * @ORM\Table(name="alerts")
 * @ORM\Entity
 */
class Alerts
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
     * @ORM\Column(name="AlertType", type="string", length=0, nullable=false)
     */
    private $alerttype;

    /**
     * @var string
     *
     * @ORM\Column(name="Title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="StartTime", type="datetime", nullable=false, options={"default"="current_timestamp()"})
     */
    private $starttime = 'current_timestamp()';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="EndTime", type="datetime", nullable=true, options={"default"="NULL"})
     */
    private $endtime = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="AffectedRoutes", type="text", length=65535, nullable=false)
     */
    private $affectedroutes;

    /**
     * @var string
     *
     * @ORM\Column(name="AffectedStations", type="text", length=65535, nullable=false)
     */
    private $affectedstations;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAlerttype(): ?string
    {
        return $this->alerttype;
    }

    public function setAlerttype(string $alerttype): self
    {
        $this->alerttype = $alerttype;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStarttime(): ?\DateTimeInterface
    {
        return $this->starttime;
    }

    public function setStarttime(\DateTimeInterface $starttime): self
    {
        $this->starttime = $starttime;

        return $this;
    }

    public function getEndtime(): ?\DateTimeInterface
    {
        return $this->endtime;
    }

    public function setEndtime(?\DateTimeInterface $endtime): self
    {
        $this->endtime = $endtime;

        return $this;
    }

    public function getAffectedroutes(): ?string
    {
        return $this->affectedroutes;
    }

    public function setAffectedroutes(string $affectedroutes): self
    {
        $this->affectedroutes = $affectedroutes;

        return $this;
    }

    public function getAffectedstations(): ?string
    {
        return $this->affectedstations;
    }

    public function setAffectedstations(string $affectedstations): self
    {
        $this->affectedstations = $affectedstations;

        return $this;
    }


}
