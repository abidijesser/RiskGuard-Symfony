<?php

namespace App\Repository;

use App\Entity\Assurancevie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Assurancevie>
 *
 * @method Assurancevie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Assurancevie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Assurancevie[]    findAll()
 * @method Assurancevie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssurancevieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Assurancevie::class);
    }

//    /**
//     * @return Assurancevie[] Returns an array of Assurancevie objects
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
    /**
     * @return Assurancevie[] Returns an array of Assurancevie objects sorted by salaireclient
     */
    public function findAllSortedBySalaire(): array
    {
        return $this->createQueryBuilder('av')
            ->orderBy('av.salaireclient', 'ASC')
            ->getQuery()
            ->getResult();
    }
//    public function findOneBySomeField($value): ?Assurancevie
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
