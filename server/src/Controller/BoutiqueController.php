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
     * @Route("/api/boutiques", name="boutiques", methods={"POST"})
     * @param BoutiqueRepository $boutiqueRepository
     * @return JsonResponse
     */
    public function getAllBoutiques(
        BoutiqueRepository $boutiqueRepository,
        Request $request
    ): JsonResponse {

        $request = $this->transformJsonBody($request);
        $enConge = null;
        $date_de_creationbefore = "";
        $date_de_creationafter = "";
        $query = "";
        $orderBy = "date_de_creation";
        $offset = 0;
        $limit = 10;

        if ($request->request->has('enConge')) {
            $enConge = $request->get('enConge');
        }

        if ($request->request->has('createdBefore')) {
            $date_de_creationbefore=DateTime::createFromFormat('d/m/Y', $request->get('createdBefore'))->setTime(0, 0, 0);
        }

        if($request->request->has('createdAfter')) {
            $date_de_creationafter = DateTime::createFromFormat('d/m/Y', $request->get('createdAfter'))->setTime(0, 0, 0);
        }

        if($request->request->has('query')) {
            $query=$request->get('query');
        }

        if($request->request->has('orderBy')) {
            $orderBy=$request->get('orderBy');
        }
        if($request->request->has('offset')) {
            $offset=$request->get('offset');
        }
        if($request->request->has('limit')) {
            $limit=$request->get('limit');
        }

        $boutiques= $boutiqueRepository->findAllBoutiquesWithFilter(
            $enConge,
            $date_de_creationbefore,
            $date_de_creationafter,
            $query,
            $orderBy,
            $offset,
            $limit
        );

        return $this->json($boutiques,Response::HTTP_OK);
    }

    /**
     * Create boutique.
     * @Route("/api/boutiques/create", name="create_boutique", methods={"POST"})
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
    public function getBoutiqueDetails(
        Boutique $existingBoutique
    ): JsonResponse {
        if(is_null($existingBoutique)) {
            return $this->respondNotFound();
        }
        return $this->json($existingBoutique,Response::HTTP_OK);
    }

    /**
     * Get specific boutique.
     * @Route("/api/boutiques/{id}/produits", name="boutique_produits", methods={"GET"})
     * @return JsonResponse
     */
    public function getBoutiqueProduits(
        Boutique $existingBoutique,
        BoutiqueRepository $boutiqueRepository
    ): JsonResponse {
        if(is_null($existingBoutique)) {
            return $this->respondNotFound();
        }
        $details =  $boutiqueRepository->getBoutiquesProduits($existingBoutique->getId());
        return $this->json($details,Response::HTTP_OK);
    }
}