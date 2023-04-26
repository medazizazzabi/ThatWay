<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Chatmessages
 *
 * @ORM\Table(name="chatmessages", indexes={@ORM\Index(name="ChatSessionID", columns={"ChatSessionID"})})
 * @ORM\Entity
 */
class Chatmessages
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
     * @ORM\Column(name="Sender", type="string", length=0, nullable=false)
     */
    private $sender;

    /**
     * @var string
     *
     * @ORM\Column(name="Message", type="text", length=65535, nullable=false)
     */
    private $message;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Timestamp", type="datetime", nullable=false, options={"default"="current_timestamp()"})
     */
    private $timestamp = 'current_timestamp()';

    /**
     * @var \Chatsessions
     *
     * @ORM\ManyToOne(targetEntity="Chatsessions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ChatSessionID", referencedColumnName="ID")
     * })
     */
    private $chatsessionid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSender(): ?string
    {
        return $this->sender;
    }

    public function setSender(string $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

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

    public function getChatsessionid(): ?Chatsessions
    {
        return $this->chatsessionid;
    }

    public function setChatsessionid(?Chatsessions $chatsessionid): self
    {
        $this->chatsessionid = $chatsessionid;

        return $this;
    }


}
