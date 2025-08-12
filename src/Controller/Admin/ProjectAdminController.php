<?php

namespace App\Controller\Admin;

use App\Enum\RoutesEnum;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProjectAdminController extends CRUDController
{
    public function showAction(Request $request): Response
    {
        return $this->redirectToRoute(RoutesEnum::app_project_detail->name, [
            'slug' => $this->admin->getSubject()->getSlug(),
        ]);
    }
}
