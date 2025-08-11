<?php

namespace App\EventSubscriber;

//use App\Entity\Service;
use App\Enum\LocaleEnum;
use App\Enum\RoutesEnum;
//use App\Repository\ServiceRepository;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final readonly class SitemapEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private UrlGeneratorInterface $router,
//        private ServiceRepository $sr,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            SitemapPopulateEvent::class => 'populate',
        ];
    }

    public function populate(SitemapPopulateEvent $event): void
    {
        $section = $event->getSection();
        if (is_null($section) || 'default' === $section) {
            // Locales iterator
            foreach (LocaleEnum::getLocalesArray() as $locale) {
                // Homepage
                $url = $this->makeUrl(RoutesEnum::app_frontend_homepage_index->name, $locale);
                $event
                    ->getUrlContainer()
                    ->addUrl($this->makeUrlConcrete($url), 'default')
                ;
                // Illustrations
                $url = $this->makeUrl(RoutesEnum::app_project_illustrations_index->name, $locale);
                $event
                    ->getUrlContainer()
                    ->addUrl($this->makeUrlConcrete($url), 'default')
                ;
                // Workshops
                $url = $this->makeUrl(RoutesEnum::app_project_workshops_index->name, $locale);
                $event
                    ->getUrlContainer()
                    ->addUrl($this->makeUrlConcrete($url), 'default')
                ;
                /** @var Service $service /
                foreach ($this->sr->getActiveAndShowInFrontendSortedByPosition() as $service) {
                    $url = $this->makeUrl(
                        RoutesEnum::app_web_service_detail_route,
                        $locale,
                        [
                            'slug' => $service->getSlug(),
                        ]
                    );
                    $event
                        ->getUrlContainer()
                        ->addUrl($this->makeUrlConcrete($url), 'default')
                    ;
                }
                // Other stuff
                $url = $this->makeUrl(RoutesEnum::app_web_contact_us_route, $locale);
                $event
                    ->getUrlContainer()
                    ->addUrl($this->makeUrlConcrete($url, 0.1), 'default')
                ;
                $url = $this->makeUrl(RoutesEnum::app_web_privacy_policy_route, $locale);
                $event
                    ->getUrlContainer()
                    ->addUrl($this->makeUrlConcrete($url, 0.1), 'default')
                ;
                 */
            }
        }
    }

    private function makeUrl(string $routeName, string $locale = LocaleEnum::ca, ?array $params = null): string
    {
        $baseParams = [
            '_locale' => $locale,
        ];
        if ($params) {
            $baseParams = array_merge($baseParams, $params);
        }

        return $this->router->generate(
            $routeName,
            $baseParams,
            UrlGeneratorInterface::ABSOLUTE_URL
        );
    }

    private function makeUrlConcrete(string $url, int $priority = 1, ?\DateTimeInterface $date = null): UrlConcrete
    {
        return new UrlConcrete(
            $url,
            $date ?? new \DateTimeImmutable(),
            UrlConcrete::CHANGEFREQ_WEEKLY,
            $priority
        );
    }
}
