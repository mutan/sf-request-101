<?php
declare(strict_types=1);

namespace App\Controller;

use JMS\Serializer\ArrayTransformerInterface;

/**
 * @package App\Controller
 */
trait ArrayTransformerAwareTrait
{
    /**
     * @var ArrayTransformerInterface
     */
    protected $arrayTransformer;

    /**
     * @required
     *
     * @param ArrayTransformerInterface $arrayTransformer
     */
    public function setArrayTransformer(ArrayTransformerInterface $arrayTransformer): void
    {
        $this->arrayTransformer = $arrayTransformer;
    }
}