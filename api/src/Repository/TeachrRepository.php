<?php

namespace App\Repository;

use App\Entity\Teachr;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Teachr|null find($id, $lockMode = null, $lockVersion = null)
 * @method Teachr|null findOneBy(array $criteria, array $orderBy = null)
 * @method Teachr[]    findAll()
 * @method Teachr[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeachrRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Teachr::class);
    }

    // /**
    //  * @return Teachr[] Returns an array of Teachr objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */


    /**
     * @throws NonUniqueResultException
     */
    public function findOneById($value): ?Teachr
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

}
