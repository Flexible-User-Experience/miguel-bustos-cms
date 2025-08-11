<?php

namespace App\Controller\Frontend;

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
            'projects' => $projectRepository->findByIsActiveField(),
        ]);
    }
}
