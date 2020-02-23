<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Dto\Request\Warehouse\WarehouseAddRequest;
use App\Dto\Request\Warehouse\WarehouseUpdateRequest;
use App\Dto\Response\ErrorResponse;
use App\Enum\ApiHeader;
use App\Exception\Http\BadRequestException;
use App\Service\Entity\WarehouseRequestService;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
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
     * @SWG\Tag(name="warehouse")
     *
     * @SWG\Parameter(
     *     in="header",
     *     name=ApiHeader::API_KEY,
     *     description="API-token",
     *     type="string",
     *     required=true
     * )
     * @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="Данные склада",
     *     @Model(type=WarehouseAddRequest::class)
     * )
     * @SWG\Response(
     *     response=JsonResponse::HTTP_CREATED,
     *     description="Склад успешно создан",
     *     @Model(type=WarehouseDto::class)
     * )
     * @SWG\Response(
     *     response=JsonResponse::HTTP_BAD_REQUEST,
     *     description="Ошибка валидации",
     *     @Model(type=ErrorResponse::class)
     * )
     * @SWG\Response(
     *     response=JsonResponse::HTTP_UNAUTHORIZED,
     *     description="Api-ключ некорректен",
     *     @Model(type=ErrorResponse::class)
     * )
     * @SWG\Response(
     *     response=JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
     *     description="Ошибка при создании",
     *     @Model(type=ErrorResponse::class)
     * )
     *
     * @Route("", methods={Request::METHOD_POST}, name="create")
     *
     *
     * @throws BadRequestException
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