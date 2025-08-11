<?php

namespace App\Tests\Controller\Frontend;

use App\Enum\RoutesEnum;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class MainControllerTest extends WebTestCase
{
    public function testSuccessPages(): void
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, RoutesEnum::app_admin_login->value);
        self::assertResponseIsSuccessful();
        $client->request(Request::METHOD_GET, RoutesEnum::app_frontend_homepage->value);
        self::assertResponseIsSuccessful();
        $client->request(Request::METHOD_GET, RoutesEnum::app_project_illustrations->value);
        self::assertResponseIsSuccessful();
        $client->request(Request::METHOD_GET, RoutesEnum::app_project_workshops->value);
        self::assertResponseIsSuccessful();
        $client->request(Request::METHOD_GET, str_replace('{id}', '1', RoutesEnum::app_project_detail->value));
        self::assertResponseIsSuccessful();
        $client->request(Request::METHOD_GET, '/sitemap.xml');
        self::assertResponseIsSuccessful();
        $client->request(Request::METHOD_GET, '/sitemap.default.xml');
        self::assertResponseIsSuccessful();
    }
}
