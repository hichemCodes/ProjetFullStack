<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
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




class VilleController extends ApiController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Get a list of all citys.
     * @Route("/api/villes", name="ville", methods={"GET"})
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
     *              @SWG\Property(property="code postale", type="string", example="7600"),
     *              @SWG\Property(property="nom", type="string", example="Rouen"),
     *     )
     * )
     * )
     * @param VileR $categorieRepository
     * @return JsonResponse
     */
    public function getAllVilles(
        VilleRepository $villeRepository,
        Request $request
    ): JsonResponse {

        $villes = $villeRepository->getVilles();

        // Last Step : return the data.
        return $this->json($villes,Response::HTTP_OK,[],[ObjectNormalizer::CIRCULAR_REFERENCE_HANDLER => function(){
            return '';
        }]);
    }


 
}