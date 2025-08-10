<?php

namespace App\Repository;

use App\Entity\Project;
use App\Enum\DoctrineEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Project>
 */
class ProjectRepository extends ServiceEntityRepository
{
    private const string ALIAS = 'p';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }

    public function findActiveSortedByPositionAndTitleQB(): QueryBuilder
    {
        return $this->createQueryBuilder(self::ALIAS)
            ->where(sprintf('%s.isActive = :val', self::ALIAS))
            ->setParameter('val', true)
            ->orderBy(sprintf('%s.position', self::ALIAS), DoctrineEnum::ASC->value)
            ->addOrderBy(sprintf('%s.title', self::ALIAS), DoctrineEnum::ASC->value)
        ;
    }

    public function findByIsActiveField(): array
    {
        return $this->findActiveSortedByPositionAndTitleQB()
            ->getQuery()
            ->getResult()
        ;
    }

    public function findWorkshops(): array
    {
        return $this->findActiveSortedByPositionAndTitleQB()
            ->andWhere(sprintf('%s.isWorkshop = :val', self::ALIAS))
            ->getQuery()
            ->getResult()
        ;
    }

    public function findIllustrations(): array
    {
        return $this->findActiveSortedByPositionAndTitleQB()
            ->andWhere(sprintf('%s.isIllustration = :val', self::ALIAS))
            ->getQuery()
            ->getResult()
        ;
    }
}
