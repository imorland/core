<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Flarum\Api\ExceptionHandler;

use Exception;
use Flarum\Api\Exception\InvalidAccessTokenException;
use Tobscure\JsonApi\Exception\Handler\ExceptionHandlerInterface;
use Tobscure\JsonApi\Exception\Handler\ResponseBag;

class InvalidAccessTokenExceptionHandler implements ExceptionHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function manages(Exception $e)
    {
        return $e instanceof InvalidAccessTokenException;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Exception $e)
    {
        $status = 401;
        $error = [
            'status' => (string) $status,
            'code' => 'invalid_access_token'
        ];

        return new ResponseBag($status, [$error]);
    }
}
