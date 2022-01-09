<?php

namespace App\Entity;

use App\Repository\AdminRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdminRepository::class)
 */
class Admin {

    public const TYPE_NAME = "admin";

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="admin", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private ?User $identity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdentity(): ?User
    {
        return $this->identity;
    }

    public function setIdentity(?User $identity): self
    {
        $this->identity = $identity;

        return $this;
    }
}
