<?php

namespace App\Repository;

use App\Entity\Assurancevehicule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Assurancevehicule>
 *
 * @method Assurancevehicule|null find($id, $lockMode = null, $lockVersion = null)
 * @method Assurancevehicule|null findOneBy(array $criteria, array $orderBy = null)
 * @method Assurancevehicule[]    findAll()
 * @method Assurancevehicule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssurancevehiculeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Assurancevehicule::class);
    }

//    /**
//     * @return Assurancevehicule[] Returns an array of Assurancevehicule objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Assurancevehicule
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
