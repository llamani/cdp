<?php

namespace App\Controller;

use App\Entity\User;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


class UserController extends AbstractController {


    /**
     * @Route("/user", name="api_create_user", methods={"POST"})
     */
    public function createUser(Request $request, SerializerInterface $serializer) {
        $response = new Response();
        try {
            $content = $request->getContent();
            $parametersAsArray = json_decode($content, true);
            $user = new User();
            $user->setName($parametersAsArray['name']);
            $user->setEmail($parametersAsArray['email']);
            $user->setPassword($parametersAsArray['password']);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $response->setStatusCode(Response::HTTP_CREATED);
            $response->headers->set('Content-Type', 'application/json');
            $jsonContent = $serializer->serialize($user, 'json');
            $response->setContent($jsonContent);
        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }

}