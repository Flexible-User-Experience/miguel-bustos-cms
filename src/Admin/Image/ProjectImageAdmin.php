<?php

namespace App\Admin\Image;

use App\Admin\AbstractBaseAdmin;
use App\Entity\Project;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProjectImageAdmin extends AbstractBaseAdmin
{
    public function generateBaseRoutePattern(bool $isChildAdmin = false): string
    {
        return 'projects/image';
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add(
                'project',
                EntityType::class,
                [
                    'required' => true,
                    'class' => Project::class,
                    'choice_label' => 'title',
                    'attr' => [
                        'hidden' => true,
                    ],
                ]
            )
            ->add(
                'mainImageFile',
                VichImageType::class,
                [
                    'required' => false,
                ]
            )
            // TODO add ALT field
        ;
    }
}
