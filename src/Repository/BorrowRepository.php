<?php

namespace App\Repository;

use App\Entity\Borrow;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Borrow>
 *
 * @method Borrow|null find($id, $lockMode = null, $lockVersion = null)
 * @method Borrow|null findOneBy(array $criteria, array $orderBy = null)
 * @method Borrow[]    findAll()
 * @method Borrow[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BorrowRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Borrow::class);
    }

    /*
     * query to retrieve loans taking into account start end date and user
     * using the queryBuilder to communicate with the database
     * returns an array of borrowing objects
     */
    public function findBorrowNoFinished($dateStart, $dateEnd, $userId)
    {
        $query = $this->createQueryBuilder('b')
            ->where('b.user = :user_id')
            ->setParameter('user_id', $userId);

        if ($dateStart) {
            $query->andWhere('b.date_start >= :date_start')
                ->setParameter('date_start', $dateStart);
        }

        if ($dateEnd) {
            $query->andWhere('b.date_end <= :date_end')
                ->setParameter('date_end', $dateEnd);
        }

        return $query->getQuery()->getResult();
    }

//    /**
//     * @return Borrow[] Returns an array of Borrow objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Borrow
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
