<?php

namespace App\Admin;

use App\Entity\Category;
use App\Entity\Partner;
use App\Enum\DoctrineEnum;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\Form\Type\BooleanType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class ProjectAdmin extends AbstractAdmin
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
            ->add('title', TextType::class, [
                'label' => 'Título',
            ])
            ->add('subtitle', TextType::class, [
                'label' => 'Subtítulo',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Descripción',
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'label' => 'Categoria',
            ])
            ->add('partners', ModelType::class, [
                'class' => Partner::class,
                'multiple' => true,
                'label' => 'Colaboradores',
                'required' => false,
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
            ->add('category')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
            ])
            ->addIdentifier('title')
            ->add('subtitle')
            ->add('description')
            ->add('partners')
            ->add('isActive', 'boolean', [
                'label' => 'Publicado',
                'editable' => true,
                'inverse' => false,
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
            ->add('partners')
            ->add('isActive')
        ;
    }
}