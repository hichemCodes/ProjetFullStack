<?php

namespace App\Repository;

use App\Entity\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Categorie>
 *
 * @method Categorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categorie[]    findAll()
 * @method Categorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categorie::class);
    }

    public function add(Categorie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Categorie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Categorie[] Returns an array of Categorie objects
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

//    public function findOneBySomeField($value): ?Categorie
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    /**
     * Find all the categories with name  passed in parameter.
     *
     */
    public function searchbyName(string $query) {
        $queryBuilder = $this->createQueryBuilder("b")
            ->andWhere('b.nom LIKE :query')
            ->setParameter('query','%'.$query);
        //->orderBy('b.date_de_creation', 'ASC');
        return $queryBuilder->getQuery()->getResult();

    }


    /**
     * Find all the categories with name  passed in parameter.
     * @param $query
     * @param $offset
     * @param $limit
     * @return float|int|mixed|string
     */
    public function getCategories(
        $query,
        $offset = 0,
        $limit = 10
    ) {
        $queryBuilder = $this->createQueryBuilder("c")
            ->select('c.id,c.nom,p.prix,p.nom as produit')
            ->leftJoin('c.produits', 'p');

        if($query != "") {
            $queryBuilder->andWhere('c.nom LIKE :query')
                ->setParameter('query','%'.$query);
        }

        $queryBuilder->setFirstResult($offset)->setMaxResults($limit);


        return $queryBuilder->getQuery()->getResult();
    }

    public function getCategory($id) {
        $queryBuilder = $this->createQueryBuilder("c")
            ->select('c.id,c.nom,p.nom as produit')
            ->leftJoin('c.produits', 'p')
            ->andWhere('c.id =  :id')
            ->setParameter('id',$id);
        return $queryBuilder->getQuery()->getResult();
    }
}
