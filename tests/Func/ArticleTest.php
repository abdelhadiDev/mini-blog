<?php
declare(strict_types=1);

namespace App\Tests\Func;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Faker\Factory;
use App\Repository\UserRepository;

class ArticleTest extends AbstractEndPoint 
{
    private string $payload = '{"name" : "%s", "content" : "%s", "author" : "%s"}';

    public function testGetAritcles():void
    {
        $response = $this->getResponseFromRequest(Request::METHOD_GET, '/api/articles');

        $responseContent = $response->getContent();
        $responseDecoded = json_decode($responseContent);

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);
    }
}