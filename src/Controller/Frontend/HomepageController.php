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
    #[Route(path: RoutesEnum::app_frontend_homepage_index->value, name: RoutesEnum::app_frontend_homepage_index->name, methods: [Request::METHOD_GET])]
    public function index(ProjectRepository $projectRepository): Response
    {
        return $this->render('frontend/homepage.html.twig', [
            // TODO: Filtrar projectes segons estat: actiu...
            'projects' => $projectRepository->findByIsActiveField(),
        ]);
    }
}
