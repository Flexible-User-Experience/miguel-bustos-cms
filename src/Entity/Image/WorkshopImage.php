<?php

namespace App\Entity\Image;

use App\Entity\Workshop;
use App\Entity\Trait\MainImageTrait;
use App\Repository\Image\WorkshopImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: WorkshopImageRepository::class)]
#[Vich\Uploadable]
class WorkshopImage extends AbstractImage
{
    use MainImageTrait;

    #[Assert\File(maxSize: '10M', extensions: ['png', 'jpg', 'jpeg'])]
    #[Assert\Image(minWidth: 1200)]
    #[Vich\UploadableField(mapping: 'workshops_photos', fileNameProperty: 'mainImage')]
    private ?File $mainImageFile = null;

    #[ORM\JoinColumn(nullable: false)]
    #[ORM\ManyToOne(targetEntity: Workshop::class, inversedBy: 'images')]
    private Workshop $workshop;

    public function getWorkshop(): ?Workshop
    {
        return $this->workshop;
    }

    public function setWorkshop(?Workshop $workshop): void
    {
        $this->workshop = $workshop;
    }
}
