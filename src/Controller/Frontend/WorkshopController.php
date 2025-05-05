<?php

namespace App\Controller\Frontend;

use App\Entity\Workshop;
use App\Repository\WorkshopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/workshop')]
class WorkshopController extends AbstractController
{
    #[Route(name: 'app_workshop_index', methods: ['Request::METHOD_GET'])]
    public function index(WorkshopRepository $workshopRepository): Response
    {
        return $this->render('workshop/index.html.twig', [
            'workshops' => $workshopRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_workshop_show', methods: ['Request::METHOD_GET'])]
    public function show(Workshop $workshop): Response
    {
        return $this->render('workshop/show.html.twig', [
            'workshop' => $workshop,
        ]);
    }
}
