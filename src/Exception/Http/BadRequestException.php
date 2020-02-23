<?php
declare(strict_types=1);

namespace App\Exception\Http;

use App\Exception\UserFriendlyExceptionInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * @package App\Exception\Http
 */
class BadRequestException extends BadRequestHttpException implements UserFriendlyExceptionInterface
{
}