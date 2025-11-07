<?php

namespace App\Entity\Translations;

use App\Entity\Image\ProjectImage;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

#[ORM\Entity]
#[ORM\UniqueConstraint(columns: ['locale', 'object_id', 'field'])]
class ProjectImageTranslation extends AbstractPersonalTranslation
{
    #[ORM\JoinColumn(name: 'object_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    #[ORM\ManyToOne(targetEntity: ProjectImage::class, inversedBy: 'translations')]
    protected $object;
}
