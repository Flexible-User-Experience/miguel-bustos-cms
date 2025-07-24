<?php

namespace App\Entity\Image;

use App\Entity\Project;
use App\Entity\Trait\MainImageTrait;
use App\Repository\Image\ProjectImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ProjectImageRepository::class)]
#[Vich\Uploadable]
class ProjectImage extends AbstractImage
{
    use MainImageTrait;

    #[Assert\File(maxSize: '10M', extensions: ['png', 'jpg', 'jpeg'])]
    #[Assert\Image(minWidth: 1200)]
    #[Vich\UploadableField(mapping: 'projects_photos', fileNameProperty: 'mainImage')]
    private ?File $mainImageFile = null;

    #[ORM\JoinColumn(nullable: false)]
    #[ORM\ManyToOne(targetEntity: Project::class, inversedBy: 'images')]
    private Project $project;

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): void
    {
        $this->project = $project;
    }
}
