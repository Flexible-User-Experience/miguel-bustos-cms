<?php

namespace App\Tests\Controller\Frontend;

use App\Enum\RoutesEnum;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class MainControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private array $fullLocalesArray;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->fullLocalesArray = self::getContainer()->getParameter('locale_i18n_full');
    }

    public function testSuccessPages(): void
    {
        foreach ($this->fullLocalesArray as $locale) {
            $this->client->request(Request::METHOD_GET, RoutesEnum::app_admin_login->value, ['_locale' => $locale]);
            self::assertResponseIsSuccessful();
            $this->client->request(Request::METHOD_GET, RoutesEnum::app_frontend_homepage->value, ['_locale' => $locale]);
            self::assertResponseIsSuccessful();
            $this->client->request(Request::METHOD_GET, RoutesEnum::app_contact->value, ['_locale' => $locale]);
            self::assertResponseIsSuccessful();
            $this->client->request(Request::METHOD_GET, RoutesEnum::app_about_me->value, ['_locale' => $locale]);
            self::assertResponseIsSuccessful();
            $this->client->request(Request::METHOD_GET, RoutesEnum::app_project_illustrations->value, ['_locale' => $locale]);
            self::assertResponseIsSuccessful();
            $this->client->request(Request::METHOD_GET, RoutesEnum::app_project_workshops->value, ['_locale' => $locale]);
            self::assertResponseIsSuccessful();
            $this->client->request(Request::METHOD_GET, str_replace('{slug}', 'project-1', RoutesEnum::app_project_detail->value), ['_locale' => $locale]);
            self::assertResponseIsSuccessful();
        }
        $this->client->request(Request::METHOD_GET, '/sitemap.xml');
        self::assertResponseIsSuccessful();
        $this->client->request(Request::METHOD_GET, '/sitemap.default.xml');
        self::assertResponseIsSuccessful();
    }

    public function testForbiddenPages(): void
    {
        $this->client->request(Request::METHOD_GET, str_replace('{slug}', 'project-21', RoutesEnum::app_project_detail->value));
        self::assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }
}
