<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class ReleaseControllerTest extends WebTestCase
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
        $unauthClient->request('GET', 'api/releases/1');
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $unauthClient->getResponse()->getStatusCode());
    }

    public function testAuthorizedAccess()
    {
        $this->client->request('GET', 'api/releases/1');
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testAddRelease()
    {
        $arr =  array(
            "name" => "test",
            "description" => "test",
            "src_link" => "test",
            "sprint" => "1",
        );

        $jsonData = json_encode($arr);

        $this->client->request(
            'POST',
            '/api/release',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $jsonData
        );

        $responseContent = $this->client->getResponse()->getContent();
        $parametersAsArray = json_decode($responseContent, true);

        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
        $this->checkArrays($arr, $parametersAsArray);
        $this->updateRelease($parametersAsArray['id']);
        $this->removeRelease($parametersAsArray['id']);
    }

    private function updateRelease($id)
    {
        $arr =  array(
            "name" => "test2",
            "description" => "test2",
            "release_date" => "23-11-2019",
            "src_link" => "test2",
            "sprint" => "1",
        );
        $jsonData = json_encode($arr);

        $this->client->request(
            'PUT',
            "/api/release/{$id}",
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

    private function removeRelease($id)
    {
        $this->client->request('DELETE', "/api/release/{$id}");
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    private function checkArrays($arr, $parametersAsArray)
    {
        $this->assertEquals($arr['name'], $parametersAsArray['name']);
        $this->assertEquals($arr['description'], $parametersAsArray['description']);
        $this->assertEquals($arr['src_link'], $parametersAsArray['srcLink']);
        $this->assertEquals($arr['sprint'], $parametersAsArray['sprint']['id']);
    }
}
