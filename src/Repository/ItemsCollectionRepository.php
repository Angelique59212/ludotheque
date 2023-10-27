<?php

namespace App\Repository;

use App\Entity\ItemsCollection;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ItemsCollection>
 *
 * @method ItemsCollection|null find($id, $lockMode = null, $lockVersion = null)
 * @method ItemsCollection|null findOneBy(array $criteria, array $orderBy = null)
 * @method ItemsCollection[]    findAll()
 * @method ItemsCollection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemsCollectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ItemsCollection::class);
    }

    /*
     * search articles based on keywords
     * verify keyword present before send request
     */
    public function searchByWord($wordKey, int $id)
    {
        $query = $this->createQueryBuilder('itemC');
        if (!empty($wordKey)) {
            $query->andWhere('itemC.title LIKE :wordKey')
                ->setParameter('wordKey', "%" . $wordKey . "%");
        }
            return $query->getQuery()->getResult();
    }

    /*
     * search articles based on editor
     * verify keyword present before send request
     */
    public function searchByEditor($wordKey, int $id)
    {
        $query = $this->createQueryBuilder('itemC');
        if (!empty($wordKey)) {
            $query->andWhere('itemC.editor LIKE :wordKey')
                ->setParameter('wordKey', "%" . $wordKey . "%");
        }
        return $query->getQuery()->getResult();
    }

//    /**
//     * @return ItemsCollection[] Returns an array of ItemsCollection objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ItemsCollection
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
