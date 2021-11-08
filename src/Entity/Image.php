<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Cassandra\UuidInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 */
class Image
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $path;

    /**
     * @var string|null
     * @ORM\Column(type="string",unique=true)
     */
    private string $uuid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function getPublicUrl(){
        return "";
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getUuid(): string {
        return $this->uuid;
    }

    public function setUuid(string $uuid = null): void {
        if(!$uuid){
            $uuid = Uuid::v4()->toRfc4122();
        }

        $this->uuid = $uuid;
    }


}
