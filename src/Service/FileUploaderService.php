<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploaderService {

    private RandomService $randomService;
    private Filesystem $filesystem;

    public function __construct(RandomService $randomService, Filesystem $filesystem) {
        $this->randomService = $randomService;
        $this->filesystem = $filesystem;
    }


    /**
     * Uploads file
     * @param UploadedFile $file
     * @param string $directory
     * @throws FileException
     * @return string
     */
    public function upload(UploadedFile $file, string $directory): string {
        do{
            $safeFilename = $this->randomService->string(16);
            $fileName = sprintf("%s-%s.%s",$safeFilename,uniqid(),$file->guessExtension());
        }while($this->filesystem->exists($this->getFullPath($directory,$fileName)));

        $file->move($directory, $fileName);

        return $fileName;
    }

    private function getFullPath(string $directory, string $filename): string{
        return sprintf("%s/%s",$directory,$filename);
    }

//    private

}