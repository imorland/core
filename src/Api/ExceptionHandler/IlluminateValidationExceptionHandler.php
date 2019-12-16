<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Flarum\Api\ExceptionHandler;

use Exception;
use Illuminate\Validation\ValidationException;
use Tobscure\JsonApi\Exception\Handler\ExceptionHandlerInterface;
use Tobscure\JsonApi\Exception\Handler\ResponseBag;

class IlluminateValidationExceptionHandler implements ExceptionHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function manages(Exception $e)
    {
        return $e instanceof ValidationException;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Exception $e)
    {
        $status = 422;

        $errors = $this->formatErrors($e->errors());

        return new ResponseBag($status, $errors);
    }

    /**
     * @param array $errors
     * @return array
     */
    protected function formatErrors(array $errors)
    {
        $errors = array_map(function ($field, $messages) {
            return [
                'status' => '422',
                'code' => 'validation_error',
                'detail' => implode("\n", $messages),
                'source' => ['pointer' => "/data/attributes/$field"]
            ];
        }, array_keys($errors), $errors);

        return $errors;
    }
}
