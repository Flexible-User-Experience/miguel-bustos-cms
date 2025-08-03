<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;

class AbstractBaseAdmin extends AbstractAdmin
{
    protected function isFormToCreateNewRecord(): bool
    {
        return !$this->id($this->getSubject());
    }

    public static function get60x60CenteredImageNotEditableListFieldDescriptionOptionsArray(): array
    {
        return [
            'header_style' => 'width:60px',
            'header_class' => 'text-center',
            'row_align' => 'center',
            'editable' => false,
        ];
    }

}