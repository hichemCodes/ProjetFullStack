<?php

namespace App\Repository;

use App\Entity\Boutique;
use Cassandra\Date;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Mapping\OrderBy;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Boutique>
 *
 * @method Boutique|null find($id, $lockMode = null, $lockVersion = null)
 * @method Boutique|null findOneBy(array $criteria, array $orderBy = null)
 * @method Boutique[]    findAll()
 * @method Boutique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BoutiqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Boutique::class);
    }

    public function add(Boutique $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Boutique $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Boutique[] Returns an array of Boutique objects
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

//    public function findOneBySomeField($value): ?Boutique
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    /**
     * Find all the boutique before the date creation passed in parameter.
     *
     */
    public function searchDateBefore(\DateTime $date_de_creation, $orderBY) {
        $queryBuilder = $this->createQueryBuilder("b")
            ->andWhere('b.date_de_creation < :searchDate ')
            ->setParameter('searchDate', $date_de_creation)
            ->orderBy('b.date_de_creation', 'ASC');
        return $queryBuilder->getQuery()->getResult();

    }

    /**
     * Find all the boutique after the date creation passed in parameter.
     *
     */
    public function searchDateAfter(\DateTime $date_de_creation, $orderBY) {
        $queryBuilder = $this->createQueryBuilder("b")
            ->andWhere('b.date_de_creation > :searchDate ')
            ->setParameter('searchDate', $date_de_creation)
            ->orderBy('b.date_de_creation', 'ASC');
        return $queryBuilder->getQuery()->getResult();

    }

    /**
     * Find all the boutique between the date creation passed in parameter.
     *
     */
    public function searchDateBetween(\DateTime $date_de_creationbefore, \DateTime $date_de_creationafter, $orderBy) {
        $queryBuilder = $this->createQueryBuilder("b")
            ->andWhere('b.date_de_creation > :createdBetween1 ')
            ->andWhere('b.date_de_creation < :createdBetween2 ')
            ->setParameter('createdBetween1', $date_de_creationbefore)
            ->setParameter('createdBetween2', $date_de_creationafter)
            ->orderBy('b.date_de_creation', 'ASC');
        return $queryBuilder->getQuery()->getResult();

    }

    /**
     * Find all the boutique with name  passed in parameter.
     *
     */
    public function searchbyName(string $query) {
        $queryBuilder = $this->createQueryBuilder("b")
            ->andWhere('b.nom LIKE :query')
            ->setParameter('query','%'.$query);
            //->orderBy('b.date_de_creation', 'ASC');
        return $queryBuilder->getQuery()->getResult();

    }


}
