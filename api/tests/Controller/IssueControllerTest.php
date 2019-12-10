<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class IssueControllerTest extends WebTestCase
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
        $unauthClient->request('GET', 'api/issues/1');
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $unauthClient->getResponse()->getStatusCode());
    }

    public function testAuthorizedAccess()
    {
        $this->client->request('GET', 'api/issues/1');
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testAddIssue()
    {
        $arr = array('name' => 'test', 'description' => 'test', 'priority' => 'low', 'difficulty' => 'easy', 'status' => 'done', 'project' => '1');
        $jsonData = json_encode($arr);

        $this->client->request(
            'POST',
            '/api/issue',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $jsonData
        );

        $responseContent = $this->client->getResponse()->getContent();
        $parametersAsArray = json_decode($responseContent, true);

        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
        $this->checkArrays($arr, $parametersAsArray);
        $this->updateIssue($parametersAsArray['id']);
        $this->removeIssue($parametersAsArray['id']);
    }

    private function updateIssue($id)
    { 
        $arr = array('name' => 'test2', 'description' => 'test2', 'priority' => 'high', 'difficulty' => 'difficult');
        $jsonData = json_encode($arr);

        $this->client->request(
            'PUT',
            "/api/issue/{$id}",
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

    private function removeIssue($id)
    {
        $this->client->request('DELETE', "/api/issue/{$id}");
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    private function checkArrays($arr, $parametersAsArray){
        $this->assertEquals($arr['name'], $parametersAsArray['name']);
        $this->assertEquals($arr['description'], $parametersAsArray['description']);
        $this->assertEquals($arr['priority'], $parametersAsArray['priority']);
        $this->assertEquals($arr['difficulty'], $parametersAsArray['difficulty']);
        
    }
}
