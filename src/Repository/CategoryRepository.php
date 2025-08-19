<?php

namespace App\Repository;

use App\Entity\Category;
use App\Enum\DoctrineEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Category>
 */
class CategoryRepository extends ServiceEntityRepository
{
    private const string ALIAS = 'c';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function getAllSortedByNameQB(): QueryBuilder
    {
        return $this->createQueryBuilder(self::ALIAS)->orderBy(sprintf('%s.name', self::ALIAS), DoctrineEnum::ASC->value);
    }
}
