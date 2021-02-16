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

    public function getGroupedScoreForHotel(
        Hotel $hotel,
        ?DateTimeImmutable $from = null,
        ?DateTimeImmutable $to = null
    ): array
    {
        $builder = $this->createQueryBuilder('r');

        $builder->select('r.created_date as date, avg(r.score) as score, count(r.score) as count');
        $builder->andWhere('r.hotel = :hotel');
        $builder->setParameter('hotel', $hotel->getId());

        if ($from) {
            $builder->andWhere('r.created_date >= :from');
            $builder->setParameter('from', $from->format('Y-m-d'));
        }

        if ($to) {
            $builder->andWhere('r.created_date <= :to');
            $builder->setParameter('to', $to->format('Y-m-d'));
        }

        $builder->groupBy('date');

        return $builder->getQuery()->getArrayResult();
    }

    /**
     * @param Hotel $hotel
     * @param DateTimeImmutable|null $from
     * @param DateTimeImmutable|null $to
     * @return array
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws \Doctrine\DBAL\Exception
     * @deprecated
     */
    public function getGroupedScoreForHotelWithDateCasting(
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
