<?php

namespace App\Entity;

use App\Repository\DataAssetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DataAssetRepository::class)
 */
class DataAsset {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $schemaFile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sourceLink;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $changeFrequencyDays;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    public function getId(): ?int {
        return $this->id;
    }

    public function getName(): ?string {
        return $this->name;
    }

    public function setName(string $name): self {
        $this->name = $name;

        return $this;
    }

    public function getSchemaFile(): ?string {
        return $this->schemaFile;
    }

    public function setSchemaFile(string $schemaFile): self {
        $this->schemaFile = $schemaFile;

        return $this;
    }

    public function getSourceLink(): ?string {
        return $this->sourceLink;
    }

    public function setSourceLink(string $sourceLink): self {
        $this->sourceLink = $sourceLink;

        return $this;
    }

    public function getChangeFrequencyDays(): ?int {
        return $this->changeFrequencyDays;
    }

    public function setChangeFrequencyDays(?int $changeFrequencyDays): self {
        $this->changeFrequencyDays = $changeFrequencyDays;

        return $this;
    }

    public function getType(): ?string {
        return $this->type;
    }

    public function setType(string $type): self {
        $this->type = $type;

        return $this;
    }
}
