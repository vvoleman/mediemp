<?php

namespace App\Repository;

use App\Entity\DataAsset;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DataAsset|null find($id, $lockMode = null, $lockVersion = null)
 * @method DataAsset|null findOneBy(array $criteria, array $orderBy = null)
 * @method DataAsset[]    findAll()
 * @method DataAsset[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DataAssetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, DataAsset::class);
    }

    // /**
    //  * @return DataAsset[] Returns an array of DataAsset objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DataAsset
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
