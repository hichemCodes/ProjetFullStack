<?php

namespace App\Repository;

use App\Entity\Boutique;
use Cassandra\Date;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Mapping\OrderBy;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

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
    /**
     * Find all the boutique before the date creation passed in parameter.
     *
     */
    public function searchDateBefore(\DateTime $date_de_creation) {
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
    public function searchbyName(string $query, $orderBY) {
        $queryBuilder = $this->createQueryBuilder("b")
            ->andWhere('b.nom LIKE :query')
            ->setParameter('query','%'.$query)
            ->orderBy('b.nom', 'ASC');
        return $queryBuilder->getQuery()->getResult();

    }

    
    /**
     * Find all the boutique with name  passed in parameter.
     *
     */
    public function findAllBoutiquesWithFilter(
        $enConge = null,
        $date_de_creationbefore = "",
        $date_de_creationafter = "",
        $query,
        $orderBy = "date_de_creation",
        $offset = 0,
        $limit = 10

    ) {
        $queryBuilder = $this->createQueryBuilder("b")
        ->leftJoin("b.produits", "p");

        if($enConge != null) {
            $queryBuilder->andWhere('b.en_conge = :param')
            ->setParameter('param',$enConge);
        }
        if($date_de_creationbefore != "") {
            $queryBuilder->andWhere('b.date_de_creation < :searchDatebefore ')
            ->setParameter('searchDatebefore', $date_de_creationbefore);
        }
        if($date_de_creationafter != "") {
            $queryBuilder->andWhere('b.date_de_creation > :searchDatebeforeAfter ')
            ->setParameter('searchDatebeforeAfter', $date_de_creationafter);
        }
        if($query != "") {
            $queryBuilder->andWhere('b.nom LIKE :query')
            ->setParameter('query','%'.$query.'%');
        }

        if($orderBy == "date_de_creation") {
            $queryBuilder->orderBy('b.date_de_creation', 'DESC');
        }
        if($orderBy == "nom") {
            $queryBuilder->orderBy('b.nom', 'ASC');
        }
        if($orderBy == "nombre_de_produits") {
            $queryBuilder->addOrderby('COUNT(p.id)', 'DESC')
            ->groupBy('b.id');
        }
        $queryBuilder->setFirstResult($offset)->setMaxResults($limit);
        $paginator = new Paginator($queryBuilder, $fetchJoinCollection = true);
        $count = count($paginator);
       
        return [$queryBuilder->getQuery()->getResult(),array("allPages" => $count)];
    }

    //get boutiques details
    public function getBoutiquesProduits($id) {
        $queryBuilder = $this->createQueryBuilder("b")
        ->andWhere('b.id = :id')
        ->setParameter('id',$id);

        return $queryBuilder->getQuery()->getResult();
    }


    /**
     * le nombre de boutique dans la bdd
     */
    
    //get boutiques details
    public function getBoutiquesCount() {
        $queryBuilder = $this->createQueryBuilder("b")
        ->select('count(b.id) as nombreDeBoutiques');
      

        return $queryBuilder->getQuery()->getResult();
    }

}
