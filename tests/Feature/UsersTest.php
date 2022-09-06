<?php

namespace Tests\Feature;


use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * @group users
 * @group ci
 * */
class UsersTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('s3');
    }

    public function testUsersIndex()
    {
        User::factory(1)->create();
        $response = $this->get(route('users.index'));
        $response->assertStatus(200)
            ->assertJsonStructure([
            'data' => [
                [
                    'name',
                    'email',
                    'photo',
                ],
            ],
        ]);
    }

    public function testUsersShow()
    {
        $user = User::factory(1)->create()->first();

        $response = $this->get(route('users.show', [$user->getKey()]));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'name',
                    'email',
                    'photo',
                ],
            ]);
    }

    public function testUsersShow404()
    {
        $response = $this->get(route('users.show', 1));
        $response->assertStatus(404);
    }

}
