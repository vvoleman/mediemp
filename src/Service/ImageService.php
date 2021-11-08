<?php

namespace App\Service;

use App\Entity\Image;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\UrlHelper;

class ImageService {

    private FileUploaderService $uploaderService;
    private EntityManagerInterface $manager;
    private RandomService $random;

    public function __construct(FileUploaderService    $uploaderService,
                                EntityManagerInterface $manager,
                                RandomService          $random
    ) {
        $this->uploaderService = $uploaderService;
        $this->manager = $manager;
        $this->random = $random;
    }

    /**
     * @param UploadedFile $file
     * @throws \Doctrine\ORM\ORMException|FileException
     */
    public function save(UploadedFile $file): Image {
        $image = $this->initImage($file);
        $this->manager->persist($image);
        $this->manager->flush();

        return $image;
    }

    public function saveMany(array $files): array {
        $images = [];
        /** @var UploadedFile $f */
        foreach ($files as $f) {
            $temp = $this->initImage($f);
            $images[] = $temp;
            $this->manager->persist($temp);
        }
        $this->manager->flush();

        return $images;
    }

    private function initImage(UploadedFile $file): Image {
        $uuid = uniqid() . $this->random->string(16);
        $fileName = $this->uploaderService->upload($file, FileUploaderService::FOLDER . "/images", $uuid);
        $image = new Image();
        $image->setPath($fileName);
        $image->setUuid($uuid);

        return $image;
    }

}