<?php

namespace App\Controller\Frontend;

use App\Entity\Project;
use App\Enum\RoutesEnum;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProjectController extends AbstractController
{
    #[Route(path: RoutesEnum::app_project_index->value, name: RoutesEnum::app_project_index->name, methods: [Request::METHOD_GET])]
    public function index(ProjectRepository $projectRepository): Response
    {
        return $this->render('frontend/project/index.html.twig', [
            'projects' => $projectRepository->findAll(),
        ]);
    }

    #[Route(path: RoutesEnum::app_project_show->value, name: RoutesEnum::app_project_show->name, methods: [Request::METHOD_GET])]
    public function show(Project $project): Response
    {
        return $this->render('frontend/project/show.html.twig', [
            'project' => $project,
        ]);
    }

    #[Route(path: RoutesEnum::app_project_workshops_index->value, name: RoutesEnum::app_project_workshops_index->name, methods: [Request::METHOD_GET])]
    public function workshopsIndex(ProjectRepository $projectRepository): Response
    {
        return $this->render('frontend/project/workshops.html.twig', [
            'workshops' => $projectRepository->findWorkshops(),
        ]);
    }

    #[Route(path: RoutesEnum::app_project_illustrations_index->value, name: RoutesEnum::app_project_illustrations_index->name, methods: [Request::METHOD_GET])]
    public function illustrationsIndex(ProjectRepository $projectRepository): Response
    {
        return $this->render('frontend/project/illustrations.html.twig', [
            'illustrations' => $projectRepository->findIllustrations(),
        ]);
    }

}
