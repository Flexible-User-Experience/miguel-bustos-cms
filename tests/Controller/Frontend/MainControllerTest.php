<?php

namespace App\Tests\Controller\Frontend;

use App\Enum\RoutesEnum;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class MainControllerTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, RoutesEnum::app_frontend_homepage_index->value);
        self::assertResponseIsSuccessful();
        $client->request(Request::METHOD_GET, RoutesEnum::app_project_index->value);
        self::assertResponseIsSuccessful();
    }
}
