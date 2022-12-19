<?php


namespace App\Controller;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthController extends ApiController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/api/register", name="register", methods={"POST"})
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
        $dateDeNaissance = $request->get('date_de_naissance');

        if (empty($email) || empty($password) || empty($nom)) {
            return $this->respondValidationError("Invalid Username or Password or Email");
        }

        $user = new User();
        $user->setEmail($email);
        $user->setPassword($encoder->encodePassword($user, $password));
        $user->setNom($nom);
        $user->setPrenom($prenom);
        $user->setDateDeNaissance(\DateTime::createFromFormat('d-m-Y',$dateDeNaissance));
        $user->setRoles(array('ROLE_ADMIN'));
        $this->em->persist($user);
        $this->em-> flush();
        return $this->respondWithSuccess(sprintf('User %s successfully created', $user->getUsername()));
    }

    /**
     * @Route("/api/login_check", name="login-check", methods={"POST"})
     * @param UserInterface $user
     * @param JWTTokenManagerInterface $JWTManager
     * @return JsonResponse
     */
    public function getTokenUser(UserInterface $user, JWTTokenManagerInterface $JWTManager): JsonResponse
    {
        return new JsonResponse(['token' => $JWTManager->create($user)]);
    }

}