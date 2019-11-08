<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\Issue;
use App\Entity\Project;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\Common\Collections\ArrayCollection;

class TaskController extends AbstractController
{
    /**
     * @Route("/tasks/{projectId}", name="api_get_all_tasks", methods={"GET"})
     */
    public function getAll(SerializerInterface $serializer, $projectId)
    {
        $response = new Response();
        try {
            $project = $this->getDoctrine()->getRepository(Project::class)->find($projectId);
            if ($project != null) {
                $tasksList = new ArrayCollection();
                foreach ($project->getIssues() as $issue) {
                    $tasksList = new ArrayCollection((array) $tasksList->toArray() + (array) $issue->getTasks()->toArray());
                }

                if (!empty($tasksList)) {
                    $jsonContent = $serializer->serialize($tasksList, 'json', ['circular_reference_handler' => function ($object) {
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
            }
        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }
    /**
     * @Route("/task/{id}", name="api_get_issue_by_id", methods={"GET"})
     */
    /*
    public function getIssueByID(SerializerInterface $serializer, $id) {
        $response = new Response();
        try {
            $issue = $this->getDoctrine()->getRepository(Issue::class)->find($id);
            if($issue != null) {
                $response->setStatusCode(Response::HTTP_OK);
                $response->headers->set('Content-Type', 'application/json');
                $jsonContent = $serializer->serialize($issue, 'json', ['circular_reference_handler' => function ($object) {
                    return $object->getId();
                }]);
                $response->setContent($jsonContent);
            }
            else {
                $response->setStatusCode(Response::HTTP_NOT_FOUND);
                $response->setContent( 'Unknown issue with id ' . $id);
            }
        } catch (Exception $exception) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($exception->getMessage());
        }
        return $response;
    }*/
    /**
     * @Route("/task", name="api_create_task", methods={"POST"})
     */
    public function createTask(Request $request, SerializerInterface $serializer)
    {
        $response = new Response();
        try {
            $content = $request->getContent();
            $parametersAsArray = json_decode($content, true);
            $task = new Task();
            $task->setName($parametersAsArray['name']);
            $task->setDescription($parametersAsArray['description']);
            $task->setCreatedAt(new \DateTime());
            $task->setStatus($parametersAsArray['status']);
            $task->setWorkload($parametersAsArray['workload']);
            $task->addIssue($this->getDoctrine()->getRepository(Issue::class)->find($parametersAsArray['issue']));
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();
            $response->setStatusCode(Response::HTTP_CREATED);
            $response->headers->set('Content-Type', 'application/json');
            $jsonContent = $serializer->serialize($task, 'json', ['circular_reference_handler' => function ($object) {
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
     * @Route("/task/{id}", name="api_update_task", methods={"PUT"})
     */
    public function updateTask(Request $request, SerializerInterface $serializer, $id)
    {
        $response = new Response();
        try {
            $data = json_decode($request->getContent(), true);
            $task = $this->getDoctrine()->getRepository(Task::class)->find($id);
            if ($task != null) {
                $task->setName($data['name']);
                $task->setDescription($data['description']);
                $task->setWorkload($data['workload']);
                $task->addIssue($this->getDoctrine()->getRepository(Issue::class)->find($data['issue']));
                $em = $this->getDoctrine()->getManager();
                $em->persist($task);
                $em->flush();
                $response->setStatusCode(Response::HTTP_OK);
                $jsonContent = $serializer->serialize($task, 'json', ['circular_reference_handler' => function ($object) {
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
     * @Route("/task/{id}", name="api_delete_task", methods={"DELETE"})
     */
    public function deleteTask($id)
    {
        $response = new Response();
        try {
            $task = $this->getDoctrine()->getRepository(Task::class)->find($id);
            if ($task != null) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($task);
                $entityManager->flush();
                $response->setStatusCode(Response::HTTP_OK);
                $response->setContent(null);
            } else {
                $response->setStatusCode(Response::HTTP_NOT_FOUND);
                $response->setContent('Unknown task with id ' . $id);
            }
        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }
}
