<?php

namespace App\Repository;

use App\Entity\Employer;
use App\Entity\GlobalCourse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GlobalCourse|null find($id, $lockMode = null, $lockVersion = null)
 * @method GlobalCourse|null findOneBy(array $criteria, array $orderBy = null)
 * @method GlobalCourse[]    findAll()
 * @method GlobalCourse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GlobalCourseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, GlobalCourse::class);
    }

    public function availableGlobalCourses(int $employerId) {
        return $this->availableGlobalCoursesQueryBuilder($employerId)
            ->getQuery()->getResult();
    }

    public function availableGlobalCoursesQueryBuilder(int $employerId): QueryBuilder {
        $q = $this->createQueryBuilder('gc');
        return $q
            ->select('gc')
            ->leftJoin('gc.employerCourses',"ec")
            ->where('ec.employer is null')
            ->OrWhere('ec.employer != :employer')
            ->setParameter("employer",$employerId);
    }

    // /**
    //  * @return GlobalCourse[] Returns an array of GlobalCourse objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GlobalCourse
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
