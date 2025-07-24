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
        return $this->render('project/index.html.twig', [
            'projects' => $projectRepository->findAll(),
        ]);
    }

    #[Route(path: RoutesEnum::app_project_show->value, name: RoutesEnum::app_project_show->name, methods: [Request::METHOD_GET])]
    public function show(Project $project): Response
    {
        return $this->render('project/show.html.twig', [
            'project' => $project,
        ]);
    }
}
