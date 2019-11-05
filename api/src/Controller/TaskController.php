<?php

namespace App\Controller;

use App\Entity\Task;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


class TaskController extends AbstractController {

    /**
     * @Route("/tasks", name="api_get_all_tasks", methods={"GET"})
     */
    public function getAll(SerializerInterface $serializer)
    {
        $response = new Response();
        try {
            $tasksList = $this->getDoctrine()->getRepository(Task::class)->findAll();

            if(!empty($tasksList)) {
                $jsonContent = $serializer->serialize($tasksList, 'json');
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
     * @Route("/task/{id}", name="api_get_task_by_id", methods={"GET"})
     */
    public function getTaskByID(SerializerInterface $serializer, $id) {
        $response = new Response();
        try {
            $task = $this->getDoctrine()->getRepository(Task::class)->find($id);
            if($task != null) {
                $response->setStatusCode(Response::HTTP_OK);
                $response->headers->set('Content-Type', 'application/json');
                $jsonContent = $serializer->serialize($task, 'json');
                $response->setContent($jsonContent);
            }
            else {
                $response->setStatusCode(Response::HTTP_NOT_FOUND);
                $response->setContent( 'Unknown task with id ' . $id);
            }
        } catch (Exception $exception) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($exception->getMessage());
        }
        return $response;
    }

    /**
     * @Route("/task", name="api_create_task", methods={"POST"})
     */
    public function createTask(Request $request, SerializerInterface $serializer) {
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
            //ajouter liste user stories
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();
            $response->setStatusCode(Response::HTTP_CREATED);
            $response->headers->set('Content-Type', 'application/json');
            $jsonContent = $serializer->serialize($task, 'json');
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
    public function updateTask(Request $request, SerializerInterface $serializer, $id) {
        $response = new Response();
        try {
            $data = json_decode($request->getContent(), true);
            $task = $this->getDoctrine()->getRepository(Task::class)->find($id);

            if ($task != null) {
                $task->setName($data['name']);
                $task->setDescription($data['description']);
                $task->setStatus($parametersAsArray['status']);
                $task->setWorkload($parametersAsArray['workload']);
                //ajouter liste user stories
                $em = $this->getDoctrine()->getManager();
                $em->persist($task);
                $em->flush();
                $response->setStatusCode(Response::HTTP_OK);
                $jsonContent = $serializer->serialize($task, 'json');
                $response->headers->set('Content-Type', 'application/json');
                $response->setContent($jsonContent);
            } else {
                $response->setStatusCode(Response::HTTP_NOT_FOUND);
                $response->setContent( 'Unknown task with id ' . $id);
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
    public function deleteTask($id) {
        $response = new Response();
        try {
            $task = $this->getDoctrine()->getRepository(Task::class)->find($id);
            if($task != null) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($task);
                $entityManager->flush();
                $response->setStatusCode(Response::HTTP_OK);
                $response->setContent(null);
            }
            else {
                $response->setStatusCode(Response::HTTP_NOT_FOUND);
                $response->setContent( 'Unknown task with id ' . $id);
            }
        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }
}