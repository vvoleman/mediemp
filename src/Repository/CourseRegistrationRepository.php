<?php

namespace App\Repository;

use App\Entity\CourseRegistration;
use App\Entity\Employee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CourseRegistration|null find($id, $lockMode = null, $lockVersion = null)
 * @method CourseRegistration|null findOneBy(array $criteria, array $orderBy = null)
 * @method CourseRegistration[]    findAll()
 * @method CourseRegistration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourseRegistrationRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, CourseRegistration::class);
    }

    public function getForEmployeeQuery(Employee $employee): QueryBuilder {
        $q = $this->createQueryBuilder('c');
        return $q
            ->where('c.employee = :employee')
            ->setParameter('employee',$employee);
    }

    public function getBetweenDates(Employee $employee, \DateTime $from = null, \DateTime $to = null): array{
        $q = $this->getForEmployeeQuery($employee);
        $q->join('c.courseAppointment','ca');

        if($from){
            $q->where('ca.date >= :from')->setParameter('from',$from);
        }

        if($to){
            $q->where('ca.date <= :to')->setParameter('to',$to);
        }

        return $q->getQuery()->getResult();
    }

    // /**
    //  * @return CourseRegistration[] Returns an array of CourseRegistration objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CourseRegistration
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
