<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Controller\ArrayTransformerAwareTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @package App\Controller
 */
abstract class AbstractApiController extends AbstractController
{
    use ArrayTransformerAwareTrait;

    /**
     * @param object $data
     * @param int    $status
     * @param array  $headers
     *
     * @return JsonResponse
     */
    protected function createJsonResponse(
        object $data,
        int $status = JsonResponse::HTTP_OK,
        array $headers = []
    ): JsonResponse {
        return new JsonResponse($this->arrayTransformer->toArray($data), $status, $headers, false);
    }
}
