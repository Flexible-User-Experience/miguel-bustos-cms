<?php

namespace App\Tests\Controller\Admin;

use App\Enum\RoutesEnum;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class ServiceControllerTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = ContactMessageControllerTest::getAdminAuthenticatedClient();
        $client->request(Request::METHOD_GET, sprintf('/admin/%s/list', RoutesEnum::app_admin_service_path));
        self::assertResponseIsSuccessful();
        $client->request(Request::METHOD_GET, sprintf('/admin/%s/1/delete', RoutesEnum::app_admin_service_path));
        self::assertResponseIsSuccessful();
        $client->request(Request::METHOD_GET, sprintf('/admin/%s/1/edit', RoutesEnum::app_admin_service_path));
        self::assertResponseIsSuccessful();
    }
}
