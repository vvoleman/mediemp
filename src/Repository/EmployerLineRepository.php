<?php

namespace App\Repository;

use App\Entity\EmployerLine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EmployerLine|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmployerLine|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmployerLine[]    findAll()
 * @method EmployerLine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployerLineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmployerLine::class);
    }

    // /**
    //  * @return EmployerLine[] Returns an array of EmployerLine objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EmployerLine
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
