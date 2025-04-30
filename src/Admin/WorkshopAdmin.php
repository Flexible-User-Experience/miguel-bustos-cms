<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;

final class WorkshopAdmin extends AbstractAdmin
{
    public function generateBaseRoutePattern(bool $isChildAdmin = false): string
    {
        return 'workshops/workshop';
    }

}