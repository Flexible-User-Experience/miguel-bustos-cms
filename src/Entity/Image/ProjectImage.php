<?php

namespace App\Entity\Image;

use App\Entity\AbstractEntity;
use App\Entity\Interface\ImageInterface;
use App\Entity\Project;
use App\Entity\Trait\CaptionTrait;
use App\Entity\Trait\MainImageTrait;
use App\Entity\Trait\PositionTrait;
use App\Entity\Trait\TranslationTrait;
use App\Entity\Translations\ProjectImageTranslation;
use App\Repository\Image\ProjectImageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Gedmo\TranslationEntity(class: ProjectImageTranslation::class)]
#[ORM\Entity(repositoryClass: ProjectImageRepository::class)]
#[Vich\Uploadable]
class ProjectImage extends AbstractEntity implements ImageInterface
{
    use CaptionTrait;
    use MainImageTrait;
    use PositionTrait;
    use TranslationTrait;

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

    #[Assert\Valid]
    #[ORM\OneToMany(targetEntity: ProjectImageTranslation::class, mappedBy: 'object', cascade: ['persist', 'remove'])]
    private ?Collection $translations;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

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

    public function addTranslation(ProjectImageTranslation $translation): self
    {
        if (!$this->translations->contains($translation) && $translation->getContent()) {
            $this->translations->add($translation);
            $translation->setObject($this);
        }

        return $this;
    }

    public function removeTranslation(ProjectImageTranslation $translation): self
    {
        if ($this->translations->contains($translation)) {
            $this->translations->removeElement($translation);
        }

        return $this;
    }
}
