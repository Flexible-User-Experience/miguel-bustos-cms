<?php

namespace App\Entity\Translations;

use App\Entity\Category;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

#[ORM\Entity]
#[ORM\UniqueConstraint(name: 'lookup_service_unique_idx', columns: ['locale', 'object_id', 'field'])]
class CategoryTranslation extends AbstractPersonalTranslation
{
    #[ORM\JoinColumn(name: 'object_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'translations')]
    protected $object;
}
