<?php

namespace App\Admin;

use App\Enum\DoctrineEnum;
use Sonata\AdminBundle\Datagrid\DatagridInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\Form\Type\BooleanType;
use Sonata\Form\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Vich\UploaderBundle\Form\Type\VichImageType;

final class WorkshopAdmin extends AbstractBaseAdmin
{
    public function generateBaseRoutePattern(bool $isChildAdmin = false): string
    {
        return 'workshops/workshop';
    }

    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues[DatagridInterface::PAGE] = 1;
        $sortValues[DatagridInterface::SORT_ORDER] = DoctrineEnum::DESC->value;
        $sortValues[DatagridInterface::SORT_BY] = 'startsAt';
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->with('admin.general', ['class' => 'col-md-4'])
                ->add('title', TextType::class, [
                    'required' => true,
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
            ->add('price')
            ->add('startsAt')
            ->add('endsAt')
            ->add('isActive')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->addIdentifier('title')
            ->add('isActive', 'boolean', [
                'label' => 'Publicado',
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
            ->add('title')
            ->add('subtitle')
            ->add('description')
            ->add('mainImageFile')
            ->add('isActive')
        ;
    }

}