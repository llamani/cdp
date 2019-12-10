<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class ProjectControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {

        $this->client = static::createClient([], [
            'PHP_AUTH_USER' => 'laura@example.com',
            'PHP_AUTH_PW'   => 'test',
        ]);
    }

    public function testUnauthorizedAccess()
    {
        $unauthClient = static::createClient();
        $unauthClient->request('GET', 'api/projects');
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $unauthClient->getResponse()->getStatusCode());
    }

    public function testAuthorizedAccess()
    {
        $this->client->request('GET', 'api/projects');
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testAddProject()
    {
        $arr = array('name' => 'test', 'description' => 'test', 'users' => ['1', '2']);
        $jsonData = json_encode($arr);

        $this->client->request(
            'POST',
            '/api/project',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $jsonData
        );

        $responseContent = $this->client->getResponse()->getContent();
        $parametersAsArray = json_decode($responseContent, true);
        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
        $this->checkArrays($arr, $parametersAsArray);
        $this->updateProject($parametersAsArray['id']);
        $this->removeProject($parametersAsArray['id']);
    }

    private function updateProject($id)
    {
        $arr = array('name' => 'test2', 'description' => 'test2', 'users' => ['1', '2', '3']);
        $jsonData = json_encode($arr);

        $this->client->request(
            'PUT',
            "/api/project/{$id}",
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $jsonData
        );
        $responseContent = $this->client->getResponse()->getContent();
        $parametersAsArray = json_decode($responseContent, true);

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->checkArrays($arr, $parametersAsArray);
    }

    private function removeProject($id)
    {
        $this->client->request('DELETE', "/api/project/{$id}");
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    private function checkArrays($arr, $parametersAsArray)
    {
        $this->assertEquals($arr['name'], $parametersAsArray['name']);
        $this->assertEquals($arr['description'], $parametersAsArray['description']);
        $responseMembers = $parametersAsArray['userProjectRelations'];
        $arrMembers = $arr['users'];
        $responseMemberIds = $this->getMemberIds($responseMembers);
        foreach ($arrMembers as $member) {
            $this->assertContains($member, $responseMemberIds);
        }
    }

    private function getMemberIds($responseMembers)
    {
        $list = [];
        foreach ($responseMembers  as $member) {
            $list[] = $member['user']['id'];
        }
        return $list;
    }
}
