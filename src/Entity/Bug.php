<?php

namespace App\Entity;

use App\Repository\BugRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BugRepository::class)
 */
class Bug {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Date
     * @ORM\Column(type="datetime_immutable")
     */
    private \DateTimeImmutable $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=BugCategory::class, inversedBy="bugs")
     * @ORM\JoinColumn(nullable=false)
     */
    private BugCategory $category;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="text")
     */
    private string $description;

    /**
     * @ORM\ManyToMany(targetEntity=Image::class)
     */
    private $screenshots;

    /**
     * @ORM\ManyToOne(targetEntity=Employee::class)
     */
    private $createdBy;

    /**
     * @Assert\Url
     * @ORM\Column(type="string", length=255)
     */
    private string $url;

    public function __construct() {
        $this->screenshots = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt = null): self {
        if(!$createdAt){
            $createdAt = new \DateTimeImmutable();
        }

        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCategory(): ?BugCategory {
        return $this->category;
    }

    public function setCategory(?BugCategory $category): self {
        $this->category = $category;

        return $this;
    }

    public function getDescription(): ?string {
        return $this->description;
    }

    public function setDescription(string $description): self {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getScreenshots(): Collection {
        return $this->screenshots;
    }

    public function addScreenshot(Image $screenshot): self {
        if (!$this->screenshots->contains($screenshot)) {
            $this->screenshots[] = $screenshot;
        }

        return $this;
    }

    public function removeScreenshot(Image $screenshot): self {
        $this->screenshots->removeElement($screenshot);

        return $this;
    }

    public function getCreatedBy(): ?Employee {
        return $this->createdBy;
    }

    public function setCreatedBy(?Employee $createdBy): self {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getUrl(): ?string {
        return $this->url;
    }

    public function setUrl(string $url): self {
        $this->url = $url;

        return $this;
    }
}
