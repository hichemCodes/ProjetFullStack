<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function add(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //get boutiques details
    public function getBoutiqueOfLivreur($id) {
        $queryBuilder = $this->createQueryBuilder("u")
        ->select('b.id')
        ->innerJoin("u.boutique_id", "b")
        ->where('u.id = :id')
        ->setParameter('id',$id);
        return $queryBuilder->getQuery()->getResult();
    }

    //get boutiques details
    public function getProduitsOfLivreur($id) {
        $queryBuilder = $this->createQueryBuilder("u")
        ->select('p.id,p.nom,p.description')
        ->innerJoin("u.boutique_id", "b")
        ->innerJoin("b.produits", "p")
        ->where('u.id = :id')
        ->setParameter('id',$id);

        return $queryBuilder->getQuery()->getResult();
    }

    public function getCategoriesOfLivreur($id) {
        $queryBuilder = $this->createQueryBuilder("u")
        ->select('c.id,c.nom')
        ->innerJoin("u.boutique_id", "b")
        ->innerJoin("b.produits", "p")
        ->innerJoin("p.categories", "c")
        ->where('u.id = :id')
        ->setParameter('id',$id)
        ->distinct();

        return $queryBuilder->getQuery()->getResult();
    }


//    /**
//     * @return Ville[] Returns an array of Ville objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Ville
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
