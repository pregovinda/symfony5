<?php

namespace App\Entity;

use App\Repository\ParticipantRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParticipantRepository::class)
 */
class Participant
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="participants")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Conversation", inversedBy="participants")
     */
    protected $conversation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setConversation(Conversation $conversation)
    {
        $this->conversation = $conversation;
    }

    public function getConversation(): Conversation
    {
        return $this->conversation;
    }
}
