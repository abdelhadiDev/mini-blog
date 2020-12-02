<?php
declare(strict_types=1);

namespace App\Tests\Func;

use App\DataFixtures\AppFixtures;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractEndPoint extends WebTestCase 
{
    protected array $serverInformations = ['Accept' => 'application/json', 'CONTENT_TYPE' => 'application/json'];
    protected string $tokenNotFound = 'JWT Token not found';
    protected string $notYourRessource = 'It\'s not your ressource';
    protected string $loginPayload = '{"username": "%s", "password": "%s"}';
    
    public function getResponseFromRequest(
        string $method, 
        string $uri, 
        string $payload = '',
        array $parameters = [],
        bool $withAuthentification = true
        ): Response {

        $client = $this->createAuthentificationClient($withAuthentification);

        $client->request(
            $method, 
            $uri .'.json',
            $parameters,
            [],
            $this->serverInformations,
            $payload
        );

        //dd($client);
        
        return $client->getResponse();
    }

    protected function createAuthentificationClient(bool $withAuthentification): KernelBrowser
    {
        $client = static::createClient();

        if (!$withAuthentification) {
            return $client;
        }

        $client->request(
            Request::METHOD_POST, 
            '/api/login_check',
            [],
            [],
            $this->serverInformations,
            sprintf($this->loginPayload, AppFixtures::DEFAULT_USER['email'], AppFixtures::DEFAULT_USER['password'])
        );

        $data = json_decode($client->getResponse()->getContent(), true);

        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

        return $client;
    }

}