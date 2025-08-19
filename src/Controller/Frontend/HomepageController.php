<?php

namespace App\Controller\Frontend;

use App\Entity\ContactMessage;
use App\Enum\LocaleEnum;
use App\Enum\RoutesEnum;
use App\Form\Type\ContactMessageFormType;
use App\Kernel;
use App\Repository\ContactMessageRepository;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
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
    public function contact(Request $request, ContactMessageRepository $cmr, KernelInterface $kernel): Response
    {
        $contactMessage = new ContactMessage();
        $form = $this->createForm(ContactMessageFormType::class, $contactMessage);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (Kernel::DEV_ENV === $kernel->getEnvironment()) { // TODO remove this when in production
                $cmr->add(
                    entity: $contactMessage,
                    flush: true
                );
                // TODO send email to admin
                $this->addFlash('success', 'Your message has been sent successfully!');
            }

            return $this->redirectToRoute(RoutesEnum::app_contact->name, [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('frontend/contact.html.twig', [
            'form' => $form,
        ]);
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
    public function aboutMe(): Response
    {
        return $this->render('frontend/about_me.html.twig');
    }
}
