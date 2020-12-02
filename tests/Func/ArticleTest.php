<?php
declare(strict_types=1);

namespace App\Tests\Func;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Faker\Factory;
use App\Repository\UserRepository;
use Exception;

class ArticleTest extends AbstractEndPoint 
{
    private string $payload = '{"name" : "%s", "content" : "%s", "author" : "%s", "statut": true, "age": 22}';

    public function testGetAritcles():void
    {
        $response = $this->getResponseFromRequest(
            Request::METHOD_GET, 
            '/api/articles',
            '',
            [],
            false
        );

        $responseContent = $response->getContent();
        $responseDecoded = json_decode($responseContent);

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);
    }

    /*public function testGetAritcle(array $res): void
    {
        if (0 === count($res)) {
            throw new Exception("Use this command => bin/console d:f:l (no data found)", 404);
        }

        $response = $this->getResponseFromRequest(
            Request::METHOD_GET,
            '/api/articles/'.$res[0]->id
        );

        $responseContent = $response->getContent();
        $responseDecoded = json_decode($responseContent, true);

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);
        self::assertNotSame($res[0], $responseDecoded);
        self::assertContains("author", $responseContent);
    }*/
}