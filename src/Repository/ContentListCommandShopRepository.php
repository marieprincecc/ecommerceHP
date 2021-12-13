<?php

namespace App\Repository;

use App\Entity\ContentListCommandShop;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ContentListCommandShop|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContentListCommandShop|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContentListCommandShop[]    findAll()
 * @method ContentListCommandShop[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContentListCommandShopRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContentListCommandShop::class);
    }

    // /**
    //  * @return ContentListCommandShop[] Returns an array of ContentListCommandShop objects
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
    public function findOneBySomeField($value): ?ContentListCommandShop
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
