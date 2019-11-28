<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class TestControllerTest extends WebTestCase
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
        $unauthClient->request('GET', 'api/tests/1');
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $unauthClient->getResponse()->getStatusCode());
    }

    public function testAuthorizedAccess()
    {
        $this->client->request('GET', 'api/tests/1');
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testAddTest()
    {
        $arr =  array(
            "name" => "test",
            "description" => "test",
            "type" => "unit",
            "status" => "success",
            "expectedResult" => "test",
            "obtainedResult" => "test",
            "testDate" => "23-11-2019",
            "testManagers" => ["1"],
            "project" => "1"
        );
        $jsonData = json_encode($arr);

        $this->client->request(
            'POST',
            '/api/test',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $jsonData
        );

        $responseContent = $this->client->getResponse()->getContent();
        $parametersAsArray = json_decode($responseContent, true);

        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
        $this->checkArrays($arr, $parametersAsArray);
        $this->updateTest($parametersAsArray['id']);
        $this->removeTest($parametersAsArray['id']);
    }

    private function updateTest($id)
    {
        $arr =  array(
            "name" => "test2",
            "description" => "test2",
            "type" => "ui",
            "status" => "fail",
            "expectedResult" => "test2",
            "obtainedResult" => "test1",
            "testDate" => "20-11-2019",
            "testManagers" => [],
            "project" => "1"
        );
        $jsonData = json_encode($arr);

        $this->client->request(
            'PUT',
            "/api/test/{$id}",
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

    private function removeTest($id)
    {
        $this->client->request('DELETE', "/api/test/{$id}");
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    private function checkArrays($arr, $parametersAsArray)
    {
        $date =  substr($parametersAsArray['testDate'], 0, 10);
        $dateArray = $this->createDate($arr['testDate']);

        $this->assertEquals($arr['name'], $parametersAsArray['name']);
        $this->assertEquals($arr['description'], $parametersAsArray['description']);
        $this->assertEquals($arr['type'], $parametersAsArray['type']);
        $this->assertEquals($arr['status'], $parametersAsArray['status']);
        $this->assertEquals($arr['expectedResult'], $parametersAsArray['expectedResult']);
        $this->assertEquals($arr['obtainedResult'], $parametersAsArray['obtainedResult']);
        $this->assertEquals($date, $dateArray);

        $responseTestManagers = $parametersAsArray['testManagers'];
        $arrTestManagers = $arr['testManagers'];
        $this->assertEquals(count($responseTestManagers), count($arrTestManagers));
        $i = 0;
        foreach ($responseTestManagers  as $testManager) {
            $this->assertEquals($arr['testManagers'][$i], $testManager['id']);
            $i++;
        }
    }

    private function createDate($date)
    {
        $dateDF = \date_create_from_format('d-m-Y', $date);
        return date_format($dateDF, 'Y-m-d');
    }
}
