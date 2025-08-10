<?php

namespace App\Entity;

use App\Entity\Trait\SlugTrait;
use App\Entity\Translations\CategoryTranslation;
use App\Interface\SlugInterface;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[Gedmo\TranslationEntity(class: CategoryTranslation::class)]
#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category extends AbstractEntity implements SlugInterface
{
    use SlugTrait;

    #[Gedmo\Translatable]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: Project::class, mappedBy: 'category')]
    private Collection $projects;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function setProjects(Collection $projects): self
    {
        $this->projects = $projects;

        return $this;
    }

    public function addProject(Project $project): static
    {
        if (!$this->projects->contains($project)) {
            $this->projects->add($project);
            $project->setCategory($this);
        }

        return $this;
    }

    public function removeProject(Project $project): static
    {
        if ($this->projects->removeElement($project)) {
            // set the owning side to null (unless already changed)
            if ($project->getCategory() === $this) {
                $project->setCategory(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName() ?: self::DEFAULT_NAME;
    }
}
