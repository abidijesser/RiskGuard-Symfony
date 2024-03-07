<?php

namespace App\Repository;

use App\Entity\Constatvie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Constatvie>
 *
 * @method Constatvie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Constatvie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Constatvie[]    findAll()
 * @method Constatvie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConstatvieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Constatvie::class);
    }
    /**
     * Find all Constatvie entities sorted by DateDeDeces.
     *
     * @return Constatvie[] Returns an array of Constatvie objects
     */
        public function findAllSortedByDateDeDeces(): array
        {
            return $this->createQueryBuilder('c')
                ->orderBy('c.DateDeDeces', 'ASC')
                ->getQuery()
                ->getResult();
        }


//    /**
//     * @return Constatvie[] Returns an array of Constatvie objects
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

//    public function findOneBySomeField($value): ?Constatvie
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
