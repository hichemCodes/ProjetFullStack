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
     * @param CategorieRepository $categorieRepository
     * @return JsonResponse
     */
    public function getAllBoutique(
        CategorieRepository $categorieRepository
    ): JsonResponse {

        // Step 1 : Fetch the data from database
        $categories = $categorieRepository->findAll();

        // Last Step : return the data.
        return $this->json($categories,Response::HTTP_OK);
    }

    /**
     * Create categorie.
     * @Route("/api/categories", name="create_categorie", methods={"POST"})
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
     * @return JsonResponse
     */
    public function getCategorie(
        Categorie $existingCategorie
    ): JsonResponse {
        if(is_null($existingCategorie)) {
            return $this->respondNotFound();
        }
        return $this->json($existingCategorie,Response::HTTP_OK);
    }

    /**
     * Update category
     * @Route("/api/categories/{id}", name="update_categorie", methods={"PATCH"})
     * @noinspection PhpOptionalBeforeRequiredParametersInspection
     * @param Categorie|null $existingCategory
     * @param CategorieRepository $categoryRepository
     * @param Request $request
     * @return JsonResponse
     */
    public function updateBoutique(
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
     *
     *
     * @Route("/api/categories/{id}", name="delete_category", methods={"DELETE"})
     * @noinspection PhpOptionalBeforeRequiredParametersInspection
     * @param Categorie|null $existingCategory
     * @return JsonResponse
     */

    public function deleteBoutique(
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




}