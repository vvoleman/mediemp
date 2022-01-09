<?php

namespace App\Service\File;

use App\Service\Util\RandomService;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\KernelInterface;

class FileUploaderService {

    public const FOLDER = "/uploaded";
    //^3_~LZ8zi14Wx

    private RandomService $randomService;
    private Filesystem $filesystem;
    private KernelInterface $appKernel;

    public function __construct(RandomService $randomService, Filesystem $filesystem, KernelInterface $appKernel) {
        $this->randomService = $randomService;
        $this->filesystem = $filesystem;
        $this->appKernel = $appKernel;
    }

    /**
     * Uploads file
     * @param UploadedFile $file
     * @param string $directory
     * @throws FileException
     * @return string
     */
    public function upload(UploadedFile $file, string $directory, string $name = null): string {
        do{
            if(!$name){
                $name = $this->randomService->string(16);
            }
            $fileName = sprintf("%s.%s",$name,$file->guessExtension());
            $full = $this->getFullPath($directory,$fileName);
        }while($this->filesystem->exists($full));

        $file->move($this->appKernel->getProjectDir().$directory,$fileName);

        return $full;
    }

    private function getFullPath(string $directory, string $filename): string{
        return sprintf("%s/%s",$directory,$filename);
    }

//    private

}