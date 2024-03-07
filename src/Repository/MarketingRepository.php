<?php

namespace App\Repository;

use App\Entity\Marketing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Twilio\Rest\Client;


/**
 * @extends ServiceEntityRepository<Marketing>
 *
 * @method Marketing|null find($id, $lockMode = null, $lockVersion = null)
 * @method Marketing|null findOneBy(array $criteria, array $orderBy = null)
 * @method Marketing[]    findAll()
 * @method Marketing[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MarketingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Marketing::class);
    }

    public function sms()
    {
        // Your Account SID and Auth Token from twilio.com/console
        $sid = 'AC0dbdda35ac261d06862e1417146efa87';
        $auth_token = '70a92caf3c2e1a41735f6f442d9e91b7';
        // In production, these should be environment variables. E.g.:
        // $auth_token = $_ENV["TWILIO_AUTH_TOKEN"]
        // A Twilio number you own with SMS capabilities
        $twilio_number = "+12762849300";

        $client = new Client($sid, $auth_token);
        $client->messages->create(
            '+21654113122',
            [
                // A Twilio phone number you purchased at twilio.com/console
                'from' => '+19149964427',
                // the body of the text message you'd like to send
                'body' => 'A new event has been added successfully'
            ]
        );
    }
    //    /**
    //     * @return Marketing[] Returns an array of Marketing objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Marketing
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
