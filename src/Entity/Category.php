<?php

namespace App\Entity;

use App\Entity\Trait\SlugTrait;
use App\Entity\Trait\TranslationTrait;
use App\Entity\Trait\NameTrait;
use App\Entity\Translations\CategoryTranslation;
use App\Interface\SlugInterface;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[Gedmo\TranslationEntity(class: CategoryTranslation::class)]
#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[UniqueEntity(fields: ['slug'])]
class Category extends AbstractEntity implements SlugInterface
{
    use NameTrait;
    use SlugTrait;
    use TranslationTrait;

    #[Gedmo\Translatable]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: Project::class, mappedBy: 'category')]
    private Collection $projects;

    #[Assert\Valid]
    #[ORM\OneToMany(targetEntity: CategoryTranslation::class, mappedBy: 'object', cascade: ['persist', 'remove'])]
    private ?Collection $translations;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
        $this->translations = new ArrayCollection();
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

    public function addTranslation(CategoryTranslation $translation): self
    {
        if (!$this->translations->contains($translation) && $translation->getContent()) {
            $this->translations->add($translation);
            $translation->setObject($this);
        }

        return $this;
    }

    public function removeTranslation(CategoryTranslation $translation): self
    {
        if ($this->translations->contains($translation)) {
            $this->translations->removeElement($translation);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName() ?: self::DEFAULT_NAME;
    }
}
