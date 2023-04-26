<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Feedback
 *
 * @ORM\Table(name="feedback", indexes={@ORM\Index(name="UserID", columns={"UserID"})})
 * @ORM\Entity
 */
class Feedback
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
     * @ORM\Column(name="FeedbackType", type="string", length=0, nullable=false)
     */
    private $feedbacktype;

    /**
     * @var int
     *
     * @ORM\Column(name="TargetID", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $targetid;

    /**
     * @var string
     *
     * @ORM\Column(name="Category", type="string", length=0, nullable=false)
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="SubmittedAt", type="datetime", nullable=false, options={"default"="current_timestamp()"})
     */
    private $submittedat = 'current_timestamp()';

    /**
     * @var string
     *
     * @ORM\Column(name="Status", type="string", length=0, nullable=false, options={"default"="'open'"})
     */
    private $status = '\'open\'';

    /**
     * @var string|null
     *
     * @ORM\Column(name="ResolutionDescription", type="text", length=65535, nullable=true, options={"default"="NULL"})
     */
    private $resolutiondescription = 'NULL';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="ResolvedAt", type="datetime", nullable=true, options={"default"="NULL"})
     */
    private $resolvedat = 'NULL';

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

    public function getFeedbacktype(): ?string
    {
        return $this->feedbacktype;
    }

    public function setFeedbacktype(string $feedbacktype): self
    {
        $this->feedbacktype = $feedbacktype;

        return $this;
    }

    public function getTargetid(): ?int
    {
        return $this->targetid;
    }

    public function setTargetid(int $targetid): self
    {
        $this->targetid = $targetid;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

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

    public function getSubmittedat(): ?\DateTimeInterface
    {
        return $this->submittedat;
    }

    public function setSubmittedat(\DateTimeInterface $submittedat): self
    {
        $this->submittedat = $submittedat;

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

    public function getResolutiondescription(): ?string
    {
        return $this->resolutiondescription;
    }

    public function setResolutiondescription(?string $resolutiondescription): self
    {
        $this->resolutiondescription = $resolutiondescription;

        return $this;
    }

    public function getResolvedat(): ?\DateTimeInterface
    {
        return $this->resolvedat;
    }

    public function setResolvedat(?\DateTimeInterface $resolvedat): self
    {
        $this->resolvedat = $resolvedat;

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
