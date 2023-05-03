<?php

namespace Tests\Unit;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;


class AuthorizationApiTest extends TestCase
{
    public function test_signup_returns_422_when_incomplete_payload()
    {
        $this->json('post', '/api/auth/signup', [
            'name' => $this->faker->name,
        ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->json('post', '/api/auth/signup', [
            'password' => Str::random(8),
        ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->json('post', '/api/auth/signup', [
            'email' => $this->faker->email
        ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->json('post', '/api/auth/signup', [
            'name' => $this->faker->name,
            'password' => Str::random(8),
        ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->json('post', '/api/auth/signup', [
            'name' => $this->faker->name,
            'email' => $this->faker->email
        ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_signup_returns_201_and_auth_resource_when_user_is_registered()
    {
        $payload = [
            'name' => $this->faker->name,
            'password' => Hash::make(Str::random(8)),
            'email' => $this->faker->email
        ];
        $this->json('post', '/api/auth/signup', $payload)
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'data' => [
                    'user' => [
                        'id',
                        'name',
                        'email',
                    ],
                    'accessToken'
                ]
            ]);
        unset($payload['password']);
        $this->assertDatabaseHas('users', $payload);
    }

    public function test_login_returns_200_and_auth_resource_when_logged_in()
    {
        $payload = [
            'name' => $this->faker->name,
            'password' => Hash::make(Str::random(8)),
            'email' => $this->faker->email
        ];
        $this->json('post', '/api/auth/signup', $payload)->assertStatus(Response::HTTP_CREATED);
        $this->json('post', '/api/auth/login', [
            'email' => $payload['email'],
            'password' => $payload['password']
        ])->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'user' => [
                        'id',
                        'name',
                        'email',
                    ],
                    'accessToken'
                ]
            ]);
    }

    public function test_whoami_returns_401_when_token_is_missing()
    {
        $this->json('get', '/api/user', [], [
            'Authorization' => ''
        ])
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_whoami_returns_200_and_user_resource_when_token_is_present()
    {
        $payload = [
            'name' => $this->faker->name,
            'password' => Hash::make(Str::random(8)),
            'email' => $this->faker->email
        ];
        $response = $this->json('post', '/api/auth/signup', $payload)->getContent();
        $auth = json_decode($response, true);
        logger('AUTH', [$auth]);
        $this->json('get', '/api/user', [], [
            'Authorization' => 'Bearer ' . $auth['data']['accessToken']
        ])
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email'
                ]
            ]);
    }
}
