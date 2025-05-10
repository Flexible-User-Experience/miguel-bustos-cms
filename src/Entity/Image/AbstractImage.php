<?php

namespace App\Entity\Image;

use App\Entity\AbstractEntity;
use App\Entity\Interface\ExtraImageInterfaceImage;
use App\Entity\Trait\CaptionTrait;
use App\Entity\Trait\DescriptionTrait;
use App\Entity\Trait\MainImageTrait;
//use App\Entity\Trait\SeoAlternativeImageTextTrait;

abstract class AbstractImage extends AbstractEntity implements ExtraImageInterfaceImage
{
    use CaptionTrait;
//    use DescriptionTrait;
    use MainImageTrait;
//    use SeoAlternativeImageTextTrait;

//    public function getSeoAlternativeImageTextOrName(): string
//    {
//        if ($this->getSeoAlternativeImageText()) {
//            return $this->getSeoAlternativeImageText();
//        }
//        if ($this->getCaption()) {
//            return $this->getCaption();
//        }
//
//        return AbstractEntity::DEFAULT_NAME;
//    }
}
