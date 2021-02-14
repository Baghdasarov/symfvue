<?php

namespace App\Repository;

use App\Entity\Hotel;
use App\Entity\Review;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Review|null find($id, $lockMode = null, $lockVersion = null)
 * @method Review|null findOneBy(array $criteria, array $orderBy = null)
 * @method Review[]    findAll()
 * @method Review[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Review::class);
    }

    // /**
    //  * @return Review[] Returns an array of Review objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Review
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getGroupedScoreForHotel(
        Hotel $hotel,
        ?DateTimeImmutable $from = null,
        ?DateTimeImmutable $to = null
    ): array
    {
        $sql = "select DATE(created_date) as date, avg(score) as score, count(score) as count
                from review
                where hotel_id = ?";
        $params = [$hotel->getId()];

        if ($from !== null) {
            $sql .= ' and created_date >= ?';
            $params[] = $from->format('Y-m-d');
        }

        if ($to !== null) {
            $sql .= ' and created_date <= ?';
            $params[] = $to->format('Y-m-d');
        }

        $sql .= ' group by date;';

        $em = $this->getEntityManager();
        $stmt = $em->getConnection()->executeQuery($sql, $params);

        return $stmt->fetchAllAssociative();
    }
}
