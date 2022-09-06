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
    }

    public function testUsersIndex(): void
    {
        User::factory(1)->create();
        $response = $this->get(route('users.index'));
        var_dump($response->json());
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

    public function testUsersShow(): void
    {
        $user = User::factory(1)->create()->first();

        $response = $this->get(route('users.show', [$user->getKey()]));  /** @phpstan-ignore-line */

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'name',
                    'email',
                    'photo',
                ],
            ]);
    }

    public function testUsersShow404(): void
    {
        $response = $this->get(route('users.show', 1));
        $response->assertStatus(404);
    }

}
