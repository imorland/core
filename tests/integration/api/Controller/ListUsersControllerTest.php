<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Flarum\Tests\integration\api\Controller;

use Flarum\Api\Controller\ListUsersController;
use Flarum\User\Exception\PermissionDeniedException;
use Flarum\User\User;

class ListUsersControllerTest extends ApiControllerTestCase
{
    protected $controller = ListUsersController::class;

    public function setUp()
    {
        parent::setUp();

        $this->prepareDatabase([
            'users' => [
                $this->adminUser(),
            ],
            'groups' => [
                $this->adminGroup(),
            ],
            'group_user' => [
                ['user_id' => 1, 'group_id' => 1],
            ],
        ]);
    }

    /**
     * @test
     */
    public function disallows_index_for_guest()
    {
        $this->expectException(PermissionDeniedException::class);

        $this->callWith();
    }

    /**
     * @test
     */
    public function shows_index_for_admin()
    {
        $this->actor = User::find(1);

        $response = $this->callWith();

        $this->assertEquals(200, $response->getStatusCode());
    }
}
