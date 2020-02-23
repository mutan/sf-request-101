<?php
declare(strict_types=1);

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

/**
 * @package App\Repository
 */
abstract class AbstractEntityRepository extends ServiceEntityRepository
{
    /**
     * @param object $entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    protected function save(object $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    /**
     * @param object $entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(object $entity): void
    {
        $this->save($entity);
    }

    /**
     * @param object $entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function update(object $entity): void
    {
        $this->save($entity);
    }

    /**
     * @param object $entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    protected function remove(object $entity): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

    /**
     *
     */
    public function beginTransaction(): void
    {
        $this->getEntityManager()->beginTransaction();
    }

    /**
     *
     */
    public function rollback(): void
    {
        $this->getEntityManager()->rollback();
    }

    /**
     *
     */
    public function commit(): void
    {
        $this->getEntityManager()->commit();
    }
}