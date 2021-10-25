<?php

namespace App\Controller;


 use App\Entity\User;
 use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
 use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
 use Symfony\Component\HttpFoundation\JsonResponse;
 use Symfony\Component\HttpFoundation\Request;
 use Symfony\Component\HttpFoundation\Response;
 use Symfony\Component\Routing\Annotation\Route;
 use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
 use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AuthController extends ApiController
{

    private $jwtManager;
    private $tokenStorageInterface;

    public function __construct(TokenStorageInterface $tokenStorageInterface, JWTTokenManagerInterface $jwtManager)
    {
        $this->jwtManager = $jwtManager;
        $this->tokenStorageInterface = $tokenStorageInterface;
    }

    /**
     * @return JsonResponse
     * @Route("/api/user", name="get_user", methods={"GET"})
     */
    public function decodeUser(){
        $decodedJwtToken = $this->jwtManager->decode($this->tokenStorageInterface->getToken());

        return $this->response($decodedJwtToken);
    }

    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->transformJsonBody($request);
        $username = $request->get('username');
        $password = $request->get('password');
        $email = $request->get('email');

        if (empty($username) || empty($password) || empty($email)){
            return $this->respondValidationError("Invalido Username or Password or Email");
        }

        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy(['username' => $username]);

        if(!empty($user)){
            return $this->respondValidationError("El nombre de usuario se encuentra en uso");
        }

        $user = new User($username);
        $user->setPassword($encoder->encodePassword($user, $password));
        $user->setEmail($email);
        $user->setUsername($username);
        $em->persist($user);
        $em->flush();
        return $this->respondWithSuccess(sprintf('El usuario %s se creo correctamente', $user->getUsername()));
    }

    // /**
    //  * @param UserInterface $user
    //  * @param JWTTokenManagerInterface $JWTManager
    //  * @return JsonResponse
    //  */
    // public function getTokenUser(UserInterface $user, JWTTokenManagerInterface $JWTManager)
    // {
    //     dd("acacacac");
    //     $token = $JWTManager->create($user);
    //     dd($JWTManager->decode($token));

    //     return new JsonResponse(['token' => null]);
    // }

}
