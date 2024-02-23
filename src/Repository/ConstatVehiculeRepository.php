<?php

namespace App\Repository;

use App\Entity\ConstatVehicule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ConstatVehicule>
 *
 * @method ConstatVehicule|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConstatVehicule|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConstatVehicule[]    findAll()
 * @method ConstatVehicule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConstatVehiculeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConstatVehicule::class);
    }

//    /**
//     * @return ConstatVehicule[] Returns an array of ConstatVehicule objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ConstatVehicule
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
