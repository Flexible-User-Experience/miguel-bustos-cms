<?php

namespace App\EventSubscriber;

use App\Entity\Project;
use App\Enum\LocaleEnum;
use App\Enum\RoutesEnum;
use App\Repository\ProjectRepository;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final readonly class SitemapEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private UrlGeneratorInterface $router,
        private ProjectRepository $pr,
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
            foreach (LocaleEnum::getLocalesArray() as $locale) {
                // homepage
                $url = $this->makeUrl(RoutesEnum::app_frontend_homepage->name, $locale);
                $event
                    ->getUrlContainer()
                    ->addUrl($this->makeUrlConcrete($url), 'default')
                ;
                // illustrations
                $url = $this->makeUrl(RoutesEnum::app_project_illustrations->name, $locale);
                $event
                    ->getUrlContainer()
                    ->addUrl($this->makeUrlConcrete($url), 'default')
                ;
                // workshops
                $url = $this->makeUrl(RoutesEnum::app_project_workshops->name, $locale);
                $event
                    ->getUrlContainer()
                    ->addUrl($this->makeUrlConcrete($url), 'default')
                ;
                // projects
                /* @var Project $project */
                foreach ($this->pr->findActiveSortedByPositionAndTitle() as $project) {
                    $url = $this->makeUrl(
                        RoutesEnum::app_project_detail->name,
                        $locale,
                        [
                            'slug' => $project->getSlug(),
                        ]
                    );
                    $event
                        ->getUrlContainer()
                        ->addUrl($this->makeUrlConcrete($url), 'default')
                    ;
                }
                // other pages
                $url = $this->makeUrl(RoutesEnum::app_contact->name, $locale);
                $event
                    ->getUrlContainer()
                    ->addUrl($this->makeUrlConcrete($url), 'default')
                ;
                $url = $this->makeUrl(RoutesEnum::app_about_me->name, $locale);
                $event
                    ->getUrlContainer()
                    ->addUrl($this->makeUrlConcrete($url), 'default')
                ;
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
