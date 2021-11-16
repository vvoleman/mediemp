<?php

namespace App\Repository;

use App\Entity\DataAssetVersion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DataAssetVersion|null find($id, $lockMode = null, $lockVersion = null)
 * @method DataAssetVersion|null findOneBy(array $criteria, array $orderBy = null)
 * @method DataAssetVersion[]    findAll()
 * @method DataAssetVersion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DataAssetVersionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, DataAssetVersion::class);
    }

    public function getLastVersion(int $id): ?DataAssetVersion {
        $q = $this->createQueryBuilder('p')
            ->where("p.dataAsset = :id")
            ->setParameter('id',$id)
            ->orderBy('p.createdAt','DESC')
            ->setMaxResults(1)->getQuery();

        $version = $q->execute();
        if(sizeof($version) > 0){
            return $version[0];
        }
        return null;
    }

    // /**
    //  * @return DataAssetVersion[] Returns an array of DataAssetVersion objects
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
    public function findOneBySomeField($value): ?DataAssetVersion
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
