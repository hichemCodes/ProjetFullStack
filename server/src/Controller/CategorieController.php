<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Adresse;
use App\Entity\Boutique;
use App\Entity\Produit;
use App\Entity\Ville;
use App\Repository\BoutiqueRepository;
use App\Repository\AdresseRepository;
use App\Repository\VilleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;




class CategorieController extends ApiController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Get a list of all categories.
     * @Route("/api/categories", name="categories", methods={"GET"})
     * @SWG\Tag(name="Categorie")
     *
     *  @SWG\Response(
     *     response=200,
     *     description="Returned with the list of categories",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(
     *              type="object",
     *              @SWG\Property(property="id", type="integer", example="1"),
     *              @SWG\Property(property="nom", type="string", example="Boisson"),
     *              @SWG\Property(property="produits", type="string", example="Jus"),
     *     )
     * )
     * )
     * @param CategorieRepository $categorieRepository
     * @return JsonResponse
     */
    public function getAllCategories(
        CategorieRepository $categorieRepository,
        Request $request
    ): JsonResponse {

        // Step 1 : Fetch the data from database
        $request = $this->transformJsonBody($request);
        $query = "";
        $offset = 0;
        $limit = 10;
        if($request->query->has('query')) {
            $query = $request->query->get('query');
        }
        if($request->query->has('offset')) {
            $offset=$request->query->get('offset');
        }
        if($request->query->has('limit')) {
            $limit=$request->query->get('limit');
        }

        $categories = $categorieRepository->getCategories($query, $offset, $limit);

        // Last Step : return the data.
        return $this->json($categories,Response::HTTP_OK);
    }

    /**
     * Create categorie.
     * @Route("/api/categories", name="create_categorie", methods={"POST"})
     * @SWG\Tag(name="Categorie")
     *
     * @SWG\Parameter(
     *      name="nom",
     *      in="body",
     *      required=true,
     *      @SWG\Schema(
     *          type="object",
     *          required={"nom"},
     *          @SWG\Property(property="nom", type="string", example="Boisson")
     *              )
     * )
     *
     *   @SWG\Response(
     *     response=201,
     *     description=" Return when the category has been created",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(
     *              type="object",
     *              @SWG\Property(property="id", type="integer", example="1"),
     *              @SWG\Property(property="nom", type="string", example="Boisson"),
     *              @SWG\Property(property="produits", type="string", example="Jus"),
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
     *
     * @param CategorieRepository $categorieRepository
     * @param Request $request
     * @return JsonResponse
     */
    public function createCategorie(
        CategorieRepository $categorieRepository,
        Request $request
    ): JsonResponse {

        $request = $this->transformJsonBody($request);
        $nom = $request->get('nom');

        if (empty($nom) ) {
            return $this->respondValidationError("Invalid request");
        }

        $categorie = new Categorie();
        $categorie->setNom($nom);
        $this->em->persist($categorie);
        $this->em-> flush();

        // Last Step : return the data.
        return $this->json($categorie,Response::HTTP_CREATED, array());

    }

    /**
     * Get specific categorie.
     * @Route("/api/categories/{id}", name="categorie", methods={"GET"})
     * @SWG\Tag(name="Categorie")
     *
     *   @SWG\Response(
     *     response=200,
     *     description=" Return with the details of category",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(
     *              type="object",
     *              @SWG\Property(property="id", type="integer", example="1"),
     *              @SWG\Property(property="nom", type="string", example="Boisson"),
     *              @SWG\Property(property="produits", type="string", example="Jus"),
     *     )
     * )
     * )
     *
     * @return JsonResponse
     */
    public function getCategorie(
        Categorie $existingCategorie,
        CategorieRepository $categorieRepository
    ): JsonResponse {
        if(is_null($existingCategorie)) {
            return $this->respondNotFound();
        }
        $category=$categorieRepository->getCategory($existingCategorie->getId());
        return $this->json($category,Response::HTTP_OK);
    }

    /**
     * Update category
     * @Route("/api/categories/{id}", name="update_categorie", methods={"PATCH"})
     * @SWG\Tag(name="Categorie")
     *
     * @SWG\Parameter(
     *      name="nom",
     *      in="body",
     *      required=true,
     *      @SWG\Schema(
     *          type="object",
     *          required={"nom"},
     *          @SWG\Property(property="nom", type="string", example="Boisson")
     *              )
     * )
     *
     *   @SWG\Response(
     *     response=204,
     *     description=" Return when the category has been changed",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(
     *              type="object",
     *              @SWG\Property(property="id", type="integer", example="1"),
     *              @SWG\Property(property="nom", type="string", example="Boisson"),
     *              @SWG\Property(property="produits", type="string", example="Jus"),
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
     *
     * @noinspection PhpOptionalBeforeRequiredParametersInspection
     * @param Categorie|null $existingCategory
     * @param CategorieRepository $categoryRepository
     * @param Request $request
     * @return JsonResponse
     */
    public function updateCategory(
        Categorie $existingCategory = null,
        CategorieRepository  $categoryRepository,
        Request $request
    ): JsonResponse {
        if(is_null($existingCategory)) {
            return $this->respondNotFound();
        }
        $request = $this->transformJsonBody($request);
        $nom = $request->get('nom');

        if (empty($nom)) {
            return $this->respondValidationError("Invalid request");
        }
        $existingCategory->setNom($nom);

        $this->em->persist($existingCategory);
        $this->em->flush();

        // Last step : Return no data as confirmation.
        return $this->json($existingCategory,Response::HTTP_OK);

    }

    /**
     * Delete category.
     * @Route("/api/categories/{id}", name="delete_category", methods={"DELETE"})
     * @SWG\Tag(name="Categorie")
     *
     *  @SWG\Response(
     *     response=204,
     *     description="Returned when the category has been deleted",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(
     *              type="object",
     *              @SWG\Property(property="id", type="integer", example="1"),
     *              @SWG\Property(property="nom", type="string", example="Boisson"),
     *              @SWG\Property(property="produits", type="string", example="Jus"),
     *     )
     * )
     * )
     *
     *  @SWG\Response(
     *      response=404,
     *      description="Returned when the category isn't found",
     *
     *      @SWG\Schema(
     *          type="object",
     *          @SWG\Property(property="status", type="integer", example=404),
     *          @SWG\Property(property="errors", type="string", example="Not found!")
     *      )
     * )
     *
     * @noinspection PhpOptionalBeforeRequiredParametersInspection
     * @param Categorie|null $existingCategory
     * @return JsonResponse
     */

    public function deleteCategory(
        Categorie $existingCategory = null
    ) :JsonResponse {
        if(is_null($existingCategory)) {
            return $this->respondNotFound();
        }
        $this->em->remove($existingCategory);
        $this->em->flush();

        // Last step : Return no data as confirmation.
        return $this->json('Catégorie supprimée',Response::HTTP_OK);

    }

    /**
     * Associate  category to product E_CAT_40
     * @Route("/api/categories/{id}/produit/{idProduit}", name="associate_category_product", methods={"PATCH"})
     * @SWG\Tag(name="Categorie")
     *
     *  @SWG\Response(
     *     response=200,
     *     description="Returned when the category has been associated to the product ",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(
     *              type="object",
     *              @SWG\Property(property="id", type="integer", example="1"),
     *              @SWG\Property(property="nom", type="string", example="Boisson"),
     *              @SWG\Property(property="produits", type="string", example="Jus"),
     *     )
     * )
     * )
     *
     *  @SWG\Response(
     *      response=404,
     *      description="Returned when the category or the product isn't found",
     *
     *      @SWG\Schema(
     *          type="object",
     *          @SWG\Property(property="status", type="integer", example=404),
     *          @SWG\Property(property="errors", type="string", example="Not found!")
     *      )
     * )
     * @noinspection PhpOptionalBeforeRequiredParametersInspection
     * @param Boutique|null $existingBoutique
     * @param Produit|null $exsitingProduit
     * @return JsonResponse
     */
    public function associateCategoryToProduct(
        Categorie $existingCategory = null,
        Produit  $exsitingProduct =null
    ): JsonResponse {
        if(is_null($existingCategory)) {
            return $this->respondNotFound();
        }
        if (empty($exsitingProduct) || empty($existingCategory)) {
            return $this->respondValidationError("Invalid request");
        }
        $existingCategory->addProduit($exsitingProduct);
        $exsitingProduct->addCategory($existingCategory);
        $this->em->persist($existingCategory);

        $this->em->flush();
        return $this->json($existingCategory,Response::HTTP_OK);


    }
}