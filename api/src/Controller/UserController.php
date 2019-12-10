<?php

namespace App\Controller;

use App\Entity\User;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class UserController extends AbstractController {

    /**
     * @Route("/users", name="api_get_all_users", methods={"GET"})
     */
    public function getAll(SerializerInterface $serializer)
    {
        $response = new Response();
        try {
            $usersList = $this->getDoctrine()->getRepository(User::class)->findAll();

            if(!empty($usersList)) {
                $jsonContent = $serializer->serialize($usersList, 'json', [AbstractNormalizer::ATTRIBUTES => ['id', 'name']]);
                $response->setStatusCode(Response::HTTP_OK);
                $response->setContent($jsonContent);
            } else {
                $response->setStatusCode(Response::HTTP_OK);
                $response->setContent(json_encode([]));

            }
            $response->headers->set('Content-Type', 'application/json');
        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }

    /**
     * @Route("/signup", name="api_signup", methods={"POST"})
     */
    public function createUser(Request $request, SerializerInterface $serializer, UserPasswordEncoderInterface $passwordEncoder, ValidatorInterface $validator) {
        $response = new Response();
        try {
            $content = $request->getContent();
            $parametersAsArray = json_decode($content, true);
            $user = new User();
            $user->setName($parametersAsArray['name']);
            $user->setEmail($parametersAsArray['email']);
            $user->setPassword($passwordEncoder->encodePassword($user,$parametersAsArray['password']));

            $errors = $validator->validate($user);
            if (count($errors) > 0) {
                return new Response((string) $errors, 400);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $response->setStatusCode(Response::HTTP_CREATED);
            $response->headers->set('Content-Type', '/json');
            $jsonContent = $serializer->serialize($user, 'json');
            $response->setContent($jsonContent);
        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }

    /**
     * @Route("/api/auth", name="api_auth_user", methods={"GET"})
     */
    public function getAuthUser() {
        return new Response(json_encode([
            "name" => $this->getUser()->getName(),
            "email" => $this->getUser()->getEmail(),
        ]));
    }
}