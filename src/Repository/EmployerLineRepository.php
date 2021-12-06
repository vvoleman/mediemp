<?php

namespace App\Repository;

use App\Entity\EmployerLine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EmployerLine|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmployerLine|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmployerLine[]    findAll()
 * @method EmployerLine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployerLineRepository extends ServiceEntityRepository {
    public const PAGE_SIZE = 10;

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, EmployerLine::class);
    }

    public function search(string $query, int $page = 0, QueryBuilder $qb = null) {
        if(!$qb){
            $qb = $this->getSearchQuery($query,$page);
        }
        return $qb
            ->setFirstResult($page*self::PAGE_SIZE)
            ->setMaxResults(self::PAGE_SIZE)
            ->getQuery()->getResult();
    }

    public function getSearchQuery(string $query, int $page = 0): QueryBuilder {
        $q = $this->getAvailable();
        return $q
            ->where($q->expr()->like(
                $q->expr()->concat('p.facilityName', $q->expr()->literal(' '), 'p.facilityType'),
                ":query"
            ))
            ->setParameter("query",'%'.$query.'%');
    }

    public function hasNext(int $page, QueryBuilder $queryBuilder): bool {
        return ($page+1) * self::PAGE_SIZE < $this->getSizeOfQuery($queryBuilder);
    }

    public function getAvailable(){
        $q = $this->createQueryBuilder('p');
        $q
            ->leftJoin('p.employer','e')
            ->where('e.id is null');

        return $q;
    }

    public function isEmpty(): bool {
        return $this->getSize() == 0;
    }

    public function getSize(): int {
        return $this->getSizeOfQuery($this->createQueryBuilder('p'));
    }

    public function getSizeOfQuery(QueryBuilder $q){
        $data = $q->select("count(p.id) as amount")->getQuery()->getResult();
        if (sizeof($data) == 0) {
            return 0;
        }
        return $data[0]["amount"];
    }

    public function getFirst(int $start = 0,int $stop = 1){
        $q = $this->createQueryBuilder('p');
        return $q
            ->setFirstResult($start*self::PAGE_SIZE)
            ->setMaxResults($stop*self::PAGE_SIZE)
            ->getQuery()->getResult();
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
