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
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BoutiqueController extends ApiController
{
    /**
     * Get a list of all boutiques.
     * @Route ("/api/boutiques", name="boutiques", methods={"GET"})
     * @param BoutiqueRepository $boutiqueRepository
     * @return JsonResponse
     */
    public function getAllBoutique(
        BoutiqueRepository $boutiqueRepository
    ): JsonResponse {

        // Step 1 : Fetch the data from database
        $boutiques = $boutiqueRepository->findAll();

        // Last Step : return the data.
        return $this->response($boutiques);
    }

    /**
     * Create boutique.
     * @Route ("/api/boutiques", name="create_boutique", methods={"POST"})
     * @param BoutiqueRepository $boutiqueRepository
     * @param Request $request
     * @param EntityManagerInterface $entityManagerInterface
     * @return JsonResponse
     */
    public function createBoutique(
        BoutiqueRepository $boutiqueRepository,
        Request $request,
        EntityManagerInterface $entityManagerInterface
    ): JsonResponse {

        $request = $this->transformJsonBody($request);
        $nom = $request->get('nom');
        $horaires_de_ouverture = $request->get('horaires_de_ouverture');
        $en_conge = $request->get('en_conge');
        $date_de_creation = $request->get('date_de_creation');

        if (empty($nom) || empty($horaires_de_ouverture) || empty($en_conge) || empty($date_de_creation)) {
            return $this->respondValidationError("Invalid request");
        }

        $boutique = new Boutique();
        $villeRepository = $this->$entityManagerInterface->getRepository(Ville::class);
        $boutique->setNom($nom);
        $boutique->setHorairesDeOuverture($horaires_de_ouverture);
        $boutique->setEnConge($en_conge);
        $boutique->setDateDeCreation($date_de_creation);

        if(!empty($request->get('ville_id'))) {
            $boutiqueAdresse = new Adresse();
            if(!empty($request->get('complement_adresse'))) {
                $boutiqueAdresse->setComplementAdresse($request->get('complement_adresse'));
                $boutiqueAdresse->setVilleId(
                    $villeRepository->find($request->get('ville_id'))
                );
                $this->$entityManagerInterface->persist($boutiqueAdresse);
                $this->$entityManagerInterface-> flush();
            }
        }
        $boutique->setAdresseId($boutiqueAdresse);
        $this->$entityManagerInterface->persist($boutique);
        $this->$entityManagerInterface-> flush();

        // Last Step : return the data.
        return $this->respondWithSuccess(sprintf('Boutique %s successfully created', $boutique->getNom()));

    }

    /**
     * Delete boutique.
     *
     *
     * @Route ("/api/boutiques/{id}", name="delete_boutique", methods={"DELETE"})
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
         return $this->noData();
     }




}