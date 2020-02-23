<?php
declare(strict_types=1);

namespace App\Factory;

use App\Dto\Request\Warehouse\WarehouseAddRequest;
use App\Dto\Request\Warehouse\WarehouseUpdateRequest;
use App\Dto\Warehouse\WarehouseDto;
use App\Entity\Warehouse;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @package App\Factory
 */
class WarehouseFactory
{
    /**
     * @param WarehouseDto $warehouse
     *
     * @return Warehouse
     */
    public function createEntityFromDto(WarehouseDto $warehouse): Warehouse
    {
        return (new Warehouse())->setCode($warehouse->getCode())
                                ->setName($warehouse->getName())
                                ->setActive($warehouse->isActive());
    }

    /**
     * @param Warehouse    $warehouse
     * @param WarehouseDto $warehouseDto
     *
     * @return Warehouse
     */
    public function updateEntityFromDto(Warehouse $warehouse, WarehouseDto $warehouseDto): Warehouse
    {
        if (!empty($warehouseDto->getName())) {
            $warehouse->setName($warehouseDto->getName());
        }

        return $warehouse;
    }

    /**
     * @param Warehouse $warehouse
     *
     * @return WarehouseDto
     */
    public function createDtoFromEntity(Warehouse $warehouse): WarehouseDto
    {
        return (new WarehouseDto())->setId($warehouse->getId())
                                   ->setCode($warehouse->getCode())
                                   ->setName($warehouse->getName())
                                   ->setActive($warehouse->getActive());
    }

    /**
     * @param ArrayCollection $warehouses
     *
     * @return ArrayCollection
     */
    public function createDtoFromEntityList(ArrayCollection $warehouses): ArrayCollection
    {
        return $warehouses->map(
            function(Warehouse $warehouse) {
                return $this->createDtoFromEntity($warehouse);
            }
        );
    }

    /**
     * @param WarehouseAddRequest $request
     *
     * @return WarehouseDto
     */
    public function createDtoFromAddRequest(WarehouseAddRequest $request): WarehouseDto
    {
        return (new WarehouseDto())->setActive(true)
                                   ->setCode($request->getCode())
                                   ->setName($request->getName());
    }

    /**
     * @param WarehouseUpdateRequest $request
     *
     * @return WarehouseDto
     */
    public function createDtoFromUpdateRequest(WarehouseUpdateRequest $request): WarehouseDto
    {
        return (new WarehouseDto())->setCode($request->getCode())
                                   ->setName($request->getName());
    }
}