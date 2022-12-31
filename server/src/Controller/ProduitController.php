<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Boutique;
use App\Entity\Categorie;
use App\Repository\ProduitRepository;
use App\Repository\BoutiqueRepository;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;



class ProduitController extends ApiController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Get a list of all produits.
     * @Route("/api/produits", name="produits", methods={"GET"})
     * @SWG\Tag(name="Produit")
     *
     *  @SWG\Response(
     *     response=200,
     *     description="Returned with the list of products",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(
     *              type="object",
     *              @SWG\Property(property="id", type="integer", example="1"),
     *              @SWG\Property(property="nom", type="string", example="Pomme"),
     *              @SWG\Property(property="prix", type="float", example="10"),
     *              @SWG\Property(property="description", type="string", example="alimentaire"),
     *              @SWG\Property(property="boutique_id", type="integer", example="1"),
     *              @SWG\Property(property="categories", type="string", example="FRUITS"),
     *     )
     * )
     * )
     * @param ProduitRepository $produitRepository
     * @return JsonResponse
     */
    public function getAllProduits(
        ProduitRepository $produitRepository,
        Request $request
    ): JsonResponse {
        if($request->request->has('query')) {
            $query = $request->get('query');
            $produits = $produitRepository->searchbyName($query);
        }else {
            $produits = $produitRepository->getProduits();
        }
        return $this->json($produits,Response::HTTP_OK);
    }

    
    /**
     * Get a specific product.
     * @Route("/api/produits/{id}", name="produit", methods={"GET"},requirements={"id"="\d+"})
     * @SWG\Tag(name="Produit")
     *
     *   @SWG\Response(
     *     response=200,
     *     description=" Return with the details of product",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(
     *              type="object",
     *              @SWG\Property(property="id", type="integer", example="1"),
     *              @SWG\Property(property="nom", type="string", example="Pomme"),
     *              @SWG\Property(property="prix", type="float", example="10"),
     *              @SWG\Property(property="description", type="string", example="alimentaire"),
     *              @SWG\Property(property="boutique_id", type="integer", example="1"),
     *              @SWG\Property(property="categories", type="string", example="FRUITS"),
     *     )
     * )
     * )
     * @param ProduitRepository $produitRepository
     * @return JsonResponse
     */
    public function getProduit(
        Produit $existingProduit,
        ProduitRepository $produitRepository
    ): JsonResponse {
        if(is_null($existingProduit)) {
            return $this->respondNotFound();
        }
        return $this->json($produitRepository->getProduit($existingProduit->getId()),Response::HTTP_OK);
    }

    /**
     * Create produit.
     * @Route("/api/produits", name="create_produit", methods={"POST"})
     *@SWG\Tag(name="Produit")
     *
     * @SWG\Parameter(
     *      name="Produit",
     *      in="body",
     *      required=true,
     *      @SWG\Schema(
     *          type="object",
     *          required={"nom", "prix"},
     *          @SWG\Property(property="nom", type="string", example="Pomme"),
     *          @SWG\Property(property="prix", type="float", example="10"),
     *              )
     * )
     *
     *   @SWG\Response(
     *     response=201,
     *     description=" Return when the product has been created",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(
     *              type="object",
     *              @SWG\Property(property="id", type="integer", example="1"),
     *              @SWG\Property(property="nom", type="string", example="Pomme"),
     *              @SWG\Property(property="prix", type="float", example="10"),
     *              @SWG\Property(property="description", type="string", example="alimentaire"),
     *              @SWG\Property(property="boutique_id", type="integer", example="1"),
     *              @SWG\Property(property="categories", type="string", example="FRUITS"),
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
     *          @SWG\Property(property="code", type="integer", example=422),
     *          @SWG\Property(property="message", type="string", example="Invalid Request."),
     *      )
     * )
     * @param ProduitRepository $produitRepository
     * @param Request $request
     * @param EntityManagerInterface $entityManagerInterface
     * @return JsonResponse
     */
    public function createProduit(
        ProduitRepository $produitRepository,
        Request $request
    ): JsonResponse {

        $request = $this->transformJsonBody($request);
        $nom = $request->get('nom');
        $prix = $request->get('prix');

        if (empty($nom) || empty($prix)) {
            return $this->respondValidationError("Invalid request");
        }

        $produit = new Produit();
        $produit->setNom($nom);
        $produit->setPrix($prix);
    
        $this->em->persist($produit);
        $this->em-> flush();

        return $this->json($produit,Response::HTTP_CREATED, array());
    }

    /**
     * Delete produit.
     *
     * @Route("/api/produits/{id}", name="delete_produit", methods={"DELETE"})
     * @SWG\Tag(name="Produit")
     *
     *  @SWG\Response(
     *     response=204,
     *     description="Returned when the product has been deleted",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(
     *              type="object",
     *              @SWG\Property(property="id", type="integer", example="1"),
     *              @SWG\Property(property="nom", type="string", example="Pomme"),
     *              @SWG\Property(property="prix", type="float", example="10"),
     *              @SWG\Property(property="description", type="string", example="alimentaire"),
     *              @SWG\Property(property="boutique_id", type="integer", example="1"),
     *              @SWG\Property(property="categories", type="string", example="FRUITS"),
     *     )
     * )
     * )
     *
     *  @SWG\Response(
     *      response=404,
     *      description="Returned when the product isn't found",
     *
     *      @SWG\Schema(
     *          type="object",
     *          @SWG\Property(property="status", type="integer", example=404),
     *          @SWG\Property(property="errors", type="string", example="Not found!")
     *      )
     * )
     * @noinspection PhpOptionalBeforeRequiredParametersInspection
     * @param Produit|null $existingProduit
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     */

     public function deleteProduit(
         Produit $existingProduit = null
     ) :JsonResponse {
         if(is_null($existingProduit)) {
             return $this->respondNotFound();
         }
         $this->em->remove($existingProduit);
         $this->em->flush();

         return $this->json('Produit supprimée',Response::HTTP_OK);

     }


     /**
     * update produit E_PRD_20 E_PRD_30
     * @Route("/api/produits/{id}", name="update_produit", methods={"PATCH"})
      * @SWG\Tag(name="Produit")
      *
      * @SWG\Parameter(
      *      name="nom",
      *      in="body",
      *      required=true,
      *      @SWG\Schema(
      *          type="object",
      *          required={"nom", "prix"},
      *          @SWG\Property(property="nom", type="string", example="Pomme"),
      *          @SWG\Property(property="prix", type="integer", example="10"),
      *              )
      * )
      *
      *   @SWG\Response(
      *     response=204,
      *     description=" Return when the product has been changed",
      *     @SWG\Schema(
      *         type="array",
      *         @SWG\Items(
      *              type="object",
      *              @SWG\Property(property="id", type="integer", example="1"),
      *              @SWG\Property(property="nom", type="string", example="Pomme"),
      *              @SWG\Property(property="prix", type="float", example="10"),
      *              @SWG\Property(property="description", type="string", example="alimentaire"),
      *              @SWG\Property(property="boutique_id", type="integer", example="1"),
      *              @SWG\Property(property="categories", type="string", example="FRUITS"),
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
      *          @SWG\Property(property="code", type="integer", example=422),
      *          @SWG\Property(property="message", type="string", example="Invalid Request."),
      *      )
      * )
      * @SWG\Response(
      *      response=404,
      *      description="Returned when the category isn't found",
      *
      *      @SWG\Schema(
      *          type="object",
      *          @SWG\Property(property="status", type="integer", example=404),
      *          @SWG\Property(property="errors", type="string", example="Not found!")
      *      )
      * )
     * @noinspection PhpOptionalBeforeRequiredParametersInspection
     * @param Produit|null $existingProduit
     * @param ProduitRepository $produitRepository
     * @param Request $request
     * @return JsonResponse
     */
    public function updateProduit(
        Produit $existingProduit = null,
        ProduitRepository $produitRepository,
        Request $request
    ): JsonResponse {
        if(is_null($existingProduit)) {
            return $this->respondNotFound();
        }
        $request = $this->transformJsonBody($request);
        $nom = $request->get('nom');
        $prix = $request->get('prix');
        $description = $request->get('description');
        $boutique = $request->get('boutique_id');

        if (empty($nom) || empty($prix)) {
            return $this->respondValidationError("Invalid request");
        }
        $existingProduit->setNom($nom);
        $existingProduit->setPrix($prix);

        if(!empty($description)) {
            $existingProduit->setDescription($description);
        }
        if(!empty($boutique)) {
            $boutiqueRepository = $this->em->getRepository(Boutique::class);
            $existingProduit->setBoutiqueId($boutiqueRepository->find($boutique));
        }

        $this->em->persist($existingProduit);
        $this->em->flush();

        return $this->json($existingProduit,Response::HTTP_OK);
    }

    
     /**
     * associer produit. to categories E_BTQ_50
     * @Route("/api/produits/{id}/categories", name="associer_categories_produit", methods={"PUT"})
      * @SWG\Tag(name="Produit")
      * @SWG\Parameter(
      *      name="produit",
      *      in="body",
      *      required=true,
      *      @SWG\Schema(
      *          type="object",
      *          required={"categories"},
      *          @SWG\Property(property="categories", type="string", example="FRUITS"),
      *              )
      * )
     * @SWG\Response(
      *     response=200,
      *     description="Returned when the product has been associated to the category ",
      *     @SWG\Schema(
      *         type="array",
      *         @SWG\Items(
      *              type="object",
      *              @SWG\Property(property="id", type="integer", example="1"),
      *              @SWG\Property(property="nom", type="string", example="Pomme"),
      *              @SWG\Property(property="prix", type="float", example="10"),
      *              @SWG\Property(property="description", type="string", example="alimentaire"),
      *              @SWG\Property(property="boutique_id", type="integer", example="1"),
      *              @SWG\Property(property="categories", type="string", example="FRUITS"),
      *     )
      * )
      * )
      * @SWG\Response(
      *      response=422,
      *      description="Returned when the sent request isn't valid",
      *
      *      @SWG\Schema(
      *          type="object",
      *          @SWG\Property(property="code", type="integer", example=422),
      *          @SWG\Property(property="message", type="string", example="Invalid Request."),
      *      )
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
     * @param Produit|null $existingProduit
     * @param Request $request
     * @return JsonResponse
     */
    public function associerProduitCategory(
        Produit $existingProduit = null,
        Request $request
    ): JsonResponse {
        if(is_null($existingProduit)) {
            return $this->respondNotFound();
        }
        $request = $this->transformJsonBody($request);
        $categories = $request->get('categories');
        
        if (empty($categories)) {
            return $this->respondValidationError("Invalid request");
        }
        $categorieRepository = $this->em->getRepository(Categorie::class);
        foreach($categories as $element) {
            $categorie = $categorieRepository->find($element);
            $existingProduit->addCategory($categorie);
            $categorie->addProduit($existingProduit);
            $this->em->persist($existingProduit);
            $this->em->persist($categorie);
        }
        $this->em->flush();
        return $this->json($existingProduit,Response::HTTP_OK);
    }


    /**
     * Get a list of all produits. E_PRD_70
     * @Route("/api/produits/boutiques/{id}/categories/{idCategorie}", name="produits_boutiques_categorie", methods={"GET"},requirements={"id"="\d+"})
     * @SWG\Tag(name="Produit")
     *
     *   @SWG\Response(
     *     response=200,
     *     description=" Return with the details of product",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(
     *              type="object",
     *              @SWG\Property(property="id", type="integer", example="1"),
     *              @SWG\Property(property="nom", type="string", example="Pomme"),
     *              @SWG\Property(property="prix", type="float", example="10"),
     *              @SWG\Property(property="description", type="string", example="alimentaire"),
     *              @SWG\Property(property="boutique_id", type="integer", example="1"),
     *              @SWG\Property(property="categories", type="string", example="FRUITS"),
     *     )
     * )
     * )
     * @noinspection PhpOptionalBeforeRequiredParametersInspection
     * @param Boutique|null $existingBoutique
     * @param Categorie|null $existingCategorie
     * @return JsonResponse
     */
    public function getAllProduitsBoutiqueCategorie(
        Boutique $existingBoutique = null,
        Categorie $existingCategorie = null
    ): JsonResponse {
        /*$produits = $existingCategorie
                    ->getProduits();//add filter sur boutique*/
        $produits = $this->em->getRepository(Produit::class)
                    ->findBy(
                        array(
                            "boutique_id" => $existingBoutique->getId(),
                            //"categories" => [$existingCategorie]
                        )
                  );
                
        return $this->json($produits,Response::HTTP_OK);
    }

    /**
     * Get a list of all produits Non Assigné
     * @Route("/api/produits/nonAssigner", name="produits_non_assigner", methods={"GET"})
     * * @SWG\Tag(name="Produit")
     *
     *  @SWG\Response(
     *     response=200,
     *     description="Returned with the list of products",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(
     *              type="object",
     *              @SWG\Property(property="id", type="integer", example="1"),
     *              @SWG\Property(property="nom", type="string", example="Pomme"),
     *              @SWG\Property(property="prix", type="float", example="10"),
     *              @SWG\Property(property="description", type="string", example="alimentaire"),
     *          
     *     )
     * )
     * )
     * @param ProduitRepository $produitRepository
     * @return JsonResponse
     */
     public function getAllProduitsNonAssigner(
        ProduitRepository $produitRepository
     ) {
        $produits =  $produitRepository->getAllProduitsNonAssigner();
        return $this->json($produits,Response::HTTP_OK);
     }

    








}