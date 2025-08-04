<?php

namespace App\Tests\Controller\Admin;

use App\Enum\RoutesEnum;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class CategoryAdminControllerTest extends WebTestCase
{
    public function testSuccessPages(): void
    {
        $client = static::getAdminAuthenticatedClient();
        $client->request(Request::METHOD_GET, RoutesEnum::app_admin_category_list->value);
        self::assertResponseIsSuccessful();
    }

    public static function getAdminAuthenticatedClient(): KernelBrowser
    {
        return WebTestCase::createClient([], [
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'admin',
        ]);
    }
}
