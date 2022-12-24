<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Boutique;
use App\Entity\Produit;
use App\Entity\Ville;
use App\Repository\BoutiqueRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Annotation\Route;


class BoutiqueController extends ApiController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Get a list of all boutiques.
     * @Route("/api/boutiques", name="boutiques", methods={"GET"})
     * @param BoutiqueRepository $boutiqueRepository
     * @return JsonResponse
     */
    public function getAllBoutique(
        BoutiqueRepository $boutiqueRepository,
        Request $request
    ): JsonResponse {

        // Step 1 : Fetch the data from database
        $request = $this->transformJsonBody($request);

        if ($request->request->has('createdBefore')) {

            //$date_de_creation = new \DateTime( $request->get('createdBefore'));
            //$fromDate->setTime(0, 0, 0);
            $date_de_creation=DateTime::createFromFormat('d/m/Y', $request->get('createdBefore'))->setTime(0, 0, 0);
            //var_dump($date_de_creation);
            $orderBY=($request->request->has('date_de_creation')) ? $request->request->has('date_de_creation') : 'date_de_creation';
            $boutiques= $boutiqueRepository->searchDateBefore($date_de_creation, $orderBY);

        }elseif ($request->request->has('createdAfter')) {
            $date_de_creation=DateTime::createFromFormat('d/m/Y', $request->get('createdAfter'))->setTime(0, 0, 0);
            //var_dump($date_de_creation);
            $orderBY=($request->request->has('date_de_creation')) ? $request->request->has('date_de_creation') : 'date_de_creation';
            $boutiques= $boutiqueRepository->searchDateAfter($date_de_creation, $orderBY);

        } elseif ( $request->request->has('createdBetween1') && $request->request->has('createdBetween2')){
            $date_de_creationbefore=DateTime::createFromFormat('d/m/Y', $request->get('createdBetween1'))->setTime(0, 0, 0);
            $date_de_creationafter=DateTime::createFromFormat('d/m/Y', $request->get('createdBetween2'))->setTime(0, 0, 0);
            //var_dump($date_de_creation);
            $orderBY=($request->request->has('date_de_creation')) ? $request->request->has('date_de_creation') : 'date_de_creation';
            $boutiques= $boutiqueRepository->searchDateBetween($date_de_creationbefore,$date_de_creationafter, $orderBY);

        } elseif($request->request->has('query')) {
            $query=$request->get('query');
            //var_dump($query);
            $orderBY=($request->request->has('query')) ? $request->request->has('query') : 'query';
            $boutiques= $boutiqueRepository->searchbyName($query, $orderBY);


        } else {
            $boutiques = $boutiqueRepository->findAll();

        }

        // Last Step : return the data.
        return $this->json($boutiques,Response::HTTP_OK);
    }

    /**
     * Create boutique.
     * @Route("/api/boutiques", name="create_boutique", methods={"POST"})
     * @param BoutiqueRepository $boutiqueRepository
     * @param Request $request
     * @return JsonResponse
     */
    public function createBoutique(
        BoutiqueRepository $boutiqueRepository,
        Request $request
    ): JsonResponse {

        $request = $this->transformJsonBody($request);
        $nom = $request->get('nom');
        $horaires_de_ouverture = $request->get('horaires_de_ouverture');
        $en_conge = $request->get('en_conge');

        if (empty($nom) || empty($horaires_de_ouverture) || empty($en_conge)) {
            return $this->respondValidationError("Invalid request");
        }

        $boutique = new Boutique();
        $boutique->setNom($nom);
        $boutique->setHorairesDeOuverture($horaires_de_ouverture);
        $boutique->setEnConge($en_conge);
        $boutique->setDateDeCreation(new \DateTime());

        $this->em->persist($boutique);
        $this->em-> flush();

        // Last Step : return the data.
        return $this->json($boutique,Response::HTTP_CREATED, array());


    }

    /**
     * Delete boutique.
     *
     *
     * @Route("/api/boutiques/{id}", name="delete_boutique", methods={"DELETE"})
     * @noinspection PhpOptionalBeforeRequiredParametersInspection
     * @param Boutique|null $existingBoutique
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     */

    public function deleteBoutique(
        Boutique $existingBoutique = null,
        EntityManagerInterface $entityManager
    ) :JsonResponse {
        if(is_null($existingBoutique)) {
            return $this->respondNotFound();
        }
        $this->em->remove($existingBoutique);
        $this->em->flush();

        // Last step : Return no data as confirmation.
        return $this->json('Boutique supprimée',Response::HTTP_OK);

    }

    /**
     * Update boutique
     * @Route("/api/boutiques/{id}", name="update_boutique", methods={"PATCH"})
     * @noinspection PhpOptionalBeforeRequiredParametersInspection
     * @param Boutique|null $existingBoutique
     * @param BoutiqueRepository $boutiqueRepository
     * @param Request $request
     * @return JsonResponse
     */
    public function updateBoutique(
        Boutique $existingBoutique = null,
        BoutiqueRepository $boutiqueRepository,
        Request $request
    ): JsonResponse {
        if(is_null($existingBoutique)) {
            return $this->respondNotFound();
        }
        $request = $this->transformJsonBody($request);
        $nom = $request->get('nom');
        $horaires_de_ouverture = $request->get('horaires_de_ouverture');
        $en_conge = $request->get('en_conge');

        if (empty($nom) || empty($prix)) {
            return $this->respondValidationError("Invalid request");
        }
        $existingBoutique->setNom($nom);
        $existingBoutique->setHorairesDeOuverture($horaires_de_ouverture);
        $existingBoutique->setEnConge($en_conge);

        $this->em->persist($existingBoutique);
        $this->em->flush();

        // Last step : Return no data as confirmation.
        return $this->json($existingBoutique,Response::HTTP_OK);

    }

    /**
     * Associate  produit to boutique E_BTQ_40
     * @Route("/api/boutiques/{id}/produit/{idProduit}", name="associate_produit_boutique", methods={"PATCH"})
     * @noinspection PhpOptionalBeforeRequiredParametersInspection
     * @param Boutique|null $existingBoutique
     * @param Produit|null $exsitingProduit
     * @return JsonResponse
     */
    public function associateProduitToBoutique(
        Boutique $existingBoutique = null,
        Produit  $exsitingProduit =null
    ): JsonResponse {
        if(is_null($existingBoutique)) {
            return $this->respondNotFound();
        }
        //$request = $this->transformJsonBody($request);
        //$produit = $request->get('produit');

        if (empty($exsitingProduit) || empty($existingBoutique)) {
            return $this->respondValidationError("Invalid request");
        }
        //$produitRepository = $this->em->getRepository(Produit::class);
        //$produitAdded = $produitRepository->find($produit);
        $existingBoutique->addProduit($exsitingProduit);
        //$produit->addProduit($existingBoutique);
        $exsitingProduit->setBoutiqueId($existingBoutique);
        $this->em->persist($existingBoutique);
        //$this->em->persist($produit);

        $this->em->flush();
        return $this->json($existingBoutique,Response::HTTP_OK);


    }

    /**
     * Get specific boutique.
     * @Route("/api/boutiques/{id}", name="boutique", methods={"GET"})
     * @return JsonResponse
     */
    public function getProduit(
        Boutique $existingBoutique
    ): JsonResponse {
        if(is_null($existingBoutique)) {
            return $this->respondNotFound();
        }
        return $this->json($existingBoutique,Response::HTTP_OK);
    }

    /**
     * Get specific boutique by filtering with date creation.
     * @Route("/api/boutiques/date", name="boutiquedate_creation", methods={"GET"})
     * @return JsonResponse
     */
    public function getProduitByDateCreation(
        Boutique $existingBoutique,
        BoutiqueRepository $boutiqueRepository,
        Request $request
    ): JsonResponse {
        if(is_null($existingBoutique)) {
            return $this->respondNotFound();
        }
        $request = $this->transformJsonBody($request);
        $date_de_creation = new \DateTime( $request->get('date_de_creation'));

        $existingBoutique= $boutiqueRepository->searchDateBefore($date_de_creation);


        return $this->json($existingBoutique,Response::HTTP_OK);
    }



}