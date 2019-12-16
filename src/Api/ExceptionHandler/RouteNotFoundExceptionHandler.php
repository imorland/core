<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Flarum\Api\ExceptionHandler;

use Exception;
use Flarum\Http\Exception\RouteNotFoundException;
use Tobscure\JsonApi\Exception\Handler\ExceptionHandlerInterface;
use Tobscure\JsonApi\Exception\Handler\ResponseBag;

class RouteNotFoundExceptionHandler implements ExceptionHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function manages(Exception $e)
    {
        return $e instanceof RouteNotFoundException;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Exception $e)
    {
        $status = 404;
        $error = [
            'status' => (string) $status,
            'code' => 'route_not_found'
        ];

        return new ResponseBag($status, [$error]);
    }
}
