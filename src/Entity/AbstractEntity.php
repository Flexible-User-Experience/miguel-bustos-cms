<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

abstract class AbstractEntity
{
    public const string DEFAULT_NAME = '---';
    public const string DEFAULT_DATETIME = 'd/m/Y H:i';
    public const string DEFAULT_CURRENCY_STRING = 'EUR';
    public const string DEFAULT_CURRENCY_SYMBOL = '€';
    public const string DEFAULT_SERIAL_NUMBER_SEPARATOR = '/';
    public const string DEFAULT_NULL_STRING = '---';
    public const string DEFAULT_NULL_DATE_STRING = '--/--/----';
    public const string DEFAULT_NULL_DATETIME_STRING = '--/--/---- --:--';
    public const string DATE_PICKER_TYPE_FORMAT = 'dd/MM/yyyy';
    public const string DATE_FORM_TYPE_FORMAT = 'd/M/y';
    public const string DATE_STRING_FORMAT = 'd/m/Y';
    public const string DATETIME_STRING_FORMAT = 'd/m/Y H:i';
    public const string DATABASE_DATE_STRING_FORMAT = 'Y-m-d';
    public const string DATABASE_DATETIME_STRING_FORMAT = 'Y-m-d H:i:s';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[Gedmo\Timestampable(on: 'create')]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    protected ?\DateTimeInterface $createdAt = null;

    #[Gedmo\Timestampable(on: 'update')]
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    protected ?\DateTimeInterface $updatedAt = null;

    public static function convertDateTimeAsString(?\DateTimeInterface $date): string
    {
        return $date ? $date->format(self::DEFAULT_DATETIME) : '00/00/0000 00:00';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getCreatedAtString(): string
    {
        return self::convertDateTimeAsString($this->getCreatedAt());
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function getUpdatedAtString(): string
    {
        return self::convertDateTimeAsString($this->getUpdatedAt());
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getId() ?: self::DEFAULT_NAME;
    }
}
