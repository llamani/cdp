<?php

namespace App\Controller\Api;

use App\Entity\Issue;
use App\Entity\Project;
use App\Entity\UserProjectRelation;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class IssueController extends AbstractController
{

    /**
     * @Route("/issues/{projectId}", name="api_get_all_issues", methods={"GET"})
     */
    public function getAll(SerializerInterface $serializer, $projectId)
    {
        $response = new Response();
        try {
            $userId = $this->getUser()->getId();
            $userProjectsRelations = $this->getDoctrine()->getRepository(UserProjectRelation::class)->findOneBy(['user' => $userId, 'project' => $projectId]);
            if (!empty($userProjectsRelations)) {
                $issuesList = $this->getDoctrine()->getRepository(Issue::class)->findBy(array('project' => $projectId));
                if (!empty($issuesList)) {
                    $jsonContent = $serializer->serialize($issuesList, 'json', [AbstractNormalizer::ATTRIBUTES => ['id', 'name', 'description', 'created_at', 'priority', 'difficulty', 'status', 'tasks'=>['id', 'status']]]);
                    $response->setStatusCode(Response::HTTP_OK);
                    $response->setContent($jsonContent);
                } else {
                    $response->setStatusCode(Response::HTTP_OK);
                    $response->setContent(json_encode([]));
                }
                $response->headers->set('Content-Type', 'application/json');
            } else {
                $response->setStatusCode(Response::HTTP_UNAUTHORIZED);
                $response->setContent("You can't access to this project.");
            }
        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }
    /**
     * @Route("/issue/{id}", name="api_get_issue_by_id", methods={"GET"})
     */
    public function getIssueByID(SerializerInterface $serializer, $id)
    {
        $response = new Response();
        try {
            $issue = $this->getDoctrine()->getRepository(Issue::class)->find($id);
            if ($issue != null) {
                $userId = $this->getUser()->getId();
                $userProjectsRelations = $this->getDoctrine()->getRepository(UserProjectRelation::class)->findOneBy(['user' => $userId, 'project' => $issue->getProject()->getId()]);
                if (!empty($userProjectsRelations)) {
                    $response->setStatusCode(Response::HTTP_OK);
                    $response->headers->set('Content-Type', 'application/json');
                    $jsonContent = $serializer->serialize($issue, 'json', [AbstractNormalizer::ATTRIBUTES => ['id', 'name', 'description', 'created_at', 'priority', 'difficulty', 'status', 'tasks'=>['id', 'status']]]);
                    $response->setContent($jsonContent);
                } else {
                    $response->setStatusCode(Response::HTTP_UNAUTHORIZED);
                    $response->setContent("You can't access to this project.");
                }
            } else {
                $response->setStatusCode(Response::HTTP_NOT_FOUND);
                $response->setContent('Unknown issue with id ' . $id);
            }
        } catch (Exception $exception) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($exception->getMessage());
        }
        return $response;
    }
    /**
     * @Route("/issue", name="api_create_issue", methods={"POST"})
     */
    public function createIssue(Request $request, SerializerInterface $serializer)
    {
        $response = new Response();
        try {
            $content = $request->getContent();
            $parametersAsArray = json_decode($content, true);
            $userId = $this->getUser()->getId();
            $userProjectsRelations = $this->getDoctrine()->getRepository(UserProjectRelation::class)->findOneBy(['user' => $userId, 'project' => $parametersAsArray['project']]);
            if (!empty($userProjectsRelations)) {
                $issue = new Issue();
                $issue->setName($parametersAsArray['name']);
                $issue->setDescription($parametersAsArray['description']);
                $issue->setCreatedAt(new \DateTime());
                $issue->setPriority($parametersAsArray['priority']);
                $issue->setDifficulty($parametersAsArray['difficulty']);
                $issue->setStatus($parametersAsArray['status']);
                $issue->setProject($this->getDoctrine()->getRepository(Project::class)->find($parametersAsArray['project']));
                $em = $this->getDoctrine()->getManager();
                $em->persist($issue);
                $em->flush();
                $response->setStatusCode(Response::HTTP_CREATED);
                $response->headers->set('Content-Type', 'application/json');
                $jsonContent = $serializer->serialize($issue, 'json', [AbstractNormalizer::ATTRIBUTES => ['id', 'name', 'description', 'created_at', 'priority', 'difficulty', 'status', 'tasks'=> ['id', 'status']]]);
                $response->setContent($jsonContent);
            } else {
                $response->setStatusCode(Response::HTTP_UNAUTHORIZED);
                $response->setContent("You can't access to this project.");
            }
        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }

    /**
     * @Route("/issue/{id}", name="api_update_issue", methods={"PUT"})
     */
    public function updateIssue(Request $request, SerializerInterface $serializer, $id)
    {
        $response = new Response();
        try {
            $data = json_decode($request->getContent(), true);
            $issue = $this->getDoctrine()->getRepository(Issue::class)->find($id);
            if ($issue != null) {
                $userId = $this->getUser()->getId();
                $userProjectsRelations = $this->getDoctrine()->getRepository(UserProjectRelation::class)->findOneBy(['user' => $userId, 'project' => $issue->getProject()->getId()]);
                if (!empty($userProjectsRelations)) {
                    $issue->setName($data['name']);
                    $issue->setDescription($data['description']);
                    $issue->setPriority($data['priority']);
                    $issue->setDifficulty($data['difficulty']);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($issue);
                    $em->flush();
                    $response->setStatusCode(Response::HTTP_OK);
                    $jsonContent = $serializer->serialize($issue, 'json', [AbstractNormalizer::ATTRIBUTES => ['id', 'name', 'description', 'created_at', 'priority', 'difficulty', 'status', 'tasks'=>['id','status']]]);

                    $response->headers->set('Content-Type', 'application/json');
                    $response->setContent($jsonContent);
                } else {
                    $response->setStatusCode(Response::HTTP_UNAUTHORIZED);
                    $response->setContent("You can't access to this project.");
                }
            } else {
                $response->setStatusCode(Response::HTTP_NOT_FOUND);
                $response->setContent('Unknown issue with id ' . $id);
            }
        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }

    /**
     * @Route("/slide-issue/{id}", name="api_update_issue_status", methods={"PUT"})
     */
    function updateIssueStatus(Request $request, SerializerInterface $serializer, $id)
    {
        $response = new Response();
        try {
            $data = json_decode($request->getContent(), true);
            $issue = $this->getDoctrine()->getRepository(Issue::class)->find($id);
            if ($issue != null) {
                $userId = $this->getUser()->getId();
                $userProjectsRelations = $this->getDoctrine()->getRepository(UserProjectRelation::class)->findOneBy(['user' => $userId, 'project' => $issue->getProject()->getId()]);
                if (!empty($userProjectsRelations)) {
                    $issue->setStatus($data['status']);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($issue);
                    $em->flush();
                    $response->setStatusCode(Response::HTTP_OK);
                    $jsonContent = $serializer->serialize($issue, 'json', [AbstractNormalizer::ATTRIBUTES => ['id', 'name', 'description', 'created_at', 'priority', 'difficulty', 'status','tasks'=>['id', 'status']]]);
                    $response->headers->set('Content-Type', 'application/json');
                    $response->setContent($jsonContent);
                } else {
                    $response->setStatusCode(Response::HTTP_UNAUTHORIZED);
                    $response->setContent("You can't access to this project.");
                }
            } else {
                $response->setStatusCode(Response::HTTP_NOT_FOUND);
                $response->setContent('Unknown issue with id ' . $id);
            }
        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }



    /**
     * @Route("/issue/{id}", name="api_delete_issue", methods={"DELETE"})
     */
    public function deleteIssue($id)
    {
        $response = new Response();
        try {
            $issue = $this->getDoctrine()->getRepository(Issue::class)->find($id);
            if ($issue != null) {
                $userId = $this->getUser()->getId();
                $userProjectsRelations = $this->getDoctrine()->getRepository(UserProjectRelation::class)->findOneBy(['user' => $userId, 'project' => $issue->getProject()->getId()]);
                if (!empty($userProjectsRelations)) {
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->remove($issue);
                    $entityManager->flush();
                    $response->setStatusCode(Response::HTTP_OK);
                    $response->setContent(null);
                } else {
                    $response->setStatusCode(Response::HTTP_UNAUTHORIZED);
                    $response->setContent("You can't access to this project.");
                }
            } else {
                $response->setStatusCode(Response::HTTP_NOT_FOUND);
                $response->setContent('Unknown issue with id ' . $id);
            }
        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }
}
