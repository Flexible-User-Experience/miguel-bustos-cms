<?php

namespace App\Admin\Image;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Vich\UploaderBundle\Form\Type\VichImageType;

class WorkshopImageAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'label' => 'Imagen',
            ]);
    }
}