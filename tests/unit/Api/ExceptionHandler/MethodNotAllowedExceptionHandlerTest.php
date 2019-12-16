<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Flarum\Tests\unit\Api\ExceptionHandler;

use Exception;
use Flarum\Api\ExceptionHandler\MethodNotAllowedExceptionHandler;
use Flarum\Http\Exception\MethodNotAllowedException;
use PHPUnit\Framework\TestCase;

class MethodNotAllowedExceptionHandlerTest extends TestCase
{
    private $handler;

    public function setUp()
    {
        $this->handler = new MethodNotAllowedExceptionHandler();
    }

    public function test_it_handles_recognisable_exceptions()
    {
        $this->assertFalse($this->handler->manages(new Exception));
        $this->assertTrue($this->handler->manages(new MethodNotAllowedException()));
    }

    public function test_managing_exceptions()
    {
        $response = $this->handler->handle(new MethodNotAllowedException);

        $this->assertEquals(405, $response->getStatus());
        $this->assertEquals([
            [
                'status' => '405',
                'code' => 'method_not_allowed'
            ]
        ], $response->getErrors());
    }
}
