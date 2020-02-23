<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Warehouse;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Warehouse|null find($id, $lockMode = null, $lockVersion = null)
 * @method Warehouse|null findOneBy(array $criteria, array $orderBy = null)
 * @method Warehouse[]    findAll()
 * @method Warehouse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WarehouseRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Warehouse::class);
    }

    /**
     * @param int $id
     *
     * @return Warehouse|null
     */
    public function findActiveOneById(int $id): ?Warehouse
    {
        return $this->findOneBy(['id' => $id, 'active' => true]);
    }

    /**
     * @param string $code
     *
     * @return Warehouse|null
     */
    public function findActiveOneByCode(string $code): ?Warehouse
    {
        return $this->findOneBy(['code' => $code, 'active' => true]);
    }

    /**
     * @param string $code
     *
     * @return Warehouse|null
     */
    public function findNotActiveOneByCode(string $code): ?Warehouse
    {
        return $this->findOneBy(['code' => $code, 'active' => false]);
    }

    /**
     * @return array
     */
    public function findAllActive(): array
    {
        return $this->findBy(['active' => true], ['id' => 'desc']);
    }

    /**
     * @return array
     */
    public function findAllNotActive(): array
    {
        return $this->findBy(['active' => false], ['id' => 'desc']);
    }
}
