<?php

namespace App\Repository;

use App\Entity\UserProjectRelation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UserProjectRelation|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserProjectRelation|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserProjectRelation[]    findAll()
 * @method UserProjectRelation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserProjectRelationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserProjectRelation::class);
    }

    // /**
    //  * @return UserProjectRelation[] Returns an array of UserProjectRelation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserProjectRelation
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
