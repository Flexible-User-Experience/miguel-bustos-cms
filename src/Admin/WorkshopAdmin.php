<?php

namespace App\Admin;

use App\Enum\DoctrineEnum;
use Sonata\AdminBundle\Admin\AbstractAdmin;
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

final class WorkshopAdmin extends AbstractAdmin
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
            ->add('title', TextType::class, [
                'label' => 'Título',
                'required' => true,
            ])
            ->add('subtitle', TextType::class, [
                'label' => 'Subtítulo',
                'required' => false,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Descripción',
                'required' => false,
            ])
            ->add('mainImageFile', VichImageType::class, [
                'label' => 'Imagen destacada',
                'required' => true,
            ])
            ->add('images', CollectionType::class, [
                'label' => 'Imagenes',
                'by_reference' => false,
                'error_bubbling' => true,
            ], [
                'edit' => 'inline',
                'inline' => 'table',
            ])
            ->add('isActive', BooleanType::class, [
                'label' => 'Publicado',
                'required' => false,
                'transform' => true,
            ])
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