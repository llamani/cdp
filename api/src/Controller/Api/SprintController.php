<?php

namespace App\Controller\Api;

use App\Entity\Sprint;
use App\Entity\Issue;
use App\Entity\Project;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


class SprintController extends AbstractController
{
    /**
     * @Route("/sprints/{projectId}", name="api_get_all_sprints", methods={"GET"})
     */
    public function getAll(SerializerInterface $serializer, $projectId)
    {
        $response = new Response();
        try {
            $sprintsList = $this->getDoctrine()->getRepository(Sprint::class)->findBy(array('project' => $projectId));

            if (!empty($sprintsList)) {
                $jsonContent = $serializer->serialize($sprintsList, 'json', ['circular_reference_handler' => function ($object) {
                    return $object->getId();
                }]);
                $response->setStatusCode(Response::HTTP_OK);
                $response->setContent($jsonContent);
            } else {
                // Aucune catégorie enregistrées
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
     * @Route("/sprint", name="api_create_sprint", methods={"POST"})
     */
    public function createSprint(Request $request, SerializerInterface $serializer)
    {
        $response = new Response();
        try {
            $content = $request->getContent();
            $data = json_decode($content, true);
            $sprint = new Sprint();
            $format = "d-m-Y";
            $sprint->setProject($this->getDoctrine()->getRepository(Project::class)->find($data['project']));
            $sprint->setStartDate(date_create_from_format($format, $data['startDate']));
            $sprint->setEndDate(date_create_from_format($format, $data['endDate']));

            $dependantIssues = $data['issue'];
            foreach ($dependantIssues as $issue)
                $sprint->addIssue($this->getDoctrine()->getRepository(Issue::class)->find($issue));

            $em = $this->getDoctrine()->getManager();
            $em->persist($sprint);
            $em->flush();
            $response->setStatusCode(Response::HTTP_CREATED);
            $response->headers->set('Content-Type', 'application/json');
            $jsonContent = $serializer->serialize($sprint, 'json', ['circular_reference_handler' => function ($object) {
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
     * @Route("/sprint/{id}", name="api_update_sprint", methods={"PUT"})
     */
    public function updateSprint(Request $request, SerializerInterface $serializer, $id)
    {
        $response = new Response();
        try {
            $data = json_decode($request->getContent(), true);
            $sprint = $this->getDoctrine()->getRepository(Sprint::class)->find($id);
            if ($sprint != null) {
                $format = "d-m-Y";
                $sprint->setProject($this->getDoctrine()->getRepository(Project::class)->find($data['project']));
                $sprint->setStartDate(date_create_from_format($format, $data['startDate']));
                $sprint->setEndDate(date_create_from_format($format, $data['endDate']));

                $oldIssues = $sprint->getIssues();
                $newIssues = $data['issue'];

                //remove old issues
                foreach ($oldIssues as $i => $oldIssue) {
                    $sprint->removeIssue($oldIssue);
                }
                //insert new issues
                foreach ($newIssues as $newIssueId) {
                    $newIssue = $this->getDoctrine()->getRepository(Issue::class)->find($newIssueId);
                    $sprint->addIssue($newIssue);
                }

                $em = $this->getDoctrine()->getManager();
                $em->persist($sprint);
                $em->flush();
                $response->setStatusCode(Response::HTTP_OK);
                $jsonContent = $serializer->serialize($sprint, 'json', ['circular_reference_handler' => function ($object) {
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
     * @Route("/sprint/{id}", name="api_delete_sprint", methods={"DELETE"})
     */
    public function deleteSprint($id)
    {
        $response = new Response();
        try {
            $sprint = $this->getDoctrine()->getRepository(Sprint::class)->find($id);
            if ($sprint != null) {
                $issues = $sprint->getIssues();
                foreach ($issues as $i => $issue) {
                    $sprint->removeIssue($issue);
                }
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($sprint);
                $entityManager->flush();
                $response->setStatusCode(Response::HTTP_OK);
                $response->setContent(null);
            } else {
                $response->setStatusCode(Response::HTTP_NOT_FOUND);
                $response->setContent('Unknown sprint with id ' . $id);
            }
        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }
}
