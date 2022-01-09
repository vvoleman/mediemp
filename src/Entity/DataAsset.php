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
     * @ORM\OneToMany(targetEntity=DataAssetVersion::class, mappedBy="dataAsset")
     */
    private $dataAssetVersions;

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

    public function __construct() {
        $this->dataAssetVersions = new ArrayCollection();
    }

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

    /**
     * @return Collection|DataAssetVersion[]
     */
    public function getDataAssetVersions(): Collection {
        return $this->dataAssetVersions;
    }

    public function addDataAssetVersion(DataAssetVersion $dataAssetVersion): self {
        if (!$this->dataAssetVersions->contains($dataAssetVersion)) {
            $this->dataAssetVersions[] = $dataAssetVersion;
            $dataAssetVersion->setDataAsset($this);
        }

        return $this;
    }

    public function removeDataAssetVersion(DataAssetVersion $dataAssetVersion): self {
        if ($this->dataAssetVersions->removeElement($dataAssetVersion)) {
            // set the owning side to null (unless already changed)
            if ($dataAssetVersion->getDataAsset() === $this) {
                $dataAssetVersion->setDataAsset(null);
            }
        }

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
