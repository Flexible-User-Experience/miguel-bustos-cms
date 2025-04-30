<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;

final class PartnerAdmin extends AbstractAdmin
{
    public function generateBaseRoutePattern(bool $isChildAdmin = false): string
    {
        return 'projects/partner';
    }

}