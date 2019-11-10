<?php
namespace App\Controller\Api;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;

use App\Entity\User;
use App\Form\RegistrationFormType;

class RegistrationController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/register", name="api_register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * 
     * @return Response $response json
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {

        $formData = json_decode($request->getContent(), true);

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);        

        if ($request->isMethod('POST')) {
            $form->submit($formData);

            if ($form->isSubmitted() && $form->isValid()) {
                // encode the plain password
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
                $user->setRoles(['ROLE_USER']);
                $user->setCreatedAt(date("Y-m-d H:i:s"));

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                $data = ['id'=>$user->getId(), 'email'=>$user->getEmail(), 'fullName'=>$user->getFullName(), 'createdAt'=>$user->getCreatedAt()];

                $response = new Response();
                $response->setContent(json_encode($data));
                $response->setStatusCode(Response::HTTP_OK);
                return $response;
            }
        }

        $errors = $form->getErrors(true,false);
        
        $response = new Response();
        $response->setContent(json_encode($errors));
        $response->setStatusCode(Response::HTTP_NON_AUTHORITATIVE_INFORMATION);
        return $response;
        
    }

}
