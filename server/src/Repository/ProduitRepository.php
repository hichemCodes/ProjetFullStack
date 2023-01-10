<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Produit>
 *
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    public function add(Produit $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Produit $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /*public function findAllProduitsBoutiqueCategorie($boutiqueId,$categorieId): ?Produit
    {
        $qb = $this->createQueryBuilder('p')
        ->innerJoin('p.phones', 'p', 'WITH', 'p.phone = :phone')
        ->where('c.username = :username')
        ->setParameter('phone', $phone)
        ->setParameter('username', $username);

        $qb->select('c')
    ->innerJoin('c.phones', 'p', 'WITH', 'p.phone = :phone')
    ->where('c.username = :username')
    ->setParameter('phone', $phone)
    ->setParameter('username', $username);
or
    }*/

//    /**
//     * @return Produit[] Returns an array of Produit objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Produit
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    /**
     * Find all the product with name  passed in parameter.
     *
    */
    public function getProduits(
        $query,
        $boutique = null,
        $categories= "",
        $offset = 0,
        $limit = 10
    ) {
        $queryBuilder = $this->createQueryBuilder("p")
        ->leftJoin('p.categories','c');

        if($boutique != null) {
            $queryBuilder->andWhere('p.boutique_id = :id')
                ->setParameter('id',$boutique);
        }

        if($query != "") {
            $queryBuilder->andWhere('p.nom LIKE :query')
                ->setParameter('query','%'.$query.'%');
        }

        if($categories != "") {
            $queryBuilder->andWhere('c.id = :categories')
                ->setParameter('categories', $categories);
        }

        $queryBuilder->setFirstResult($offset)->setMaxResults($limit);
        $queryBuilder->orderBy('p.date_de_creation', 'DESC');

        return $queryBuilder->getQuery()->getResult();
    }

    public function getProduit($id) {
        $queryBuilder = $this->createQueryBuilder("p")
        ->andWhere('p.id =  :id')
        ->setParameter('id',$id);
        
        return $queryBuilder->getQuery()->getResult();
    }

    public function searchbyName(string $query) {
        $queryBuilder = $this->createQueryBuilder("p")
            ->andWhere('p.nom LIKE :query')
            ->setParameter('query','%'.$query);
        return $queryBuilder->getQuery()->getResult();

    }

    public function getAllProduitsNonAssigner() {
        $queryBuilder = $this->createQueryBuilder("p")
            ->select('p.id,p.nom,p.prix,p.description')
            ->andWhere('p.boutique_id is NULL');
        return $queryBuilder->getQuery()->getResult();

    }

     //associateProduitToBoutique
     public function associateProduitToBoutique($idBoutique,$idProduit) {
        $queryBuilder = $this->createQueryBuilder("p")
        ->update()
        ->set('p.boutique_id', ':idBoutique')
        ->where('p.id = :idProduit')
        ->setParameter('idBoutique', $idBoutique)
        ->setParameter('idProduit', $idProduit);

        return $queryBuilder->getQuery()->getResult();
    }
}
