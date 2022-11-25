<?php namespace Tests\Repositories;

use App\Models\Users;
use App\Repositories\UsersRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class UsersRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var UsersRepository
     */
    protected $usersRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->usersRepo = \App::make(UsersRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_users()
    {
        $users = Users::factory()->make()->toArray();

        $createdUsers = $this->usersRepo->create($users);

        $createdUsers = $createdUsers->toArray();
        $this->assertArrayHasKey('id', $createdUsers);
        $this->assertNotNull($createdUsers['id'], 'Created Users must have id specified');
        $this->assertNotNull(Users::find($createdUsers['id']), 'Users with given id must be in DB');
        $this->assertModelData($users, $createdUsers);
    }

    /**
     * @test read
     */
    public function test_read_users()
    {
        $users = Users::factory()->create();

        $dbUsers = $this->usersRepo->find($users->id);

        $dbUsers = $dbUsers->toArray();
        $this->assertModelData($users->toArray(), $dbUsers);
    }

    /**
     * @test update
     */
    public function test_update_users()
    {
        $users = Users::factory()->create();
        $fakeUsers = Users::factory()->make()->toArray();

        $updatedUsers = $this->usersRepo->update($fakeUsers, $users->id);

        $this->assertModelData($fakeUsers, $updatedUsers->toArray());
        $dbUsers = $this->usersRepo->find($users->id);
        $this->assertModelData($fakeUsers, $dbUsers->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_users()
    {
        $users = Users::factory()->create();

        $resp = $this->usersRepo->delete($users->id);

        $this->assertTrue($resp);
        $this->assertNull(Users::find($users->id), 'Users should not exist in DB');
    }
}
