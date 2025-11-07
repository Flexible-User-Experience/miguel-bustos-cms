<?php

namespace App\Admin\Image;

use App\Admin\AbstractBaseAdmin;
use App\Entity\Category;
use App\Entity\Project;
use App\Enum\DoctrineEnum;
use Sonata\AdminBundle\Datagrid\DatagridInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
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
        ;
    }
}
