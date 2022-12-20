<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Boutique;
use App\Entity\Ville;
use App\Repository\BoutiqueRepository;
use App\Repository\AdresseRepository;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
        BoutiqueRepository $boutiqueRepository
    ): JsonResponse {

        // Step 1 : Fetch the data from database
        $boutiques = $boutiqueRepository->findAll();

        // Last Step : return the data.
        return $this->json($boutiques,Response::HTTP_OK);
    }

    /**
     * Create boutique.
     * @Route("/api/boutiques", name="create_boutique", methods={"POST"})
     * @param BoutiqueRepository $boutiqueRepository
     * @param Request $request
     * @param EntityManagerInterface $entityManagerInterface
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
         $entityManager->remove($existingBoutique);
         $entityManager->flush();

         // Last step : Return no data as confirmation.
         return $this->json('Boutique supprimée',Response::HTTP_OK);

     }




}