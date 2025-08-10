<?php

namespace App\Tests\Controller\Admin;

use App\Enum\RoutesEnum;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryAdminControllerTest extends WebTestCase
{
    public function testSuccessPages(): void
    {
        $client = static::getAdminAuthenticatedClient();
        $client->request(Request::METHOD_GET, RoutesEnum::app_admin_category_list->value);
        self::assertResponseIsSuccessful();
        $client->request(Request::METHOD_GET, RoutesEnum::app_admin_category_create->value);
        self::assertResponseIsSuccessful();
        $client->request(Request::METHOD_GET, str_replace('{id}', '1', RoutesEnum::app_admin_category_edit->value));
        self::assertResponseIsSuccessful();
    }

    public function testForbiddenPages(): void
    {
        $client = static::getAdminAuthenticatedClient();
        $client->request(Request::METHOD_GET, str_replace('{id}', '100', RoutesEnum::app_admin_category_edit->value));
        self::assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
        $client->request(Request::METHOD_GET, 'admin/categories/category/1/delete');
        self::assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    public static function getAdminAuthenticatedClient(): KernelBrowser
    {
        return WebTestCase::createClient([], [
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'admin',
        ]);
    }
}
