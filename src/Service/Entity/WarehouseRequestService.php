<?php
declare(strict_types=1);

namespace App\Service\Entity;

use App\Dto\Request\Warehouse\WarehouseAddRequest;
use App\Dto\Request\Warehouse\WarehouseUpdateRequest;
use App\Dto\Warehouse\WarehouseDto;
use App\Exception\Http\BadRequestException;
use App\Exception\Http\NotFoundException;
use App\Exception\Warehouse\WarehouseNotFoundException;
use App\Exception\Warehouse\WarehouseUniqueException;
use App\Factory\WarehouseFactory;
use Doctrine\Common\Collections\ArrayCollection;
use Throwable;

/**
 * @package App\Service\Entity
 */
class WarehouseRequestService
{
    /**
     * @var WarehouseFactory
     */
    private $factory;

    /**
     * @var WarehouseManager
     */
    private $manager;

    /**
     * @param WarehouseFactory $factory
     * @param WarehouseManager $manager
     */
    public function __construct(WarehouseFactory $factory, WarehouseManager $manager)
    {
        $this->factory = $factory;
        $this->manager = $manager;
    }

    /**
     * @param WarehouseAddRequest $request
     *
     * @throws Throwable
     * @return WarehouseDto
     */
    public function add(WarehouseAddRequest $request): WarehouseDto
    {
        try {
            $result = $this->manager->add(
                $this->factory->createDtoFromAddRequest($request)
            );
        } catch (WarehouseUniqueException $e) {
            throw new BadRequestException($e->getMessage());
        }

        return $result;
    }

    /**
     * @param WarehouseUpdateRequest $request
     *
     * @throws Throwable
     * @return WarehouseDto
     */
    public function update(WarehouseUpdateRequest $request): WarehouseDto
    {
        try {
            $result = $this->manager->update(
                $this->factory->createDtoFromUpdateRequest($request)
            );
        } catch (WarehouseNotFoundException $e) {
            throw new NotFoundException($e->getMessage());
        }

        return $result;
    }

    /**
     * @param string $code
     *
     * @throws Throwable
     * @return WarehouseDto
     */
    public function delete(string $code): WarehouseDto
    {
        try {
            $result = $this->manager->delete($code);
        } catch (WarehouseNotFoundException $e) {
            throw new NotFoundException($e->getMessage());
        }

        return $result;
    }

    /**
     * @param string $code
     *
     * @throws Throwable
     * @return WarehouseDto
     */
    public function activate(string $code): WarehouseDto
    {
        try {
            $result = $this->manager->activate($code);
        } catch (WarehouseNotFoundException $e) {
            throw new NotFoundException($e->getMessage());
        }

        return $result;
    }

    /**
     * @param int $id
     *
     * @return WarehouseDto
     */
    public function getActiveById(int $id): WarehouseDto
    {
        try {
            $result = $this->manager->getActiveById($id);
        } catch (WarehouseNotFoundException $e) {
            throw new NotFoundException($e->getMessage());
        }

        return $result;
    }

    /**
     * @param string $code
     *
     * @return WarehouseDto
     */
    public function getActiveByCode(string $code): WarehouseDto
    {
        try {
            $result = $this->manager->getActiveByCode($code);
        } catch (WarehouseNotFoundException $e) {
            throw new NotFoundException($e->getMessage());
        }

        return $result;
    }

    /**
     * @return ArrayCollection
     */
    public function getList(): ArrayCollection
    {
        return $this->manager->getList();
    }

    /**
     * @return ArrayCollection
     */
    public function getActiveList(): ArrayCollection
    {
        return $this->manager->getActiveList();
    }

    /**
     * @return ArrayCollection
     */
    public function getNotActiveList(): ArrayCollection
    {
        return $this->manager->getNotActiveList();
    }
}