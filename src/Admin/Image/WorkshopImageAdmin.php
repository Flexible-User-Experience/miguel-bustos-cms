<?php

namespace App\Admin\Image;

use App\Entity\Workshop;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class WorkshopImageAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add(
                'workshop',
                EntityType::class,
                [
                    'required' => true,
                    'class' => Workshop::class,
                    'choice_label' => 'title',
//                    'query_builder' => $this->getRepositoriesManager()->getMor()->findAllSortedByNameQB(),
                    'attr' => [
                        'hidden' => true,
                    ],
                ]
            )
            ->add('mainImageFile', VichImageType::class, [
                'required' => false,
                'label' => 'Imagen',
            ]);
    }
}