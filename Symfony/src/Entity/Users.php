<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @ORM\Table(name="users", uniqueConstraints={@ORM\UniqueConstraint(name="CIN", columns={"CIN"}), @ORM\UniqueConstraint(name="Email", columns={"Email"})})
 * @ORM\Entity
 */
class Users
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
     * @var string|null
     *
     * @ORM\Column(name="CIN", type="string", length=20, nullable=true, options={"default"="NULL"})
     */
    private $cin = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="Email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="Password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="Role", type="string", length=0, nullable=false, options={"default"="'user'"})
     */
    private $role = '\'user\'';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="Birthdate", type="date", nullable=true, options={"default"="NULL"})
     */
    private $birthdate = 'NULL';

    /**
     * @var point|null
     *
     * @ORM\Column(name="CurrentPosition", type="point", nullable=true, options={"default"="NULL"})
     */
    private $currentposition = 'NULL';

    /**
     * @var point|null
     *
     * @ORM\Column(name="PreviousLocation", type="point", nullable=true, options={"default"="NULL"})
     */
    private $previouslocation = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="PreferredMode", type="string", length=0, nullable=true, options={"default"="NULL"})
     */
    private $preferredmode = 'NULL';

    /**
     * @var array
     *
     * @ORM\Column(name="NotificationSettings", type="simple_array", length=0, nullable=false, options={"default"="'push_notifications'"})
     */
    private $notificationsettings = '\'push_notifications\'';

    /**
     * @var array|null
     *
     * @ORM\Column(name="AccessibilityRequirements", type="simple_array", length=0, nullable=true, options={"default"="'none'"})
     */
    private $accessibilityrequirements = '\'none\'';

    /**
     * @var int|null
     *
     * @ORM\Column(name="LoyaltyPoints", type="integer", nullable=true, options={"unsigned"=true})
     */
    private $loyaltypoints = '0';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(?string $cin): self
    {
        $this->cin = $cin;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(?\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getCurrentposition()
    {
        return $this->currentposition;
    }

    public function setCurrentposition($currentposition): self
    {
        $this->currentposition = $currentposition;

        return $this;
    }

    public function getPreviouslocation()
    {
        return $this->previouslocation;
    }

    public function setPreviouslocation($previouslocation): self
    {
        $this->previouslocation = $previouslocation;

        return $this;
    }

    public function getPreferredmode(): ?string
    {
        return $this->preferredmode;
    }

    public function setPreferredmode(?string $preferredmode): self
    {
        $this->preferredmode = $preferredmode;

        return $this;
    }

    public function getNotificationsettings(): array
    {
        return $this->notificationsettings;
    }

    public function setNotificationsettings(array $notificationsettings): self
    {
        $this->notificationsettings = $notificationsettings;

        return $this;
    }

    public function getAccessibilityrequirements(): array
    {
        return $this->accessibilityrequirements;
    }

    public function setAccessibilityrequirements(?array $accessibilityrequirements): self
    {
        $this->accessibilityrequirements = $accessibilityrequirements;

        return $this;
    }

    public function getLoyaltypoints(): ?int
    {
        return $this->loyaltypoints;
    }

    public function setLoyaltypoints(?int $loyaltypoints): self
    {
        $this->loyaltypoints = $loyaltypoints;

        return $this;
    }


}
