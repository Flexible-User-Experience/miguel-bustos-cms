<?php

namespace App\Controller\Frontend;

use App\Enum\LocaleEnum;
use App\Enum\RoutesEnum;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomepageController extends AbstractController
{
    #[Route(
        path: RoutesEnum::app_frontend_homepage->value,
        name: RoutesEnum::app_frontend_homepage->name,
        methods: [Request::METHOD_GET]
    )]
    public function homepage(ProjectRepository $projectRepository): Response
    {
        return $this->render('frontend/homepage.html.twig', [
            'projects' => $projectRepository->findActiveSortedByPositionAndTitle(),
        ]);
    }

    #[Route(
        path: [
            LocaleEnum::en => RoutesEnum::app_contact->value,
            LocaleEnum::es => RoutesEnum::app_contact_es->value,
            LocaleEnum::ca => RoutesEnum::app_contact_ca->value,
        ],
        name: RoutesEnum::app_contact->name,
        methods: [Request::METHOD_GET, Request::METHOD_POST]
    )]
    public function contact(): Response
    {
        return $this->render('frontend/contact.html.twig');
    }

    #[Route(
        path: [
            LocaleEnum::en => RoutesEnum::app_about_me->value,
            LocaleEnum::es => RoutesEnum::app_about_me_es->value,
            LocaleEnum::ca => RoutesEnum::app_about_me_ca->value,
        ],
        name: RoutesEnum::app_about_me->name,
        methods: [Request::METHOD_GET]
    )]
    public function aboutMe(
        Request $request,
    ): Response
    {
        return $this->render(sprintf('frontend/about_me_%s.html.twig', $request->getLocale()));
    }
}
