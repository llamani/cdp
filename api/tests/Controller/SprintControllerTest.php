<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class SprintControllerTest extends WebTestCase
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
        $unauthClient->request('GET', 'api/sprints/1');
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $unauthClient->getResponse()->getStatusCode());
    }

    public function testAuthorizedAccess()
    {
        $this->client->request('GET', 'api/sprints/1');
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testAddSprint()
    {
        $arr = array("startDate" => "25-11-2019", "endDate" => "06-12-2019", "issue" => ["1", "2"], "project" => "1");
        $jsonData = json_encode($arr);

        $this->client->request(
            'POST',
            '/api/sprint',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $jsonData
        );

        $responseContent = $this->client->getResponse()->getContent();
        $parametersAsArray = json_decode($responseContent, true);


        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
        $this->checkArrays($arr, $parametersAsArray);
        $this->updateSprint($parametersAsArray['id']);
        $this->removeSprint($parametersAsArray['id']);
    }

    private function updateSprint($id)
    {
        $arr = array("startDate" => "11-11-2019", "endDate" => "23-11-2019", "issue" => ["1"], "project" => "1");
        $jsonData = json_encode($arr);

        $this->client->request(
            'PUT',
            "/api/sprint/{$id}",
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

    private function removeSprint($id)
    {
        $this->client->request('DELETE', "/api/sprint/{$id}");
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    private function checkArrays($arr, $parametersAsArray)
    {
        $startDateResponse =  substr($parametersAsArray['startDate'], 0, 10);
        $startDateArray = $this->createDate($arr['startDate']);
        $this->assertEquals($startDateResponse, $startDateArray);

        $endDateResponse =  substr($parametersAsArray['endDate'], 0, 10);
        $endDateArray = $this->createDate($arr['endDate']);
        $this->assertEquals($endDateResponse, $endDateArray);

        $responseIssues = $parametersAsArray['issues'];
        $arrIssues = $arr['issue'];
        $this->assertEquals(count($arrIssues), count($responseIssues));
        $i = 0;
        foreach ($responseIssues  as $issue) {
            $this->assertEquals($arr['issue'][$i], $issue['id']);
            $i++;
        }
    }

    private function createDate($date)
    {
        $dateDF = \date_create_from_format('d-m-Y', $date);
        return date_format($dateDF, 'Y-m-d');
    }
}
