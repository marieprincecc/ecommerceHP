<?php

namespace App\Repository;

use App\Entity\CommandDeliveryAddress;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CommandDeliveryAddress|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommandDeliveryAddress|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommandDeliveryAddress[]    findAll()
 * @method CommandDeliveryAddress[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandDeliveryAddressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommandDeliveryAddress::class);
    }

    // /**
    //  * @return CommandDeliveryAddress[] Returns an array of CommandDeliveryAddress objects
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
    public function findOneBySomeField($value): ?CommandDeliveryAddress
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
