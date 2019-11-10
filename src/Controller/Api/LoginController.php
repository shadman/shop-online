<?php
namespace App\Controller\Api;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Entity\User;
use App\Repository\UserRepository;


class LoginController extends AbstractFOSRestController
{
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * Login user in account
     * @Rest\Post("/login", name="api_login")
     * @param Request $request
     * @param UserRepository $userRepository
     * 
     * @return Response $response json
     */
    public function login(Request $request, UserRepository $userRepository)
    {

        $email = $request->request->get("email");
        $password = $request->request->get("password");

        if (empty($email) || empty($password)) {
            $data['error']  = "Email and password fields are required";

            $response = new Response();
            $response->setContent(json_encode($data));
            $response->setStatusCode(Response::HTTP_NON_AUTHORITATIVE_INFORMATION);
            return $response;
        }

        $user = $userRepository->findOneByEmail($email);

        if ($user === null) {
            $data['error']  = "User account doesn't exist.";

            $response = new Response();
            $response->setContent(json_encode($data));
            $response->setStatusCode(Response::HTTP_NON_AUTHORITATIVE_INFORMATION);
            return $response;
        }

        if (!$this->passwordEncoder->isPasswordValid($user, $password)) {
            $data['error']  = "Email address or password is invalid.";

            $response = new Response();
            $response->setContent(json_encode($data));
            $response->setStatusCode(Response::HTTP_NON_AUTHORITATIVE_INFORMATION);
            return $response;
        }

        if (empty($user->getApiToken)) {
            $bytes = random_bytes(10);
            $apiToken = bin2hex($bytes).'-'.time();
            $user->setApiToken($apiToken);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $data['apikey'] = $user->getApiToken();

            $response = new Response();
            $response->setContent(json_encode($data));
            $response->setStatusCode(Response::HTTP_OK);
            return $response;
        } else {
            $data['apikey'] = $user->getApiToken();

            $response = new Response();
            $response->setContent(json_encode($data));
            $response->setStatusCode(Response::HTTP_OK);
            return $response;
        }

        $response = new Response();
        $response->setContent(json_encode([]));
        $response->setStatusCode(Response::HTTP_OK);
        return $response;
    }

}
