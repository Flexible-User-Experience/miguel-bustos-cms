<?php

namespace App\Entity;

use App\Entity\Trait\ImagesTrait;
use App\Entity\Trait\IsActiveTrait;
use App\Entity\Trait\MainImageTrait;
use App\Entity\Trait\SlugTitleTrait;
use App\Entity\Trait\TitleTrait;
use App\Interface\SlugInterface;
use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project extends AbstractEntity implements SlugInterface
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

    #[ORM\ManyToOne(inversedBy: 'projects')]
    private ?Category $category = null;

    /**
     * @var Collection<int, Partner>
     */
    #[ORM\ManyToMany(targetEntity: Partner::class, inversedBy: 'projects')]
    private Collection $partners;

    public function __construct()
    {
        $this->partners = new ArrayCollection();
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

//    TODO:
//
//
//    mainImage
//
//    images -> Entity: ProjectImage
//
//    videoUrl
//    pdfFile


    /**
     * @return Collection<int, Partner>
     */
    public function getPartners(): Collection
    {
        return $this->partners;
    }

    public function setPartners(Collection $partners): static
    {
        $this->partners = $partners;
        return $this;
    }

    public function addPartner(Partner $partner): static
    {
        if (!$this->partners->contains($partner)) {
            $this->partners->add($partner);
        }

        return $this;
    }

    public function removePartner(Partner $partner): static
    {
        $this->partners->removeElement($partner);

        return $this;
    }
}
