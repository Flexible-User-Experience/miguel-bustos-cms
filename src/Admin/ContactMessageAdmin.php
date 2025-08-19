<?php

namespace App\Admin;

use App\Entity\AbstractEntity;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Filter\DateFilter;
use Sonata\Form\Type\DatePickerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class ContactMessageAdmin extends AbstractBaseAdmin
{
    public function generateBaseRoutePattern(bool $isChildAdmin = false): string
    {
        return 'messages/message';
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection
            ->add('reply', $this->getRouterIdParameter().'/reply')
            ->remove('create')
            ->remove('edit')
            ->remove('batch')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add(
                'createdAt',
                DateFilter::class,
                [
                    'field_type' => DatePickerType::class,
                    'field_options' => [
                        'widget' => 'single_text',
                        'format' => AbstractEntity::DATE_PICKER_TYPE_FORMAT,
                    ],
                ]
            )
            ->add('name')
            ->add('email')
            ->add('mobileNumber')
            ->add('message')
            ->add(
                'replyDate',
                DateFilter::class,
                [
                    'field_type' => DatePickerType::class,
                    'field_options' => [
                        'widget' => 'single_text',
                        'format' => AbstractEntity::DATE_PICKER_TYPE_FORMAT,
                    ],
                ]
            )
            ->add('hasBeenRead')
            ->add('hasBeenReplied')
            ->add('replyMessage')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add(
                'createdAt',
                FieldDescriptionInterface::TYPE_DATE,
                [
                    'format' => AbstractEntity::DATETIME_STRING_FORMAT,
                    'editable' => false,
                    'header_class' => 'text-center',
                    'row_align' => 'center',
                ]
            )
            ->add(
                'name',
                FieldDescriptionInterface::TYPE_STRING,
                [
                    'editable' => false,
                ]
            )
            ->add(
                'email',
                FieldDescriptionInterface::TYPE_STRING,
                [
                    'editable' => false,
                ]
            )
            ->add(
                'mobileNumber',
                FieldDescriptionInterface::TYPE_STRING,
                [
                    'editable' => false,
                ]
            )
            ->add(
                'hasBeenRead',
                FieldDescriptionInterface::TYPE_BOOLEAN,
                [
                    'editable' => false,
                    'header_class' => 'text-center',
                    'row_align' => 'center',
                ]
            )
            ->add(
                'hasBeenReplied',
                FieldDescriptionInterface::TYPE_BOOLEAN,
                [
                    'editable' => false,
                    'header_class' => 'text-center',
                    'row_align' => 'center',
                ]
            )
            ->add(
                ListMapper::NAME_ACTIONS,
                ListMapper::TYPE_ACTIONS,
                [
                    'actions' => [
                        'show' => [],
                        'reply' => [
                            'template' => '@App/admin/cells/list/contact_message_reply_button.html.twig',
                        ],
                        'delete' => [],
                    ],
                    'header_style' => 'width:117px',
                    'header_class' => 'text-right',
                    'row_align' => 'right',
                ]
            )
        ;
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->with(
                'General',
                [
                    'class' => 'col-md-4',
                    'box_class' => 'box box-success',
                ]
            )
            ->add(
                'name',
                TextType::class,
                [
                    'required' => false,
                    'disabled' => true,
                ]
            )
            ->add(
                'email',
                TextType::class,
                [
                    'required' => false,
                    'disabled' => true,
                ]
            )
            ->add(
                'message',
                TextareaType::class,
                [
                    'required' => false,
                    'attr' => [
                        'readonly' => 'readonly',
                    ],
                ]
            )
            ->end()
            ->with(
                'Reply',
                [
                    'class' => 'col-md-4',
                    'box_class' => 'box box-success',
                ]
            )
            ->add(
                'replyMessage',
                TextareaType::class,
                [
                    'required' => true,
                    'attr' => [
                        'rows' => 10,
                    ],
                ]
            )
            ->end()
            ->with(
                'Controls',
                [
                    'class' => 'col-md-4',
                    'box_class' => 'box box-success',
                ]
            )
            ->add(
                'createdAt',
                DatePickerType::class,
                [
                    'format' => AbstractEntity::DATE_FORM_TYPE_FORMAT,
                    'required' => false,
                    'disabled' => true,
                ]
            )
            ->add(
                'replyDate',
                DatePickerType::class,
                [
                    'format' => AbstractEntity::DATE_FORM_TYPE_FORMAT,
                    'required' => false,
                    'disabled' => true,
                ]
            )
            ->add(
                'hasBeenReplied',
                null,
                [
                    'required' => false,
                    'disabled' => true,
                ]
            )
            ->end()
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->with(
                'General',
                [
                    'class' => 'col-md-4',
                    'box_class' => 'box box-info',
                ]
            )
            ->add('name')
            ->add('email')
            ->add('mobileNumber')
            ->add('message')
            ->end()
            ->with(
                'Controls',
                [
                    'class' => 'col-md-3',
                    'box_class' => 'box box-info',
                ]
            )
            ->add('createdAtString')
            ->add('hasBeenRead')
            ->add('hasBeenReplied')
            ->add('replyDateString')
            ->end()
        ;
        if ($this->getSubject()->getHasBeenReplied()) {
            $show
                ->with(
                    'Reply',
                    [
                        'class' => 'col-md-5',
                        'box_class' => 'box box-info',
                    ]
                )
                ->add('replyMessage')
                ->end()
            ;
        }
    }
}
