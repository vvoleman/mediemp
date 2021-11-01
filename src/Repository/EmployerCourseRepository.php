<?php

namespace App\Repository;

use App\Entity\EmployerCourse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EmployerCourse|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmployerCourse|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmployerCourse[]    findAll()
 * @method EmployerCourse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployerCourseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmployerCourse::class);
    }

    // /**
    //  * @return EmployerCourse[] Returns an array of EmployerCourse objects
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
    public function findOneBySomeField($value): ?EmployerCourse
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
