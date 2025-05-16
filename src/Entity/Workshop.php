<?php

namespace App\Entity;

use App\Entity\Trait\ImagesTrait;
use App\Entity\Trait\IsActiveTrait;
use App\Entity\Trait\MainImageTrait;
use App\Entity\Trait\SlugTitleTrait;
use App\Entity\Trait\TitleTrait;
use App\Interface\SlugInterface;
use App\Repository\WorkshopRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
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
    #[Vich\UploadableField(mapping: 'projects_photos', fileNameProperty: 'mainImage')]
    private ?File $mainImageFile = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $startsAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $endsAt = null;

    #[ORM\Column]
    private ?int $price = null;

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

    public function __toString(): string
    {
        return $this->getTitle() ?: '';
    }
}
