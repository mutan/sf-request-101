<?php
declare(strict_types=1);

namespace App\Exception\Warehouse;

use App\Exception\DistributionCenter\WarehouseExceptionInterface;
use App\Exception\NotFoundExceptionInterface;
use RuntimeException;

/**
 * @package App\Exception\Warehouse
 */
class WarehouseNotFoundException extends RuntimeException
    implements WarehouseExceptionInterface, NotFoundExceptionInterface
{
}