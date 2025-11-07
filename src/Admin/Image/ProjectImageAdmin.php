<?php

namespace App\Admin\Image;

use App\Admin\AbstractBaseAdmin;
use App\Entity\Project;
use App\Enum\DoctrineEnum;
use Sonata\AdminBundle\Datagrid\DatagridInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\DoctrineORMAdminBundle\Filter\ModelFilter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProjectImageAdmin extends AbstractBaseAdmin
{
    public function generateBaseRoutePattern(bool $isChildAdmin = false): string
    {
        return 'projects/image';
    }

    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues[DatagridInterface::PAGE] = 1;
        $sortValues[DatagridInterface::SORT_ORDER] = DoctrineEnum::ASC->value;
        $sortValues[DatagridInterface::SORT_BY] = 'project.position';
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        parent::configureRoutes($collection);
        $collection->remove('batch');
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
                    'required' => $this->isFormToCreateNewRecord(),
                    'help' => 'Secondary Image File Helper',
                ]
            )
            ->add(
                'altImageText',
                TextType::class,
                [
                    'required' => true,
                ]
            )
            ->add(
                'position',
                NumberType::class,
                [
                    'required' => true,
                ]
            )
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add(
                'project',
                ModelFilter::class,
                [
                    'field_options' => [
                        'class' => Project::class,
                        'choice_label' => 'title',
                        'query_builder' => $this->getEntityManager()->getRepository(Project::class)->findAllSortedByPositionAndTitleQB(),
                    ],
                ]
            )
            ->add('altImageText')
            ->add('caption')
            ->add('position')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add(
                'project',
                FieldDescriptionInterface::TYPE_MANY_TO_ONE,
                [
                    'editable' => false,
                    'sortable' => true,
                    'associated_property' => 'title',
                    'route' => [
                        'name' => 'edit',
                    ],
                    'sort_field_mapping' => [
                        'fieldName' => 'altImageText',
                    ],
                    'sort_parent_association_mappings' => [
                        [
                            'fieldName' => 'project',
                        ],
                    ],
                ]
            )
            ->add(
                'main image',
                FieldDescriptionInterface::TYPE_HTML,
                array_merge(
                    AbstractBaseAdmin::get60x60CenteredImageNotEditableListFieldDescriptionOptionsArray(),
                    [
                        'label' => 'Extra Picture',
                        'template' => 'admin/cells/list/project_image_field.html.twig',
                    ]
                )
            )
            ->add(
                'altImageText',
                null,
                [
                    'editable' => true,
                ]
            )
            ->add(
                'caption',
                null,
                [
                    'editable' => true,
                ]
            )
            ->add(
                'position',
                null,
                [
                    'header_class' => 'text-right',
                    'row_align' => 'right',
                ]
            )
            ->add(
                ListMapper::NAME_ACTIONS,
                ListMapper::TYPE_ACTIONS,
                [
                    'header_style' => 'width:186px',
                    'header_class' => 'text-right',
                    'row_align' => 'right',
                    'actions' => [
                        'edit' => [],
                        'delete' => [],
                    ],
                ]
            )
        ;
    }
}
