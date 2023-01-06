<?php


namespace App\Controller;


use App\Entity\User;
use App\Entity\Adresse;
use App\Entity\Ville;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class AuthController extends ApiController
{
    private $tokenStorage   = null;


    public function __construct(EntityManagerInterface $em,TokenStorageInterface $tokenStorage)
    {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @Route("/api/register", name="register", methods={"POST"})
     *@SWG\Tag(name="Authentification")
     *
     * @SWG\Parameter(
     *      name="User",
     *      in="body",
     *      required=true,
     *      @SWG\Schema(
     *          type="object",
     *          required={"email", "password", "nom", "prenom"},
     *              @SWG\Property(property="email", type="string", example="johnwick@email.com"),
     *              @SWG\Property(property="password", type="string", example="motdepasse2022"),
     *              @SWG\Property(property="nom", type="string", example="Wick"),
     *              @SWG\Property(property="prenom", type="string", example="John"),
     *              )
     * )
     *
     *   @SWG\Response(
     *     response=201,
     *     description=" Return when the user has been created",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(
     *              type="object",
     *              @SWG\Property(property="id", type="integer", example="1"),
     *              @SWG\Property(property="email", type="string", example="johnwick@email.com"),
     *              @SWG\Property(property="roles", type="json", example="ROLE_ADMIN"),
     *              @SWG\Property(property="password", type="string", example="motdepasse2022"),
     *              @SWG\Property(property="nom", type="string", example="Wick"),
     *              @SWG\Property(property="prenom", type="string", example="John"),
     *              @SWG\Property(property="adresse_id", type="integer", example="1"),
     *              @SWG\Property(property="boutique_id", type="integer", example="1"),
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
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return JsonResponse
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder): JsonResponse
    {
        $request = $this->transformJsonBody($request);
        $email = $request->get('email');
        $password = $request->get('password');
        $nom = $request->get('nom');
        $prenom = $request->get('prenom');

        if (empty($email) || empty($password) || empty($nom)) {
            return $this->respondValidationError("Invalid Username or Password or Email");
        }

        $user = new User();
        $villeRepository = $this->em->getRepository(Ville::class);
        $user->setEmail($email);
        $user->setPassword($encoder->encodePassword($user, $password));
        $user->setNom($nom);
        $user->setPrenom($prenom);
        $user->setRoles(array($request->get('roles')));
        if(!empty($request->get('ville_id'))) {
             $userAdress = new Adresse();
             if(!empty($request->get('complement_adresse'))) {
                $userAdress->setComplementAdresse($request->get('complement_adresse'));
                $userAdress->setVilleId(
                    $villeRepository->find($request->get('ville_id'))
                );
                $this->em->persist($userAdress);
                $this->em-> flush();
            } 
        }
        $user->setAdresseId($userAdress);
        $this->em->persist($user);
        $this->em-> flush();
        return $this->respondWithSuccess(sprintf('User %s successfully created', $user->getUsername()));
    }

    /**
     * @Route("/api/login_check", name="login-check", methods={"POST"})
     * @SWG\Tag(name="Authentification")
     *
     * @SWG\Parameter(
     *      name="User",
     *      in="body",
     *      required=true,
     *      @SWG\Schema(
     *          type="object",
     *          required={"username", "password"},
     *              @SWG\Property(property="username", type="string", example="johnwick@email.com"),
     *              @SWG\Property(property="password", type="string", example="motdepasse2022"),
     *              )
     * )
     *
     *   @SWG\Response(
     *     response=201,
     *     description=" Return when the user has been connected",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(
     *              type="object",
     *              @SWG\Property(property="id", type="integer", example="1"),
     *              @SWG\Property(property="email", type="string", example="johnwick@email.com"),
     *              @SWG\Property(property="roles", type="json", example="ROLE_ADMIN"),
     *              @SWG\Property(property="password", type="string", example="motdepasse2022"),
     *              @SWG\Property(property="nom", type="string", example="Wick"),
     *              @SWG\Property(property="prenom", type="string", example="John"),
     *              @SWG\Property(property="adresse_id", type="integer", example="1"),
     *              @SWG\Property(property="boutique_id", type="integer", example="1"),
     *     )
     * )
     * )
     * @SWG\Response(
     *      response=401,
     *      description="Returned when the credentials isn't valid",
     *
     *      @SWG\Schema(
     *          type="object",
     *          @SWG\Property(property="code", type="integer", example=401),
     *          @SWG\Property(property="message", type="string", example="Invalid credentials."),
     *      )
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
     * @param UserInterface $user
     * @param JWTTokenManagerInterface $JWTManager
     * @return JsonResponse
     */
    public function getTokenUser(UserInterface $user, JWTTokenManagerInterface $JWTManager): JsonResponse
    {
        return new JsonResponse(
            [
            'token' => $JWTManager->create($user),
            ]
        );
    }

    /**
     * @Route("/api/user/me", name="get_me", methods={"GET"})
     * @SWG\Tag(name="Authentification")
     *
     * @SWG\Parameter(
     *      name="User",
     *      in="body",
     *      required=true,
     *      @SWG\Schema(
     *          type="object",
     *          required={"username", },
     *              @SWG\Property(property="username", type="string", example="johnwick@email.com"),
     *              @SWG\Property(property="password", type="string", example="motdepasse2022"),
     *              )
     * )
     *
     *   @SWG\Response(
     *     response=201,
     *     description=" Return the current  user connected",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(
     *              type="object",
     *              @SWG\Property(property="email", type="string", example="johnwick@email.com"),
     *     )
     * )
     * )
     * @SWG\Response(
     *      response=401,
     *      description="Returned when the user is not connected",
     *
     *      @SWG\Schema(
     *          type="object",
     *          @SWG\Property(property="code", type="integer", example=401),
     *          @SWG\Property(property="message", type="string", example="Invalid credentials."),
     *      )
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
    */
    public function getUser(): ?JsonResponse
    {
        $useremail = $this->get('security.token_storage')->getToken()->getUser()->getUserIdentifier();
        $user = $this->em->getRepository(User::class)->findBy(array("email" => $useremail));
        return $this->json($user,Response::HTTP_OK);
         
    }

    /**
     * @Route("/api/logout", name="logout", methods={"POST"})
     * @SWG\Tag(name="Authentification")
     * @SWG\Response(
     *      response=200,
     *      description="Returned when the user logout",
     *
     *      @SWG\Schema(
     *          type="object",
     *          @SWG\Property(property="code", type="integer", example=200),
     *          @SWG\Property(property="message", type="string", example="OK"),
     *      )
     * )
     *
     **/
    public function logout()
    {
        $this->get('security.token_storage')->setToken(null);
        $this->get('request_stack')->getCurrentRequest()->getSession()->invalidate();
    }
    
}