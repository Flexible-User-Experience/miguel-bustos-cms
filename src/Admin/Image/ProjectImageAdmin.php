<?php

namespace App\Admin\Image;

use App\Entity\Project;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProjectImageAdmin extends AbstractAdmin
{
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
//                    'query_builder' => $this->getRepositoriesManager()->getMor()->findAllSortedByNameQB(),
                    'attr' => [
                        'hidden' => true,
                    ],
                ]
            )
            ->add('mainImageFile', VichImageType::class, [
                'required' => false,
            ]);
    }
}