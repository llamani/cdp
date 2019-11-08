<?php

namespace App\Controller;

use App\Entity\Issue;
use App\Entity\Project;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
            $issuesList = $this->getDoctrine()->getRepository(Issue::class)->findBy(array('project' => $projectId));
            if (!empty($issuesList)) {
                $jsonContent = $serializer->serialize($issuesList, 'json', ['circular_reference_handler' => function ($object) {
                    return $object->getId();
                }]);
                $response->setStatusCode(Response::HTTP_OK);
                $response->setContent($jsonContent);
            } else {
                // Aucune catégorie enregistrée
                $response->setStatusCode(Response::HTTP_OK);
                $response->setContent(json_encode([]));
            }
            $response->headers->set('Content-Type', 'text/html');
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
                $response->setStatusCode(Response::HTTP_OK);
                $response->headers->set('Content-Type', 'application/json');
                $jsonContent = $serializer->serialize($issue, 'json', ['circular_reference_handler' => function ($object) {
                    return $object->getId();
                }]);
                $response->setContent($jsonContent);
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
            $jsonContent = $serializer->serialize($issue, 'json', ['circular_reference_handler' => function ($object) {
                return $object->getId();
            }]);
            $response->setContent($jsonContent);
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
                $issue->setName($data['name']);
                $issue->setDescription($data['description']);
                $issue->setPriority($data['priority']);
                $issue->setDifficulty($data['difficulty']);
                $em = $this->getDoctrine()->getManager();
                $em->persist($issue);
                $em->flush();
                $response->setStatusCode(Response::HTTP_OK);
                $jsonContent = $serializer->serialize($issue, 'json', ['circular_reference_handler' => function ($object) {
                    return $object->getId();
                }]);
                $response->headers->set('Content-Type', 'application/json');
                $response->setContent($jsonContent);
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
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($issue);
                $entityManager->flush();
                $response->setStatusCode(Response::HTTP_OK);
                $response->setContent(null);
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
     * @Route("/issueIds/{projectId}", name="api_get_issue_ids", methods={"GET"})
     */
    public function getIssueIds(SerializerInterface $serializer, $projectId)
    {
        $response = new Response();
        try {
            $query = $this->getDoctrine()->getRepository(Issue::class)->createQueryBuilder("t");
            $issueIdsList = $query->select('t.id')
                ->getQuery()
                ->getResult();

            if ($issueIdsList != null) {
                $jsonContent = $serializer->serialize($issueIdsList, 'json', ['circular_reference_handler' => function ($object) {
                    return $object->getId();
                }]);
                $response->setStatusCode(Response::HTTP_OK);
                $response->setContent($jsonContent);
            } else {  // Aucune catégorie enregistrée
                $response->setStatusCode(Response::HTTP_OK);
                $response->setContent(json_encode([]));
            }
        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }
}
