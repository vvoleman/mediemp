<?php

namespace App\Service;

use App\Entity\Image;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageService {

    private FileUploaderService $uploaderService;
    private EntityManager $manager;

    public function __construct(FileUploaderService $uploaderService,EntityManager $manager) {
        $this->uploaderService = $uploaderService;
        $this->manager = $manager;
    }

    /**
     * @param UploadedFile $file
     * @throws \Doctrine\ORM\ORMException|FileException
     */
    public function save(UploadedFile $file): Image{
        $fileName = $this->uploaderService->upload($file,".");
        $image = new Image();
        $image->setPath($fileName);
        $image->setUuid();
        $this->manager->persist($image);

        return $image;
    }

    // Takes image and saves it into db, then returns token

}