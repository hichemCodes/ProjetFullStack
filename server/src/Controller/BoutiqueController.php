<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Boutique;
use App\Entity\Produit;
use App\Entity\Ville;
use App\Repository\BoutiqueRepository;
use App\Repository\ProduitRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


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
     * @SWG\Tag(name="Boutique")
     *
     * @SWG\Parameter(
     *      name="boutique",
     *      in="body",
     *      required=false,
     *      @SWG\Schema(
     *          type="object",
     *          required={"nom", "horaires_de_ouverture", "en_conge"},
     *          @SWG\Property(property="enConge", type="bool", example="true"),
     *          @SWG\Property(property="createdBefore", type="string", example="12/12/2022"),
     *          @SWG\Property(property="createdAfter", type="string", example="18/12/2022"),
     *          @SWG\Property(property="query", type="string", example="nom du boutique"),
     *          @SWG\Property(property="orderBy", type="string", example="date_de_creation"),
     *          @SWG\Property(property="offset", type="int", example="0"),
     *          @SWG\Property(property="limit", type="int", example="10"),

     *          @SWG\Property(property="en_conge", type="boolean", example="1")
     *
     *              )
     * )
     * 
     *  @SWG\Response(
     *     response=200,
     *     description="Returned with the list of boutiques",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(
     *              type="object",
     *              @SWG\Property(property="id", type="integer", example="1"),
     *              @SWG\Property(property="nom", type="string", example="Lidl"),
     *              @SWG\Property(property="horaires_de_ouverture", type="json", example="[{'lundi':{'matin':'8h-12h'}}]"),
     *              @SWG\Property(property="en_conge", type="boolean", example="1"),
     *              @SWG\Property(property="date_de_creation", type="datetime", example="1"),
     *              @SWG\Property(property="users", type="integer", example="1"),
     *              @SWG\Property(property="adresse_id", type="integer", example="1"),
     *              @SWG\Property(property="produits", type="string", example="Pomme"),
     *     )
     * )
     * )
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
        
        if ($request->query->has('enConge')) {
            $enConge = $request->query->get('enConge');
        }
        
        if ($request->query->has('createdBefore')) {
            $date_de_creationbefore=DateTime::createFromFormat('d/m/Y', $request->query->get('createdBefore'))->setTime(0, 0, 0);
        }

        if($request->query->has('createdAfter')) {
            $date_de_creationafter = DateTime::createFromFormat('d/m/Y', $request->query->get('createdAfter'))->setTime(0, 0, 0);
        }

        if($request->query->has('query')) {
            $query=$request->query->get('query');
        }

        if($request->query->has('orderBy')) {
            $orderBy=$request->query->get('orderBy');
        }
        if($request->query->has('offset')) {
            $offset=$request->query->get('offset');
        }
        if($request->query->has('limit')) {
            $limit=$request->query->get('limit');
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
     * @Route("/api/boutiques", name="create_boutique", methods={"POST"})
     * @SWG\Tag(name="Boutique")
     *
     * @SWG\Parameter(
     *      name="boutique",
     *      in="body",
     *      required=true,
     *      @SWG\Schema(
     *          type="object",
     *          required={"nom", "horaires_de_ouverture", "en_conge"},
     *          @SWG\Property(property="nom", type="string", example="Lidl"),
     *          @SWG\Property(property="horaires_de_ouverture", type="json", example="[{'lundi':{'matin':'8h-12h'}}]"),
     *          @SWG\Property(property="en_conge", type="boolean", example="1")
     *
     *              )
     * )
     *
     *   @SWG\Response(
     *     response=201,
     *     description=" Return when the boutique has been created",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(
     *              type="object",
     *              @SWG\Property(property="id", type="integer", example="1"),
     *              @SWG\Property(property="nom", type="string", example="Lidl"),
     *              @SWG\Property(property="horaires_de_ouverture", type="json", example="[{'lundi':{'matin':'8h-12h'}}]"),
     *              @SWG\Property(property="en_conge", type="boolean", example="1"),
     *              @SWG\Property(property="date_de_creation", type="datetime", example="1"),
     *              @SWG\Property(property="users", type="integer", example="1"),
     *              @SWG\Property(property="adresse_id", type="integer", example="1"),
     *              @SWG\Property(property="produits", type="string", example="Pomme"),
     *     )
     * )
     * )
     *
     * @SWG\Response(
     *      response=422,
     *      description="Returned when the sent request isn't valid",
     *
     *      @SWG\Schema(
     *          type="object",
     *          @SWG\Property(property="code", type="integer", example=400),
     *          @SWG\Property(property="message", type="string", example="Invalid Request."),
     *      )
     * )
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

         if (empty($nom) || empty($horaires_de_ouverture)) {
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
     * @SWG\Tag(name="Boutique")
     *
     *  @SWG\Response(
     *     response=204,
     *     description="Returned when the boutique has been deleted",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(
     *              type="object",
     *              @SWG\Property(property="id", type="integer", example="1"),
     *              @SWG\Property(property="nom", type="string", example="Lidl"),
     *              @SWG\Property(property="horaires_de_ouverture", type="json", example="[{'lundi':{'matin':'8h-12h'}}]"),
     *              @SWG\Property(property="en_conge", type="boolean", example="1"),
     *              @SWG\Property(property="date_de_creation", type="datetime", example="1"),
     *              @SWG\Property(property="users", type="integer", example="1"),
     *              @SWG\Property(property="adresse_id", type="integer", example="1"),
     *              @SWG\Property(property="produits", type="string", example="Pomme"),
     *     )
     * )
     * )
     *
     *  @SWG\Response(
     *      response=404,
     *      description="Returned when the boutique isn't found",
     *
     *      @SWG\Schema(
     *          type="object",
     *          @SWG\Property(property="status", type="integer", example=404),
     *          @SWG\Property(property="errors", type="string", example="Not found!")
     *      )
     * )
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
     * @Route("/api/boutiques/{id}", name="update_boutique", methods={"PUT"})
     * @SWG\Tag(name="Boutique")
     *
     * @SWG\Parameter(
     *      name="nom",
     *      in="body",
     *      required=true,
     *      @SWG\Schema(
     *          type="object",
     *          required={"nom", "horaires_de_ouverture", "en_conge"},
     *          @SWG\Property(property="nom", type="string", example="Lidl"),
     *          @SWG\Property(property="horaires_de_ouverture", type="json", example="[{'lundi':{'matin':'8h-12h'}}]"),
     *          @SWG\Property(property="en_conge", type="boolean", example="1")
     *              )
     * )
     *
     *   @SWG\Response(
     *     response=204,
     *     description=" Return when the boutique has been changed",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(
     *              type="object",
     *              @SWG\Property(property="id", type="integer", example="1"),
     *              @SWG\Property(property="nom", type="string", example="Lidl"),
     *              @SWG\Property(property="horaires_de_ouverture", type="json", example="[{'lundi':{'matin':'8h-12h'}}]"),
     *              @SWG\Property(property="en_conge", type="boolean", example="1"),
     *              @SWG\Property(property="date_de_creation", type="datetime", example="1"),
     *              @SWG\Property(property="users", type="integer", example="1"),
     *              @SWG\Property(property="adresse_id", type="integer", example="1"),
     *              @SWG\Property(property="produits", type="string", example="Pomme"),
     *     )
     * )
     * )
     *
     * @SWG\Response(
     *      response=422,
     *      description="Returned when the sent request isn't valid",
     *
     *      @SWG\Schema(
     *          type="object",
     *          @SWG\Property(property="code", type="integer", example=400),
     *          @SWG\Property(property="message", type="string", example="Invalid Request."),
     *      )
     * )
     * @SWG\Response(
     *      response=404,
     *      description="Returned when the boutique isn't found",
     *
     *      @SWG\Schema(
     *          type="object",
     *          @SWG\Property(property="status", type="integer", example=404),
     *          @SWG\Property(property="errors", type="string", example="Not found!")
     *      )
     * )
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

        if (empty($nom) || empty($horaires_de_ouverture)) {
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
     * @Route("/api/boutiques/{boutique}/produit/{produit}", name="associate_produit_boutique", methods={"PATCH"})
     * @SWG\Tag(name="Boutique")
     * @SWG\Response(
     *     response=200,
     *     description="Returned when the product has been associated to the boutique ",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(
     *              type="object",
     *              @SWG\Property(property="id", type="integer", example="1"),
     *              @SWG\Property(property="nom", type="string", example="Lidl"),
     *              @SWG\Property(property="horaires_de_ouverture", type="json", example="[{'lundi':{'matin':'8h-12h'}}]"),
     *              @SWG\Property(property="en_conge", type="boolean", example="1"),
     *              @SWG\Property(property="date_de_creation", type="datetime", example="1"),
     *              @SWG\Property(property="users", type="integer", example="1"),
     *              @SWG\Property(property="adresse_id", type="integer", example="1"),
     *              @SWG\Property(property="produits", type="string", example="Pomme"),
     *     )
     * )
     * )
     *
     *  @SWG\Response(
     *      response=404,
     *      description="Returned when the boutique or the product isn't found",
     *
     *      @SWG\Schema(
     *          type="object",
     *          @SWG\Property(property="status", type="integer", example=404),
     *          @SWG\Property(property="errors", type="string", example="Not found!")
     *      )
     * )
     * @noinspection PhpOptionalBeforeRequiredParametersInspection
     * @param Boutique $existingBoutique
     * @param Produit $exsitingProduit
     * @return JsonResponse
     */
    public function associateProduitToBoutique(
        Boutique $boutique,
        Produit  $produit
        
    ): JsonResponse {
        if(is_null($boutique)) {
            return $this->respondNotFound();
        }
        if (empty($boutique) || empty($produit)) {
            return $this->respondValidationError("Invalid request");
        }
       
        $this->em->getRepository(Produit::class)->associateProduitToBoutique($boutique->getId(),$produit->getId());

        $produitAfterUpdate = $this->em->getRepository(Produit::class)->getProduit($produit->getId());
        return $this->json($produitAfterUpdate,Response::HTTP_OK);


    }

    /**
     * Get specific boutique.
     * @Route("/api/boutiques/{id}", name="boutique", methods={"GET"})
     * @SWG\Tag(name="Boutique")
     *
     *   @SWG\Response(
     *     response=200,
     *     description=" Return with the details of boutique",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(
     *              type="object",
     *              @SWG\Property(property="id", type="integer", example="1"),
     *              @SWG\Property(property="nom", type="string", example="Lidl"),
     *              @SWG\Property(property="horaires_de_ouverture", type="json", example="[{'lundi':{'matin':'8h-12h'}}]"),
     *              @SWG\Property(property="en_conge", type="boolean", example="1"),
     *              @SWG\Property(property="date_de_creation", type="datetime", example="1"),
     *              @SWG\Property(property="users", type="integer", example="1"),
     *              @SWG\Property(property="adresse_id", type="integer", example="1"),
     *              @SWG\Property(property="produits", type="string", example="Pomme"),
     *     )
     * )
     * )
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
     * Get specific boutique with all details product and stuff E_BTQ_80.
     * @Route("/api/boutiques/{id}/produits", name="boutique_produits", methods={"GET"})
     * @SWG\Tag(name="Boutique")
     *
     *   @SWG\Response(
     *     response=200,
     *     description=" Return with the details of boutique",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(
     *              type="object",
     *              @SWG\Property(property="id", type="integer", example="1"),
     *              @SWG\Property(property="nom", type="string", example="Lidl"),
     *              @SWG\Property(property="horaires_de_ouverture", type="json", example="[{'lundi':{'matin':'8h-12h'}}]"),
     *              @SWG\Property(property="en_conge", type="boolean", example="1"),
     *              @SWG\Property(property="date_de_creation", type="datetime", example="1"),
     *              @SWG\Property(property="users", type="integer", example="1"),
     *              @SWG\Property(property="adresse_id", type="integer", example="1"),
     *              @SWG\Property(property="produits", type="string", example="Pomme"),
     *     )
     * )
     * )
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


    /**
     * @Route("/api/boutiquesCount", name="boutique_count", methods={"GET"})
      * @return JsonResponse
     */
    public function getBoutiqueCount(
        BoutiqueRepository $boutiqueRepository
    ): JsonResponse {
        
        $count =  $boutiqueRepository->getBoutiquesCount();
        return $this->json($count,Response::HTTP_OK);
    }

    

}