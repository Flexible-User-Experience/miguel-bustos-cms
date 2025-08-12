<?php

namespace App\Controller\Frontend;

use App\Entity\Project;
use App\Enum\LocaleEnum;
use App\Enum\RoutesEnum;
use App\Repository\ProjectRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProjectController extends AbstractController
{
    #[Route(
        path: [
            LocaleEnum::en => RoutesEnum::app_project_illustrations->value,
            LocaleEnum::es => RoutesEnum::app_project_illustrations_es->value,
            LocaleEnum::ca => RoutesEnum::app_project_illustrations_ca->value,
        ],
        name: RoutesEnum::app_project_illustrations->name,
        methods: [Request::METHOD_GET]
    )]
    public function illustrations(ProjectRepository $projectRepository): Response
    {
        return $this->render('frontend/project/illustrations.html.twig', [
            'projects' => $projectRepository->findIllustrations(),
        ]);
    }

    #[Route(
        path: [
            LocaleEnum::en => RoutesEnum::app_project_workshops->value,
            LocaleEnum::es => RoutesEnum::app_project_workshops_es->value,
            LocaleEnum::ca => RoutesEnum::app_project_workshops_ca->value,
        ],
        name: RoutesEnum::app_project_workshops->name,
        methods: [Request::METHOD_GET]
    )]
    public function workshops(ProjectRepository $projectRepository): Response
    {
        return $this->render('frontend/project/workshops.html.twig', [
            'projects' => $projectRepository->findWorkshops(),
        ]);
    }

    #[Route(
        path: [
            LocaleEnum::en => RoutesEnum::app_project_detail->value,
            LocaleEnum::es => RoutesEnum::app_project_detail_es->value,
            LocaleEnum::ca => RoutesEnum::app_project_detail_ca->value,
        ],
        name: RoutesEnum::app_project_detail->name,
        methods: [Request::METHOD_GET]
    )]
    public function detail(
        #[MapEntity(mapping: ['slug' => 'slug'])] Project $project,
        ProjectRepository $projectRepository,
    ): Response {
        if (false === $project->getIsActive()) {
            throw $this->createNotFoundException();
        }

        return $this->render('frontend/project/detail.html.twig', [
            'project' => $project,
            'projects' => $projectRepository->findByIsActiveField(),
        ]);
    }
}
