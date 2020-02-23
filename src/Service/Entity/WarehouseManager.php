<?php
declare(strict_types=1);

namespace App\Service\Entity;

use App\Dto\Warehouse\WarehouseDto;
use App\Entity\Warehouse;
use App\Exception\Warehouse\WarehouseNotFoundException;
use App\Exception\Warehouse\WarehouseUniqueException;
use App\Factory\WarehouseFactory;
use App\Repository\WarehouseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Throwable;

/**
 * @package App\Service\Entity
 */
class WarehouseManager
{
    /**
     * @var WarehouseRepository
     */
    private $repository;

    /**
     * @var WarehouseFactory
     */
    private $factory;

    /**
     * @param WarehouseRepository $repository
     * @param WarehouseFactory    $factory
     */
    public function __construct(WarehouseRepository $repository, WarehouseFactory $factory)
    {
        $this->repository = $repository;
        $this->factory = $factory;
    }

    /**
     * @param WarehouseDto $warehouse
     *
     * @throws Throwable
     * @return WarehouseDto
     */
    public function add(WarehouseDto $warehouse): WarehouseDto
    {
        $result = $this->factory->createEntityFromDto($warehouse);

        $this->repository->beginTransaction();

        try {
            $this->repository->add($result);
        } catch (UniqueConstraintViolationException $e) {
            $this->repository->rollback();
            throw new WarehouseUniqueException(
                sprintf(
                    'Warehouse with code = %s already exists',
                    $warehouse->getCode()
                )
            );
        } catch (Throwable $e) {
            $this->repository->rollback();
            throw $e;
        }

        $this->repository->commit();

        return $this->factory->createDtoFromEntity($result);
    }

    /**
     * @param WarehouseDto $warehouse
     *
     * @throws Throwable
     * @return WarehouseDto
     */
    public function update(WarehouseDto $warehouse): WarehouseDto
    {
        $result = $this->getActiveEntityByCode($warehouse->getCode());

        $this->repository->beginTransaction();

        try {
            $this->factory->updateEntityFromDto($result, $warehouse);
            $this->repository->update($result);
        } catch (Throwable $e) {
            $this->repository->rollback();
            throw $e;
        }

        $this->repository->commit();

        return $this->factory->createDtoFromEntity($result);
    }

    /**
     * @param string $code
     *
     * @throws Throwable
     * @return WarehouseDto
     */
    public function delete(string $code): WarehouseDto
    {
        $result = $this->getActiveEntityByCode($code);

        $this->repository->beginTransaction();

        try {
            $this->doDelete($result);
        } catch (Throwable $e) {
            $this->repository->rollback();
            throw $e;
        }

        $this->repository->commit();

        return $this->factory->createDtoFromEntity($result);
    }

    /**
     * @param string $code
     *
     * @throws Throwable
     * @return WarehouseDto
     */
    public function activate(string $code): WarehouseDto
    {
        $result = $this->getNotActiveEntityByCode($code);

        $this->repository->beginTransaction();

        try {
            $this->doActivate($result);
        } catch (Throwable $e) {
            $this->repository->rollback();
            throw $e;
        }

        $this->repository->commit();

        return $this->factory->createDtoFromEntity($result);
    }

    /**
     * @param int $id
     *
     * @return WarehouseDto
     */
    public function getActiveById(int $id): WarehouseDto
    {
        return $this->factory->createDtoFromEntity($this->getActiveEntityById($id));
    }

    /**
     * @param string $code
     *
     * @return WarehouseDto
     */
    public function getActiveByCode(string $code): WarehouseDto
    {
        return $this->factory->createDtoFromEntity($this->getActiveEntityByCode($code));
    }

    /**
     * @param int $id
     *
     * @return Warehouse
     */
    public function getActiveEntityById(int $id): Warehouse
    {
        $warehouse = $this->repository->findActiveOneById($id);

        if (!$warehouse instanceof Warehouse) {
            throw new WarehouseNotFoundException(
                sprintf('Distribution center with id = %s not found', $id)
            );
        }

        return $warehouse;
    }

    /**
     * @param string $code
     *
     * @return Warehouse
     */
    public function getActiveEntityByCode(string $code): Warehouse
    {
        $warehouse = $this->repository->findActiveOneByCode($code);

        if (!$warehouse instanceof Warehouse) {
            throw new WarehouseNotFoundException(
                sprintf('Warehouse with code = %s not found', $code)
            );
        }

        return $warehouse;
    }

    /**
     * @param string $code
     *
     * @return Warehouse
     */
    public function getNotActiveEntityByCode(string $code): Warehouse
    {
        $warehouse = $this->repository->findNotActiveOneByCode($code);

        if (!$warehouse instanceof Warehouse) {
            throw new WarehouseNotFoundException(
                sprintf('Warehouse with code = %s not found', $code)
            );
        }

        return $warehouse;
    }


    /**
     * @return ArrayCollection
     */
    public function getList(): ArrayCollection
    {
        return $this->factory->createDtoFromEntityList(
            new ArrayCollection($this->repository->findAll())
        );
    }

    /**
     * @return ArrayCollection
     */
    public function getActiveList(): ArrayCollection
    {
        return $this->factory->createDtoFromEntityList(
            new ArrayCollection($this->repository->findAllActive())
        );
    }

    /**
     * @return ArrayCollection
     */
    public function getNotActiveList(): ArrayCollection
    {
        return $this->factory->createDtoFromEntityList(
            new ArrayCollection($this->repository->findAllNotActive())
        );
    }

    /**
     * @param Warehouse $warehouse
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    protected function doDelete(Warehouse $warehouse): void
    {
        $warehouse->setActive(false);
        $this->repository->update($warehouse);
    }

    /**
     * @param Warehouse $warehouse
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    protected function doActivate(Warehouse $warehouse): void
    {
        $warehouse->setActive(true);
        $this->repository->update($warehouse);
    }
}