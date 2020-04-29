<?php

namespace App\Repository;

use App\Entity\PackageSize;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PackageSize|null find($id, $lockMode = null, $lockVersion = null)
 * @method PackageSize|null findOneBy(array $criteria, array $orderBy = null)
 * @method PackageSize[]    findAll()
 * @method PackageSize[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PackageSizeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PackageSize::class);
    }

    // /**
    //  * @return PackageSize[] Returns an array of PackageSize objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PackageSize
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findBySchoolQueryBuilder($school)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.school = :school')
            ->setParameter('school', $school)
            ->orderBy('p.id', 'ASC');     
    }
}
