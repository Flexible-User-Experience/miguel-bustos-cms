<?php

namespace App\Entity;

use App\Entity\Image\ProjectImage;
use App\Entity\Trait\ImagesTrait;
use App\Entity\Trait\IsActiveTrait;
use App\Entity\Trait\MainImageTrait;
use App\Entity\Trait\SlugTitleTrait;
use App\Entity\Trait\TitleTrait;
use App\Entity\Translations\ProjectTranslation;
use App\Interface\SlugInterface;
use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Gedmo\TranslationEntity(class: ProjectTranslation::class)]
#[ORM\Entity(repositoryClass: ProjectRepository::class)]
#[Vich\Uploadable]
class Project extends AbstractEntity implements SlugInterface
{
    use IsActiveTrait;
    use ImagesTrait;
    use MainImageTrait;
    use SlugTitleTrait;
    use TitleTrait;

    #[Gedmo\Translatable]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $subtitle = null;

    #[Gedmo\Translatable]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[Assert\File(maxSize: '20M', extensions: ['png', 'jpg', 'jpeg'])]
    #[Assert\Image(minWidth: 600)]
    #[Vich\UploadableField(mapping: 'projects_photos', fileNameProperty: 'mainImage')]
    private ?File $mainImageFile = null;

    #[ORM\OneToMany(targetEntity: ProjectImage::class, mappedBy: 'project', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $images;

    #[ORM\ManyToOne(inversedBy: 'projects')]
    private ?Category $category = null;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false)]
    private bool $isWorkshop = false;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false)]
    private bool $isIllustration = true;

    public function __construct()
    {
        $this->images = new ArrayCollection();
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

    //    TODO:
    //    videoUrl
    //    pdfFile

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

    public function __toString(): string
    {
        return $this->getTitle() ?: self::DEFAULT_NAME;
    }
}
