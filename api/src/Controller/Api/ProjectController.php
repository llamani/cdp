<?php

namespace App\Controller\Api;

use App\Entity\Project;
use App\Entity\UserProjectRelation;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;


class ProjectController extends AbstractController {

    /**
     * @Route("/projects", name="api_get_all_projects", methods={"GET"})
     */
    public function getAll(SerializerInterface $serializer)
    {
        $response = new Response();
        try {
            $userId = $this->getUser()->getId();
            $userProjectsRelations = $this->getDoctrine()->getRepository(UserProjectRelation::class)->findBy(['user' => $userId]);
            $projects = $this->getProjectsByRelations($userProjectsRelations);
            if(!empty($projects)) {
                $jsonContent = $serializer->serialize($projects, 'json', [AbstractNormalizer::ATTRIBUTES => ['id', 'name', 'description', 'created_at']]);
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

    private function getProjectsByRelations($userProjectsRelations)
    {
        $p = [];
        foreach ($userProjectsRelations as $u) {
            $p[] = $u->getProject();
        }
        return $p;
    }

    /**
     * @Route("/project/{id}", name="api_get_project_by_id", methods={"GET"})
     */
    public function getProjectByID(SerializerInterface $serializer, $id) {
        $response = new Response();
        try {
            $project = $this->getDoctrine()->getRepository(Project::class)->find($id);
            if($project != null) {
                $response->setStatusCode(Response::HTTP_OK);
                $response->headers->set('Content-Type', 'application/json');
                $jsonContent = $serializer->serialize($project, 'json');
                $response->setContent($jsonContent);
            }
            else {
                $response->setStatusCode(Response::HTTP_NOT_FOUND);
                $response->setContent( 'Unknown project with id ' . $id);
            }
        } catch (Exception $exception) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($exception->getMessage());
        }
        return $response;
    }

    /**
     * @Route("/project", name="api_create_project", methods={"POST"})
     */
    public function createProject(Request $request, SerializerInterface $serializer) {
        $response = new Response();
        try {
            $user = $this->getUser();
            $content = $request->getContent();
            $parametersAsArray = json_decode($content, true);
            $project = new Project();
            $project->setName($parametersAsArray['name']);
            $project->setDescription($parametersAsArray['description']);
            $project->setCreatedAt(new \DateTime());

            $userProjRelation = new UserProjectRelation();
            $userProjRelation->setUser($user);
            $userProjRelation->setProject($project);
            $userProjRelation->setRole("owner");

            $em = $this->getDoctrine()->getManager();
            $em->persist($project);
            $em->persist($userProjRelation);
            $em->flush();
            $response->setStatusCode(Response::HTTP_CREATED);
            $response->headers->set('Content-Type', 'application/json');
            $jsonContent = $serializer->serialize($project, 'json');
            $response->setContent($jsonContent);
        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }

    /**
     * @Route("/project/{id}", name="api_update_project", methods={"PUT"})
     */
    public function updateProject(Request $request, SerializerInterface $serializer, $id) {
        $response = new Response();
        try {
            $userId = $this->getUser()->getId();
            $userProjectsRelations = $this->getDoctrine()->getRepository(UserProjectRelation::class)->findOneBy(['user' => $userId, 'project' => $id]);
            if(!empty($userProjectsRelations)) {
                $data = json_decode($request->getContent(), true);
                $project = $this->getDoctrine()->getRepository(Project::class)->find($id);

                if ($project != null) {
                    $project->setName($data['name']);
                    $project->setDescription($data['description']);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($project);
                    $em->flush();
                    $response->setStatusCode(Response::HTTP_OK);
                    $jsonContent = $serializer->serialize($project, 'json', [AbstractNormalizer::ATTRIBUTES => ['id', 'name', 'description', 'created_at']]);
                    $response->headers->set('Content-Type', 'application/json');
                    $response->setContent($jsonContent);
                } else {
                    $response->setStatusCode(Response::HTTP_NOT_FOUND);
                    $response->setContent('Unknown project with id ' . $id);
                }
            } else {
                $response->setStatusCode(Response::HTTP_UNAUTHORIZED);
                $response->setContent("You can't update this project." );
            }

        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }

    /**
     * @Route("/project/{id}", name="api_delete_project", methods={"DELETE"})
     */
    public function deleteProject($id) {
        $response = new Response();
        try {
            $userId = $this->getUser()->getId();
            $userProjectsRelations = $this->getDoctrine()->getRepository(UserProjectRelation::class)->findOneBy(['user' => $userId, 'project' => $id]);
            if(!empty($userProjectsRelations)) {
                $project = $this->getDoctrine()->getRepository(Project::class)->find($id);
                if ($project != null) {
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->remove($project);
                    $entityManager->flush();
                    $response->setStatusCode(Response::HTTP_OK);
                    $response->setContent(null);
                } else {
                    $response->setStatusCode(Response::HTTP_NOT_FOUND);
                    $response->setContent('Unknown project with id ' . $id);
                }
            }
            else {
                $response->setStatusCode(Response::HTTP_UNAUTHORIZED);
                $response->setContent("You can't delete this project." );
            }
        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }
}
