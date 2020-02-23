<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Dto\Request\Warehouse\WarehouseAddRequest;
use App\Dto\Request\Warehouse\WarehouseUpdateRequest;
use App\Service\Entity\WarehouseRequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Throwable;

/**
 * @package App\Controller\Api
 */
class WarehouseController extends AbstractApiController
{
    /**
     * @var WarehouseRequestService
     */
    private $requestService;

    /**
     * @param WarehouseRequestService $requestService
     */
    public function __construct(WarehouseRequestService $requestService)
    {
        $this->requestService = $requestService;
    }

    /**
     * @param WarehouseAddRequest $request
     *
     * @throws Throwable
     * @return JsonResponse
     */
    public function create(WarehouseAddRequest $request): JsonResponse
    {
        return $this->createJsonResponse(
            $this->requestService->add($request),
            JsonResponse::HTTP_CREATED
        );
    }

    /**
     * @param string $code
     *
     * @return JsonResponse
     */
    public function read(string $code): JsonResponse
    {
        return $this->createJsonResponse($this->requestService->getActiveByCode($code));
    }

    /**
     * @param string                 $code
     * @param WarehouseUpdateRequest $request
     *
     * @throws Throwable
     * @return JsonResponse
     */
    public function update(string $code, WarehouseUpdateRequest $request): JsonResponse
    {
        $request->setCode($code);

        return $this->createJsonResponse($this->requestService->update($request));
    }

    /**
     * @param string $code
     *
     * @throws Throwable
     * @return JsonResponse
     */
    public function delete(string $code): JsonResponse
    {
        return $this->createJsonResponse($this->requestService->delete($code));
    }
}