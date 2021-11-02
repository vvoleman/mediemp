<?php

namespace App\Repository;

use App\Entity\BugCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BugCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method BugCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method BugCategory[]    findAll()
 * @method BugCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BugCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BugCategory::class);
    }

    // /**
    //  * @return BugCategory[] Returns an array of BugCategory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BugCategory
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
