<?php

namespace App\Controller\Api;

use App\Entity\Project;
use App\Entity\Release;
use App\Entity\Sprint;
use App\Entity\UserProjectRelation;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;


class ReleaseController extends AbstractController {

    /**
     * @Route("/releases/{projectId}", name="api_get_all_releases", methods={"GET"})
     */
    public function getAll(SerializerInterface $serializer, $projectId)
    {
        $response = new Response();
        try {
            $userId = $this->getUser()->getId();
            $project = $this->getDoctrine()->getRepository(Project::class)->find($projectId);
            $userReleasesRelations = $this->getDoctrine()->getRepository(UserProjectRelation::class)->findOneBy(['user' => $userId, 'project' => ($project!= null)?$project->getId(): "-1"]);
            if(!empty($userReleasesRelations)) {
                $releases = $this->getReleasesFromProject($project);
                if (!empty($releases)) {
                    $jsonContent = $serializer->serialize($releases, 'json', [AbstractNormalizer::ATTRIBUTES => ['id', 'name', 'description', 'releaseDate', 'srcLink', 'sprint' => ['id', 'startDate', 'endDate']]]);
                    $response->setStatusCode(Response::HTTP_OK);
                    $response->setContent($jsonContent);
                } else {
                    $response->setStatusCode(Response::HTTP_OK);
                    $response->setContent(json_encode([]));
                }
                $response->headers->set('Content-Type', 'application/json');
            }
            else {
                $response->setStatusCode(Response::HTTP_UNAUTHORIZED);
                $response->setContent("You can't create release for this project." );
            }
        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }

    private function getReleasesFromProject(Project $project)
    {
        $releasesList = [];
        $sprints = $project->getSprints();
        foreach ($sprints as $sprint) {
            foreach ($sprint->getReleases() as $release) {
                array_push($releasesList, $release);
            }
        }
        return $releasesList;
    }


    /**
     * @Route("/release", name="api_create_release", methods={"POST"})
     */
    public function createRelease(Request $request, SerializerInterface $serializer) {
        $response = new Response();
        try {
            $content = $request->getContent();
            $data = json_decode($content, true);
            $userId = $this->getUser()->getId();
            $sprint = $this->getDoctrine()->getRepository(Sprint::class)->find(intval($data["sprint"]));
            $userReleasesRelations = $this->getDoctrine()->getRepository(UserProjectRelation::class)->findOneBy(['user' => $userId, 'project' => ($sprint!= null)?$sprint->getProject()->getId(): "-1"]);
            if(!empty($userReleasesRelations)) {
                $release = new Release();
                $release->setName($data['name']);
                $release->setDescription($data['description']);
                $release->setReleaseDate(new \DateTime());
                $release->setSrcLink($data['src_link']);
                $release->setSprint($sprint);
                $em = $this->getDoctrine()->getManager();
                $em->persist($release);
                $em->flush();

                $response->setStatusCode(Response::HTTP_CREATED);
                $response->headers->set('Content-Type', 'application/json');
                $jsonContent = $serializer->serialize($release, 'json', [AbstractNormalizer::ATTRIBUTES => ['id', 'name', 'description', 'releaseDate', 'srcLink', 'sprint' => ['id', 'startDate', 'endDate']]]);
                $response->setContent($jsonContent);
            } else {
                $response->setStatusCode(Response::HTTP_UNAUTHORIZED);
                $response->setContent("You can't create release for this project." );
            }
        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }

    /**
     * @Route("/release/{id}", name="api_update_release", methods={"PUT"})
     */
    public function updateRelease(Request $request, SerializerInterface $serializer, $id) {
        $response = new Response();
        try {
            $data = json_decode($request->getContent(), true);
            $release = $this->getDoctrine()->getRepository(Release::class)->find($id);
            if ($release != null) {
                $userId = $this->getUser()->getId();
                $userReleasesRelations = $this->getDoctrine()->getRepository(UserProjectRelation::class)->findOneBy(['user' => $userId, 'project' => $release->getSprint()->getProject()->getId()]);
                if(!empty($userReleasesRelations)) {
                    $sprint = $this->getDoctrine()->getRepository(Sprint::class)->find($data["sprint"]);
                    $release->setName($data['name']);
                    $release->setDescription($data['description']);
                    $release->setReleaseDate(new \DateTime($data['release_date']));
                    $release->setSrcLink($data['src_link']);
                    if($sprint != null) {
                        $release->setSprint($sprint);
                    }
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($release);
                    $em->flush();
                    $response->setStatusCode(Response::HTTP_OK);
                    $jsonContent = $serializer->serialize($release, 'json', [AbstractNormalizer::ATTRIBUTES => ['id', 'name', 'description', 'releaseDate', 'srcLink', 'sprint' => ['id', 'startDate', 'endDate']]]);
                    $response->headers->set('Content-Type', 'application/json');
                    $response->setContent($jsonContent);

                } else {
                    $response->setStatusCode(Response::HTTP_UNAUTHORIZED);
                    $response->setContent("You can't update this release." );
                }
            } else {
                $response->setStatusCode(Response::HTTP_NOT_FOUND);
                $response->setContent('Unknown release with id ' . $id);
            }
        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }

    /**
     * @Route("/release/{id}", name="api_delete_release", methods={"DELETE"})
     */
    public function deleteRelease($id) {
        $response = new Response();
        try {
            $release = $this->getDoctrine()->getRepository(Release::class)->find($id);
            if ($release != null) {
                $userId = $this->getUser()->getId();
                $userReleasesRelations = $this->getDoctrine()->getRepository(UserProjectRelation::class)->findOneBy(['user' => $userId, 'project' => $release->getSprint()->getProject()->getId()]);
                if(!empty($userReleasesRelations)) {
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->remove($release);
                    $entityManager->flush();
                    $response->setStatusCode(Response::HTTP_OK);
                    $response->setContent(null);
                } else {
                    $response->setStatusCode(Response::HTTP_UNAUTHORIZED);
                    $response->setContent("You can't delete this release." );
                }
            } else {
                $response->setStatusCode(Response::HTTP_NOT_FOUND);
                $response->setContent('Unknown release with id ' . $id);
            }
        } catch (Exception $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($e->getMessage());
        }
        return $response;
    }
}
