<?php

namespace App\Admin;

use App\Entity\Category;
use App\Entity\Translations\CategoryTranslation;
use App\Enum\DoctrineEnum;
use App\Form\Type\GedmoTranslationsType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\DatagridInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Filter\ModelFilter;
use Sonata\Form\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Vich\UploaderBundle\Form\Type\VichImageType;

final class ProjectAdmin extends AbstractBaseAdmin
{
    private const int TEXTAREA_ROWS = 10;

    public function generateBaseRoutePattern(bool $isChildAdmin = false): string
    {
        return 'projects/project';
    }

    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues[DatagridInterface::PAGE] = 1;
        $sortValues[DatagridInterface::SORT_ORDER] = DoctrineEnum::ASC->value;
        $sortValues[DatagridInterface::SORT_BY] = 'position';
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->with('admin.main_image', ['class' => 'col-md-4', 'label' => 'Images'])
            ->add(
                'mainImageFile',
                VichImageType::class,
                [
                    'label' => 'admin.main_image',
                    'required' => $this->isFormToCreateNewRecord(),
                    'help' => 'Main Image File Helper',
                ]
            )
            ->add(
                'awardImageFile',
                VichImageType::class,
                [
                    'label' => 'admin.award_image',
                    'required' => false,
                    'help' => 'Main Image File Helper',
                ]
            )
            ->add(
                'awardImageFile2',
                VichImageType::class,
                [
                    'label' => 'admin.award_image_2',
                    'required' => false,
                    'help' => 'Main Image File Helper',
                ]
            )
            ->end()
            ->with('admin.general', ['class' => 'col-md-4'])
            ->add(
                'category',
                EntityType::class,
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
                CKEditorType::class,
                [
                    'required' => false,
                    'attr' => [
                        'rows' => self::TEXTAREA_ROWS,
                    ],
                ]
            )
            ->add(
                'ctaButtonLabel',
                TextType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'ctaButtonLink',
                UrlType::class,
                [
                    'required' => false,
                    'help' => 'Cta Button Link Help',
                ]
            )
            ->end()
            ->with('admin.translations', [
                'class' => 'col-md-4',
                'description' => 'admin.translations_help',
            ])
            ->add(
                'translations',
                GedmoTranslationsType::class,
                [
                    'label' => false,
                    'required' => false,
                    'translatable_class' => CategoryTranslation::class,
                    'fields' => [
                        'title' => [
                            'required' => true,
                            'field_type' => TextType::class,
                        ],
                        'subtitle' => [
                            'required' => false,
                            'field_type' => TextType::class,
                        ],
                        'description' => [
                            'required' => false,
                            'field_type' => CKEditorType::class,
                            'attr' => [
                                'rows' => self::TEXTAREA_ROWS,
                            ],
                        ],
                        'ctaButtonLabel' => [
                            'required' => false,
                            'label' => 'Cta Button Label',
                            'field_type' => TextType::class,
                        ],
                        'caption' => [
                            'required' => false,
                            'label' => 'Caption',
                            'field_type' => TextType::class,
                            'row_attr' => [
                                'hidden' => true,
                            ]
                        ],
                    ],
                ]
            )
            ->end()
        ;
        if (!$this->isFormToCreateNewRecord()) {
            $form
                ->with('admin.images', ['class' => 'col-md-6'])
                ->add(
                    'images',
                    CollectionType::class,
                    [
                        'label' => false,
                        'required' => false,
                        'by_reference' => false,
                        'error_bubbling' => true,
                    ],
                    [
                        'edit' => 'inline',
                        'inline' => 'table',
                        'sortable' => 'position',
                        'order' => DoctrineEnum::ASC->value,
                    ]
                )
                ->end()
            ;
        }
        $form
            ->with('admin.controls', ['class' => 'col-md-3'])
            ->add('position', NumberType::class)
            ->add(
                'isIllustration',
                CheckboxType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'isWorkshop',
                CheckboxType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'isActive',
                CheckboxType::class,
                [
                    'required' => false,
                ]
            )
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add(
                'category',
                ModelFilter::class,
                [
                    'field_options' => [
                        'class' => Category::class,
                        'choice_label' => 'name',
                        'query_builder' => $this->getEntityManager()->getRepository(Category::class)->getAllSortedByNameQB(),
                    ],
                ]
            )
            ->add('title')
            ->add('subtitle')
            ->add('description')
            ->add('ctaButtonLabel')
            ->add('position')
            ->add('isIllustration')
            ->add('isWorkshop')
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
            ->add(
                'category',
                FieldDescriptionInterface::TYPE_MANY_TO_ONE,
                [
                    'editable' => false,
                    'sortable' => true,
                    'associated_property' => 'name',
                    'route' => [
                        'name' => 'edit',
                    ],
                    'sort_field_mapping' => [
                        'fieldName' => 'name',
                    ],
                    'sort_parent_association_mappings' => [
                        [
                            'fieldName' => 'category',
                        ],
                    ],
                ]
            )
            ->add('title')
            ->add('position')
            ->add(
                'isIllustration',
                FieldDescriptionInterface::TYPE_BOOLEAN,
                [
                    'editable' => true,
                    'header_style' => 'width:60px',
                    'header_class' => 'text-center',
                    'row_align' => 'center',
                ]
            )
            ->add(
                'isWorkshop',
                FieldDescriptionInterface::TYPE_BOOLEAN,
                [
                    'editable' => true,
                    'header_style' => 'width:60px',
                    'header_class' => 'text-center',
                    'row_align' => 'center',
                ]
            )
            ->add(
                'isActive',
                FieldDescriptionInterface::TYPE_BOOLEAN,
                [
                    'header_style' => 'width:60px',
                    'header_class' => 'text-center',
                    'row_align' => 'center',
                    'editable' => true,
                ]
            )
            ->add(
                ListMapper::NAME_ACTIONS,
                ListMapper::TYPE_ACTIONS,
                [
                    'header_style' => 'width:86px',
                    'header_class' => 'text-right',
                    'row_align' => 'right',
                    'actions' => [
                        'show' => [],
                        'edit' => [],
                    ],
                ]
            )
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
