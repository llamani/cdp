<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class TaskControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient([], [
            'PHP_AUTH_USER' => 'johndoe@example.com',
            'PHP_AUTH_PW'   => 'test',
        ]);
    }

    public function testUnauthorizedAccess()
    {
        $unauthClient = static::createClient();
        $unauthClient->request('GET', 'api/issues/3');
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $unauthClient->getResponse()->getStatusCode());
    }

    public function testAuthorizedAccess()
    {
        $this->client->request('GET', 'api/issues/3');
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testAddTask()
    {
        $arr = array('name' => 'test', 'description' => 'test', 'workload' => '1.0', 'status' => 'done', 'issue' => ['4', '6']);
        $jsonData = json_encode($arr);

        $this->client->request(
            'POST',
            '/api/task',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $jsonData
        );

        $responseContent = $this->client->getResponse()->getContent();
        $parametersAsArray = json_decode($responseContent, true);

        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
        $this->checkArrays($arr, $parametersAsArray);
        $this->updateTask($parametersAsArray['id']);
        $this->removeTask($parametersAsArray['id']);
    }

    private function updateTask($id)
    {
        $arr = array('name' => 'test2', 'description' => 'test2', 'workload' => '2.0', 'status' => 'todo', 'issue' => ['4']);
        $jsonData = json_encode($arr);

        $this->client->request(
            'PUT',
            "/api/task/{$id}",
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $jsonData
        );
        $responseContent = $this->client->getResponse()->getContent();
        $parametersAsArray = json_decode($responseContent, true);

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->checkArrays($arr, $parametersAsArray);
        $parametersAsArray = json_decode($responseContent, true);
    }

    private function removeTask($id)
    {
        $this->client->request('DELETE', "/api/task/{$id}");
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    private function checkArrays($arr, $parametersAsArray)
    {
        $this->assertEquals($arr['name'], $parametersAsArray['name']);
        $this->assertEquals($arr['description'], $parametersAsArray['description']);
        $this->assertEquals($arr['workload'], $parametersAsArray['workload']);
        $responseIssues = $parametersAsArray['issues'];
        $arrIssues = $arr['issue'];
        $this->assertEquals(count($arrIssues), count($responseIssues ));
        $i = 0;
        foreach ($responseIssues  as $issue) {
            $this->assertEquals($arr['issue'][$i], $issue['id']);
            $i++;
        }
    }
}
