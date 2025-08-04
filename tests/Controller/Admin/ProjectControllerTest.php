<?php

namespace App\Tests\Controller\Admin;

use App\Enum\RoutesEnum;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class ProjectControllerTest extends WebTestCase
{
    public function testSuccessPages(): void
    {
        $client = CategoryAdminControllerTest::getAdminAuthenticatedClient();
        $client->request(Request::METHOD_GET, RoutesEnum::app_admin_project_list->value);
        self::assertResponseIsSuccessful();
    }
}
