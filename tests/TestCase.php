<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Exception;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;

    private Generator $faker;

    public function setUp(): void
    {

        parent::setUp();
        $this->faker = Factory::create();
        Artisan::call('migrate:refresh');
    }

    public function __get($key)
    {
        if ($key === 'faker')
            return $this->faker;
        throw new Exception('Unknown Key Requested');
    }

    public function getAccessToken(): string
    {
        $payload = [
            'name' => $this->faker->name,
            'password' => Hash::make(Str::random(8)),
            'email' => $this->faker->email
        ];
        $resp = $this->json('post', '/api/auth/signup', $payload)
            ->assertStatus(201);
        $data = json_decode($resp->getContent(), true);
        return $data['data']['accessToken'];
    }
}
