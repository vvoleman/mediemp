<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\InheritanceType;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string")
     */
    private string $type;

    /**
     * @ORM\OneToOne(targetEntity=Employee::class, mappedBy="identity", cascade={"persist", "remove"})
     */
    private ?Employee $employee;

    /**
     * @ORM\OneToOne(targetEntity=Admin::class, mappedBy="identity", cascade={"persist", "remove"})
     */
    private ?Admin $admin;

    public function getId(): ?int {
        return $this->id;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function setEmail(string $email): self {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string {
        return (string)$this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string {
        return (string)$this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string {
        return $this->password;
    }

    public function setPassword(string $password): self {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials() {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function setUser($user) {
        switch ($user::TYPE_NAME) {
            case Admin::TYPE_NAME:
                $this->setAdmin($user);
                break;
            case Employee::TYPE_NAME:
                $this->setEmployee($user);
                break;
        }
    }

    public function getUser() {
        switch ($this->type) {
            case Admin::TYPE_NAME:
                return $this->admin;
            case Employee::TYPE_NAME:
                return $this->employee;
        }
    }

    public function setEmployee(Employee $employee): self {
        // set the owning side of the relation if necessary
        if ($employee->getIdentity() !== $this) {
            $employee->setIdentity($this);
            if ($this->admin->getIdentity() === $this) {
                $this->admin->setIdentity(null);
            }
        }

        $this->type = $employee::TYPE_NAME;
        $this->employee = $employee;

        return $this;
    }

    public function setAdmin(Admin $admin): self {
        // set the owning side of the relation if necessary
        if ($admin->getIdentity() !== $this) {
            $admin->setIdentity($this);
            if ($this->employee->getIdentity() === $this) {
                $this->employee->setIdentity(null);
            }
        }
        $this->type = $admin::TYPE_NAME;
        $this->admin = $admin;

        return $this;
    }

    public function getType(): string {
        return $this->type;
    }

    public function setType(string $type): void {
        $this->type = $type;
    }


}
