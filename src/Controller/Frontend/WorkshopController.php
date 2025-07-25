<?php

namespace App\Controller\Frontend;

use App\Entity\Workshop;
use App\Enum\RoutesEnum;
use App\Repository\WorkshopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WorkshopController extends AbstractController
{
    #[Route(path: RoutesEnum::app_workshop_index->value, name: RoutesEnum::app_workshop_index->name,  methods: [Request::METHOD_GET])]
    public function index(WorkshopRepository $workshopRepository): Response
    {
        return $this->render('frontend/workshop/index.html.twig', [
            'workshops' => $workshopRepository->findAll(),
        ]);
    }

    #[Route(path: RoutesEnum::app_workshop_show->value, name: RoutesEnum::app_workshop_show->name,  methods: [Request::METHOD_GET])]
    public function show(Workshop $workshop): Response
    {
        return $this->render('frontend/workshop/show.html.twig', [
            'workshop' => $workshop,
        ]);
    }
}
