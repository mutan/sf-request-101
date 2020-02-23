<?php
declare(strict_types=1);

namespace App\Exception\Http;

use App\Exception\UserFriendlyExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @package App\Exception\Http
 */
class NotFoundException extends NotFoundHttpException implements UserFriendlyExceptionInterface
{
}
