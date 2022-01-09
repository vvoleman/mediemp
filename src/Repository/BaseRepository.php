<?php

namespace App\Repository;

use App\Entity\Bug;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\Persistence\ManagerRegistry;

abstract class BaseRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry, string $entityClass) {
        parent::__construct($registry, $entityClass);
    }

    public abstract function assemble(array $data): Entity;

    /**
     * Assembles entities from array of key-values
     * @param array $arr
     * @return array
     */
    public function assembleMany(array $arr): array {
        $entities = [];
        foreach ($arr as $a){
            $entities[] = $this->assemble($a);
        }
        return $entities;
    }

}