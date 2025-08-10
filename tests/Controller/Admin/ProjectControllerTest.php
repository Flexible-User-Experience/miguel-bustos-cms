<?php

namespace App\Tests\Controller\Admin;

use App\Enum\RoutesEnum;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProjectControllerTest extends WebTestCase
{
    public function testSuccessPages(): void
    {
        $client = CategoryAdminControllerTest::getAdminAuthenticatedClient();
        $client->request(Request::METHOD_GET, RoutesEnum::app_admin_project_list->value);
        self::assertResponseIsSuccessful();
        $client->request(Request::METHOD_GET, RoutesEnum::app_admin_project_create->value);
        self::assertResponseIsSuccessful();
        $client->request(Request::METHOD_GET, str_replace('{id}', '1', RoutesEnum::app_admin_project_edit->value));
        self::assertResponseIsSuccessful();
    }

    public function testForbiddenPages(): void
    {
        $client = CategoryAdminControllerTest::getAdminAuthenticatedClient();
        $client->request(Request::METHOD_GET, str_replace('{id}', '100', RoutesEnum::app_admin_project_edit->value));
        self::assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
        $client->request(Request::METHOD_GET, 'admin/projects/project/1/delete');
        self::assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }
}
