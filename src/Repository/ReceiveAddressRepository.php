<?php

namespace App\Repository;

use App\Entity\ReceiveAddress;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ReceiveAddress|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReceiveAddress|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReceiveAddress[]    findAll()
 * @method ReceiveAddress[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReceiveAddressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReceiveAddress::class);
    }

    // /**
    //  * @return ReceiveAddress[] Returns an array of ReceiveAddress objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ReceiveAddress
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findBySchoolQueryBuilder($school)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.school = :school')
            ->setParameter('school', $school)
            ->orderBy('r.id', 'ASC');     
    }
}
