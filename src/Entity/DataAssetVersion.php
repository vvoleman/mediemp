<?php

namespace App\Entity;

use App\Repository\DataAssetVersionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DataAssetVersionRepository::class)
 */
class DataAssetVersion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=DataAsset::class, inversedBy="dataAssetVersions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $dataAsset;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fileName;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="float")
     */
    private $processTime;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDataAsset(): ?DataAsset
    {
        return $this->dataAsset;
    }

    public function setDataAsset(?DataAsset $dataAsset): self
    {
        $this->dataAsset = $dataAsset;

        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt = null): self {
        if(!$createdAt){
            $createdAt = new \DateTimeImmutable();
        }

        $this->createdAt = $createdAt;//->format("Y-m-d H:i:s");

        return $this;
    }

    public function getProcessTime(): ?float
    {
        return $this->processTime;
    }

    public function setProcessTime(float $processTime): self
    {
        $this->processTime = $processTime;

        return $this;
    }
}
