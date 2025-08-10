<?php

namespace App\Admin;

use App\Enum\DoctrineEnum;
use Doctrine\ORM\EntityManagerInterface;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridInterface;
use Sonata\AdminBundle\Route\RouteCollectionInterface;

class AbstractBaseAdmin extends AbstractAdmin
{
    protected EntityManagerInterface $em;

    public function getEntityManager(): EntityManagerInterface
    {
        return $this->em;
    }

    public function setEntityManager(EntityManagerInterface $em): self
    {
        $this->em = $em;

        return $this;
    }

    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues[DatagridInterface::PAGE] = 1;
        $sortValues[DatagridInterface::SORT_ORDER] = DoctrineEnum::ASC->value;
        $sortValues[DatagridInterface::SORT_BY] = 'name';
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        parent::configureRoutes($collection);
        $collection
            ->remove('delete')
            ->remove('batch')
        ;
    }

    public function getExportFormats(): array
    {
        return [
            'csv',
            'xls',
        ];
    }

    protected function isFormToCreateNewRecord(): bool
    {
        return !$this->id($this->getSubject());
    }

    public static function get60x60CenteredImageNotEditableListFieldDescriptionOptionsArray(): array
    {
        return [
            'header_style' => 'width:60px',
            'header_class' => 'text-center',
            'row_align' => 'center',
            'editable' => false,
        ];
    }
}
