<?php

namespace App\Admin;

use App\Entity\Category;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\Form\Type\BooleanType;
use Sonata\Form\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Vich\UploaderBundle\Form\Type\VichImageType;

final class ProjectAdmin extends AbstractBaseAdmin
{
    public function generateBaseRoutePattern(bool $isChildAdmin = false): string
    {
        return 'projects/project';
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->with('admin.general', ['class' => 'col-md-4'])
            ->add(
                'category',
                ModelType::class,
                [
                    'class' => Category::class,
                    'required' => false,
                ]
            )
            ->add(
                'title',
                TextType::class,
                [
                    'required' => true,
                ]
            )
            ->add(
                'subtitle',
                TextType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'description',
                TextareaType::class,
                [
                    'required' => false,
                ]
            )
            ->end()
            ->with('admin.images', ['class' => 'col-md-4'])
                ->add('mainImageFile', VichImageType::class, [
                    'required' => false,
                ]);
        if (!$this->isFormToCreateNewRecord()) {
            $form
                ->add('images', CollectionType::class, [
                    'by_reference' => false,
                    'error_bubbling' => true,
                ], [
                    'edit' => 'inline',
                    'inline' => 'table',
                ]);
        }
        $form
            ->end()
            ->with('admin.controls', ['class' => 'col-md-4'])
                ->add('isIllustration', BooleanType::class, [
                    'required' => false,
                    'transform' => true,
                ])
                ->add('isWorkshop', BooleanType::class, [
                    'required' => false,
                    'transform' => true,
                ])
                ->add('isActive', BooleanType::class, [
                    'required' => false,
                    'transform' => true,
                ])
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('title')
            ->add('category')
            ->add('isActive')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add(
                'main image',
                FieldDescriptionInterface::TYPE_HTML,
                array_merge(
                    AbstractBaseAdmin::get60x60CenteredImageNotEditableListFieldDescriptionOptionsArray(),
                    [
                        'template' => 'admin/cells/list/main_image_field.html.twig',
                    ]
                )
            )
            ->add('category')
            ->addIdentifier('title')
            ->add('isIllustration', FieldDescriptionInterface::TYPE_BOOLEAN, [
                'editable' => true,
            ])
            ->add('isWorkshop', FieldDescriptionInterface::TYPE_BOOLEAN, [
                'editable' => true,
            ])
            ->add('isActive', FieldDescriptionInterface::TYPE_BOOLEAN, [
                'editable' => true,
                'inverse' => false,
            ])
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                ],
            ])
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('category')
            ->add('title')
            ->add('subtitle')
            ->add('description')
            ->add('mainImageFile')
            ->add('isActive')
        ;
    }
}
