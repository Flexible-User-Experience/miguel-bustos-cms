<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;

class AbstractBaseAdmin extends AbstractAdmin
{
    protected function isFormToCreateNewRecord(): bool
    {
        return !$this->id($this->getSubject());
    }
}