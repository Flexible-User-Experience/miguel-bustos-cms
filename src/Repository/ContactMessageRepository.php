<?php

namespace App\Repository;

use App\Entity\ContactMessage;
use App\Enum\DoctrineEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ContactMessage>
 *
 * @method ContactMessage|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContactMessage|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContactMessage[]    findAll()
 * @method ContactMessage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactMessageRepository extends ServiceEntityRepository
{
    private const string ALIAS = 'cm';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContactMessage::class);
    }

    public function update(bool $flush = false): void
    {
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function add(ContactMessage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);
        $this->update($flush);
    }

    public function remove(ContactMessage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);
        $this->update($flush);
    }

    public function getAllSortedByCreatedAtQB(): QueryBuilder
    {
        return $this->createQueryBuilder(self::ALIAS)->orderBy(sprintf('%s.createdAt', self::ALIAS), DoctrineEnum::DESC->value);
    }

    public function getAllSortedByCreatedAtQ(): Query
    {
        return $this->getAllSortedByCreatedAtQB()->getQuery();
    }

    public function getAllSortedByCreatedAt(): array
    {
        return $this->getAllSortedByCreatedAtQ()->getResult();
    }

    public function getContactMessagesAmount(): int
    {
        return count($this->getAllSortedByCreatedAt());
    }

    public function getResponsePendingContactMessagesAmount(): int
    {
        $qb = $this->getAllSortedByCreatedAtQB()
            ->where(sprintf('%s.hasBeenReplied = :replied', self::ALIAS))
            ->setParameter('replied', false)
        ;

        return count($qb->getQuery()->getResult());
    }
}
