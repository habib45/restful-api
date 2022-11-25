<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Users;

class UsersApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_users()
    {
        $users = Users::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/users', $users
        );

        $this->assertApiResponse($users);
    }

    /**
     * @test
     */
    public function test_read_users()
    {
        $users = Users::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/users/'.$users->id
        );

        $this->assertApiResponse($users->toArray());
    }

    /**
     * @test
     */
    public function test_update_users()
    {
        $users = Users::factory()->create();
        $editedUsers = Users::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/users/'.$users->id,
            $editedUsers
        );

        $this->assertApiResponse($editedUsers);
    }

    /**
     * @test
     */
    public function test_delete_users()
    {
        $users = Users::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/users/'.$users->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/users/'.$users->id
        );

        $this->response->assertStatus(404);
    }
}
