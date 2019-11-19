<?php

namespace App\Controller\Api;

use App\Entity\Test;
use App\Entity\Project;
use App\Entity\User;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\Common\Collections\ArrayCollection;


class TestController extends AbstractController {

    /**
     * @Route("/tests/{projectId}", name="api_get_all_tests", methods={"GET"})
     */
    public function getAll(SerializerInterface $serializer, $projectId)
    {
        $response = new Response();
        try {
            $testsList = $this->getDoctrine()->getRepository(Test::class)->findBy(array('project' => $projectId));
            if (!empty($testsList)) {
                $jsonContent = $serializer->serialize($testsList, 'json', ['circular_reference_handler' => function ($object) {
                    return $object->getId();
                }]);
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
     * @Route("/test/{id}", name="api_get_test_by_id", methods={"GET"})
     */
    public function getTestByID(SerializerInterface $serializer, $id)
    {
        $response = new Response();
        try {
            $test = $this->getDoctrine()->getRepository(Test::class)->find($id);
            if ($test != null) {
                $response->setStatusCode(Response::HTTP_OK);
                $response->headers->set('Content-Type', 'application/json');
                $jsonContent = $serializer->serialize($test, 'json', ['circular_reference_handler' => function ($object) {
                    return $object->getId();
                }]);
                $response->setContent($jsonContent);
            } else {
                $response->setStatusCode(Response::HTTP_NOT_FOUND);
                $response->setContent('Unknown test with id ' . $id);
            }
        } catch (Exception $exception) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($exception->getMessage());
        }
        return $response;
    }

    /**
     * @Route("/test", name="api_create_test", methods={"POST"})
     */
    public function createTest(Request $request, SerializerInterface $serializer)
    {
        $response = new Response();
        try {
            $content = $request->getContent();
            $data = json_decode($content, true);
            $test = new Test();
            $test->setName($data['name']);
            $test->setDescription($data['description']);
            $test->setType($data['type']);
            $test->setExpectedResult($data['expectedResult']);
            $test->setObtainedResult($data['obtainedResult']);
            $test->setTestDate( new \DateTime($data['testDate']));
            $test->setStatus($data['status']);
            $test->setProject($this->getDoctrine()->getRepository(Project::class)->find($data['project']));
            $testManagers = $data['testManagers'];
            foreach($testManagers as $manager)
                $test->addTestManager($this->getDoctrine()->getRepository(User::class)->find($manager));
            $em = $this->getDoctrine()->getManager();
            $em->persist($test);
            $em->flush();
            $response->setStatusCode(Response::HTTP_CREATED);
            $response->headers->set('Content-Type', 'application/json');
            $jsonContent = $serializer->serialize($test, 'json', ['circular_reference_handler' => function ($object) {
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
     * @Route("/test/{id}", name="api_update_test", methods={"PUT"})
     */
    public function updateTest(Request $request, SerializerInterface $serializer, $id) {
        $response = new Response();
        try {
            $data = json_decode($request->getContent(), true);
            $test = $this->getDoctrine()->getRepository(Test::class)->find($id);
            if ($test != null) {
                $test->setName($data['name']);
                $test->setDescription($data['description']);
                $test->setType($data['type']);
                $test->setExpectedResult($data['expectedResult']);
                $test->setObtainedResult($data['obtainedResult']);
                $format = "d-m-Y";
                $test->setTestDate(date_create_from_format($format, $data['testDate']));
                $test->setStatus($data['status']);

                $oldTestManagers = $test->getTestManagers();
                $newTestManagers = $data['testManagers'];

                 //remove old test managers
                 foreach ($oldTestManagers as $i => $oldManager) {
                    $test->removeTestManager($oldManager);
                }
                //insert new test managers
                foreach ($newTestManagers as $newManagerId) {
                    $newManager = $this->getDoctrine()->getRepository(User::class)->find($newManagerId);
                    $test->addTestManager($newManager);
                }

                $em = $this->getDoctrine()->getManager();
                $em->persist($test);
                $em->flush();
                $response->setStatusCode(Response::HTTP_OK);
                $jsonContent = $serializer->serialize($test, 'json', ['circular_reference_handler' => function ($object) {
                    return $object->getId();
                }]);
                $response->headers->set('Content-Type', 'application/json');
                $response->setContent($jsonContent);
            } else {
                $response->setStatusCode(Response::HTTP_NOT_FOUND);
                $response->setContent('Unknown test with id ' . $id);
            }
        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }

    /**
     * @Route("/test/{id}", name="api_delete_test", methods={"DELETE"})
     */
    public function deleteTest($id) {
        $response = new Response();
        try {
            $test = $this->getDoctrine()->getRepository(Test::class)->find($id);
            if ($test != null) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($test);
                $entityManager->flush();
                $response->setStatusCode(Response::HTTP_OK);
                $response->setContent(null);
            } else {
                $response->setStatusCode(Response::HTTP_NOT_FOUND);
                $response->setContent('Unknown test with id ' . $id);
            }
        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }
} 
