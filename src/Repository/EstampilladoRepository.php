<?php

namespace App\Repository;

use App\Entity\Estampillado;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Estampillados|null find($id, $lockMode = null, $lockVersion = null)
 * @method Estampillados|null findOneBy(array $criteria, array $orderBy = null)
 * @method Estampillados[]    findAll()
 * @method Estampillados[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EstampilladoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Estampillado::class);
    }

    // /**
    //  * @return Estampillados[] Returns an array of Estampillados objects
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
    public function findOneBySomeField($value): ?Estampillados
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
