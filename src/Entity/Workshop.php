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
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorkshopRepository::class)]
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

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $startsAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $endsAt = null;

    #[ORM\Column]
    private ?int $price = null;

    /**
     * @var Collection<int, WorkshopImage>
     */
    #[ORM\OneToMany(targetEntity: WorkshopImage::class, mappedBy: 'workshop')]
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

    public function getStartsAt(): ?DateTimeInterface
    {
        return $this->startsAt;
    }

    public function setStartsAt(DateTimeInterface $startsAt): static
    {
        $this->startsAt = $startsAt;
        return $this;
    }

    public function getEndsAt(): ?DateTimeInterface
    {
        return $this->endsAt;
    }

    public function setEndsAt(DateTimeInterface $endsAt): static
    {
        $this->endsAt = $endsAt;
        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

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
}
