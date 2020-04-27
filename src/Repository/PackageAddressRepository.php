<?php

namespace App\Repository;

use App\Entity\PackageAddress;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PackageAddress|null find($id, $lockMode = null, $lockVersion = null)
 * @method PackageAddress|null findOneBy(array $criteria, array $orderBy = null)
 * @method PackageAddress[]    findAll()
 * @method PackageAddress[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PackageAddressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PackageAddress::class);
    }

    // /**
    //  * @return PackageAddress[] Returns an array of PackageAddress objects
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
    public function findOneBySomeField($value): ?PackageAddress
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
