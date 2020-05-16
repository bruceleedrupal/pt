<?php

namespace App\Repository;

use App\Entity\WechatOfficial;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WechatOfficial|null find($id, $lockMode = null, $lockVersion = null)
 * @method WechatOfficial|null findOneBy(array $criteria, array $orderBy = null)
 * @method WechatOfficial[]    findAll()
 * @method WechatOfficial[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WechatOfficialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WechatOfficial::class);
    }

    // /**
    //  * @return WechatOfficial[] Returns an array of WechatOfficial objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WechatOfficial
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
