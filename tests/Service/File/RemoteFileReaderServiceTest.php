<?php

namespace App\Tests\Service\File;

use App\Entity\EmployerLine;
use App\Repository\EmployerLineRepository;
use App\Service\File\RemoteFileReaderService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RemoteFileReaderServiceTest extends KernelTestCase {

    private EmployerLineRepository $repository;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        /** @var EntityManagerInterface $manager */
        $manager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->repository = $manager->getRepository(EmployerLine::class);
    }


    /**
     * Tests time
     * @covers \App\Service\File\RemoteFileReaderService
     */
    public function testReadToDatabase() {
        dd($this->repository->find(44742));
    }

    private function deleteRows(){

    }
}
