<?php

namespace App\Entity;

use App\Entity\Image\ProjectImage;
use App\Entity\Interface\ImageInterface;
use App\Entity\Trait\AwardImageTrait;
use App\Entity\Trait\CaptionTrait;
use App\Entity\Trait\ImagesTrait;
use App\Entity\Trait\IsActiveTrait;
use App\Entity\Trait\MainImageTrait;
use App\Entity\Trait\PositionTrait;
use App\Entity\Trait\SlugTitleTrait;
use App\Entity\Trait\TitleTrait;
use App\Entity\Trait\TranslationTrait;
use App\Entity\Translations\ProjectTranslation;
use App\Enum\DoctrineEnum;
use App\Interface\SlugInterface;
use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Gedmo\TranslationEntity(class: ProjectTranslation::class)]
#[ORM\Entity(repositoryClass: ProjectRepository::class)]
#[Vich\Uploadable]
#[UniqueEntity(fields: ['slug'])]
class Project extends AbstractEntity implements ImageInterface, SlugInterface
{
    use AwardImageTrait;
    use CaptionTrait;
    use IsActiveTrait;
    use ImagesTrait;
    use MainImageTrait;
    use PositionTrait;
    use SlugTitleTrait;
    use TitleTrait;
    use TranslationTrait;

    #[Gedmo\Translatable]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $subtitle = null;

    #[Gedmo\Translatable]
    #[ORM\Column(type: Types::TEXT, length: 4000, nullable: true)]
    private ?string $description = null;

    #[Gedmo\Translatable]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ctaButtonLabel = null;

    #[Assert\Url(protocols: ['https'], requireTld: true)]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ctaButtonLink = null;

    #[Assert\Regex(pattern: '/^https:\/\/vimeo\.com\//')]
    #[Assert\Url(protocols: ['https'], requireTld: true)]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $vimeoLink = null;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false)]
    private bool $isWorkshop = false;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false)]
    private bool $isIllustration = true;

    #[Assert\File(maxSize: '10M', extensions: ['png', 'jpg', 'jpeg', 'gif'])]
    #[Assert\Image(minWidth: 600)]
    #[Vich\UploadableField(
        mapping: 'projects_photos',
        fileNameProperty: 'mainImage',
        size: 'size',
        mimeType: 'mimeType',
        originalName: 'originalName',
        dimensions: 'dimensions'
    )]
    private ?File $mainImageFile = null;

    #[Assert\File(maxSize: '10M', extensions: ['png', 'jpg', 'jpeg', 'gif'])]
    #[Assert\Image(minWidth: 600)]
    #[Vich\UploadableField(
        mapping: 'projects_photos',
        fileNameProperty: 'awardImage',
        size: 'awardSize',
        mimeType: 'awardMimeType',
        originalName: 'awardOriginalName',
        dimensions: 'awardDimensions'
    )]
    private ?File $awardImageFile = null;

    #[Assert\File(maxSize: '10M', extensions: ['png', 'jpg', 'jpeg', 'gif'])]
    #[Assert\Image(minWidth: 600)]
    #[Vich\UploadableField(
        mapping: 'projects_photos',
        fileNameProperty: 'awardImage2',
        size: 'awardSize2',
        mimeType: 'awardMimeType2',
        originalName: 'awardOriginalName2',
        dimensions: 'awardDimensions2'
    )]
    private ?File $awardImageFile2 = null;

    #[Assert\Valid]
    #[ORM\OneToMany(targetEntity: ProjectImage::class, mappedBy: 'project', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[ORM\OrderBy(['position' => DoctrineEnum::ASC->value])]
    private Collection $images;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'projects')]
    private ?Category $category = null;

    #[Assert\Valid]
    #[ORM\OneToMany(targetEntity: ProjectTranslation::class, mappedBy: 'object', cascade: ['persist', 'remove'])]
    private ?Collection $translations;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->translations = new ArrayCollection();
    }

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(?string $subtitle): static
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCtaButtonLabel(): ?string
    {
        return $this->ctaButtonLabel;
    }

    public function setCtaButtonLabel(?string $ctaButtonLabel): static
    {
        $this->ctaButtonLabel = $ctaButtonLabel;

        return $this;
    }

    public function getCtaButtonLink(): ?string
    {
        return $this->ctaButtonLink;
    }

    public function setCtaButtonLink(?string $ctaButtonLink): static
    {
        $this->ctaButtonLink = $ctaButtonLink;

        return $this;
    }

    public function getVimeoLink(): ?string
    {
        return $this->vimeoLink;
    }

    public function setVimeoLink(?string $vimeoLink): static
    {
        $this->vimeoLink = $vimeoLink;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function isWorkshop(): bool
    {
        return $this->isWorkshop;
    }

    public function setIsWorkshop(bool $isWorkshop): void
    {
        $this->isWorkshop = $isWorkshop;
    }

    public function isIllustration(): bool
    {
        return $this->isIllustration;
    }

    public function setIsIllustration(bool $isIllustration): void
    {
        $this->isIllustration = $isIllustration;
    }

    public function getProjectImages(): Collection
    {
        return $this->images;
    }

    public function addProjectImage(ProjectImage $projectImage): static
    {
        if (!$this->images->contains($projectImage)) {
            $this->images->add($projectImage);
            $projectImage->setProject($this);
        }

        return $this;
    }

    public function removeProjectImage(ProjectImage $projectImage): static
    {
        if ($this->images->removeElement($projectImage)) {
            // set the owning side to null (unless already changed)
            if ($projectImage->getProject() === $this) {
                $projectImage->setProject(null);
            }
        }

        return $this;
    }

    public function addTranslation(ProjectTranslation $translation): self
    {
        if (!$this->translations->contains($translation) && $translation->getContent()) {
            $this->translations->add($translation);
            $translation->setObject($this);
        }

        return $this;
    }

    public function removeTranslation(ProjectTranslation $translation): self
    {
        if ($this->translations->contains($translation)) {
            $this->translations->removeElement($translation);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getTitle() ?: self::DEFAULT_NAME;
    }
}
