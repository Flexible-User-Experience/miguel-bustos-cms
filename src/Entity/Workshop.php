<?php

namespace App\Entity;

use App\Entity\Image\WorkshopImage;
use App\Entity\Trait\ImagesTrait;
use App\Entity\Trait\IsActiveTrait;
use App\Entity\Trait\MainImageTrait;
use App\Entity\Trait\SlugTitleTrait;
use App\Entity\Trait\TitleTrait;
use App\Interface\SlugInterface;
use App\Repository\WorkshopRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: WorkshopRepository::class)]
#[Vich\Uploadable]
class Workshop extends AbstractEntity implements SlugInterface
{
    use IsActiveTrait;
    use ImagesTrait;
    use MainImageTrait;
    use SlugTitleTrait;
    use TitleTrait;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $subtitle = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[Assert\File(maxSize: '10M', extensions: ['png', 'jpg', 'jpeg'])]
    #[Assert\Image(minWidth: 600)]
    #[Vich\UploadableField(mapping: 'workshops_photos', fileNameProperty: 'mainImage')]
    private ?File $mainImageFile = null;

    #[ORM\OneToMany(targetEntity: WorkshopImage::class, mappedBy: 'workshop', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $images;

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

    /**
     * @return Collection<int, WorkshopImage>
     */
    public function getWorkshopImages(): Collection
    {
        return $this->images;
    }

    public function addWorkshopImage(WorkshopImage $workshopImage): static
    {
        if (!$this->images->contains($workshopImage)) {
            $this->images->add($workshopImage);
            $workshopImage->setWorkshop($this);
        }

        return $this;
    }

    public function removeWorkshopImage(WorkshopImage $workshopImage): static
    {
        if ($this->images->removeElement($workshopImage)) {
            // set the owning side to null (unless already changed)
            if ($workshopImage->getWorkshop() === $this) {
                $workshopImage->setWorkshop(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getTitle() ?: '';
    }
}
