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
        $auth_token = 'b0fb5882cb238a8e41a2f0dd79d41d56';
        // In production, these should be environment variables. E.g.:
        // $auth_token = $_ENV["TWILIO_AUTH_TOKEN"]
        // A Twilio number you own with SMS capabilities
        $twilio_number = "+19149964427";
    
        $client = new Client($sid, $auth_token);
        
        try {
            $client->messages->create(
                '+21654113122',
                [
                    'from' => $twilio_number,
                    'body' => 'A new event has been added successfully'
                ]
            );
        } catch (\Exception $e) {
            error_log("Error sending SMS: " . $e->getMessage());
        }
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
