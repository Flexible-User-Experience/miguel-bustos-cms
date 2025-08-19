<?php

namespace App\Entity\Image;

use App\Entity\AbstractEntity;
use App\Entity\Interface\ExtraImageInterfaceImage;
use App\Entity\Project;
use App\Entity\Trait\MainImageTrait;
use App\Entity\Trait\PositionTrait;
use App\Repository\Image\ProjectImageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ProjectImageRepository::class)]
#[Vich\Uploadable]
class ProjectImage extends AbstractEntity implements ExtraImageInterfaceImage
{
    use MainImageTrait;
    use PositionTrait;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    protected ?string $altImageText = null;

    #[Assert\File(maxSize: '10M', extensions: ['png', 'jpg', 'jpeg', 'gif'])]
    #[Assert\Image(minWidth: 1200)]
    #[Vich\UploadableField(
        mapping: 'projects_photos',
        fileNameProperty: 'mainImage',
        size: 'size',
        mimeType: 'mimeType',
        originalName: 'originalName',
        dimensions: 'dimensions'
    )]
    private ?File $mainImageFile = null;

    #[ORM\JoinColumn(nullable: false)]
    #[ORM\ManyToOne(targetEntity: Project::class, inversedBy: 'images')]
    private Project $project;

    public function getAltImageText(): ?string
    {
        return $this->altImageText;
    }

    public function setAltImageText(?string $altImageText): self
    {
        $this->altImageText = $altImageText;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): void
    {
        $this->project = $project;
    }
}
