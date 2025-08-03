<?php

namespace App\Admin;

use App\Entity\Category;
use App\Enum\DoctrineEnum;
use Sonata\AdminBundle\Datagrid\DatagridInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\Form\Type\CollectionType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\Form\Type\BooleanType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Vich\UploaderBundle\Form\Type\VichImageType;

final class ProjectAdmin extends AbstractBaseAdmin
{
    public function generateBaseRoutePattern(bool $isChildAdmin = false): string
    {
        return 'projects/project';
    }

    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues[DatagridInterface::PAGE] = 1;
        $sortValues[DatagridInterface::SORT_ORDER] = DoctrineEnum::ASC->value;
        $sortValues[DatagridInterface::SORT_BY] = 'name';
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->with('admin.general', ['class' => 'col-md-4'])
                ->add('category', ModelType::class, [
                    'class' => Category::class,
                    'required' => false,
                ])
                ->add('title', TextType::class, [
                ])
                ->add('subtitle', TextType::class, [
                    'required' => false,
                ])
                ->add('description', TextareaType::class, [
                    'required' => false,
                ])
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
                        'template' => 'backend/admin/cells/list/main_image_field.html.twig',
                    ]
                )
            )
            ->add('category')
            ->addIdentifier('title')
            ->add('isActive', 'boolean', [
                'editable' => true,
                'inverse' => false,
            ])
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                ]
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