<?php

namespace Tests\Unit;

use App\Models\Country;
use App\Models\CountryStatistic;
use App\Models\Localization;
use Tests\TestCase;

class CountriesApiTest extends TestCase
{
    public function test_it_returns_401_when_access_token_is_missing()
    {
        $this->json('get', '/api/countries', [], [
            'Authorization' => 'Bearer '
        ])->assertStatus(401);

        $this->json('get', '/api/countries/statistics', [], [
            'Authorization' => 'Bearer '
        ])->assertStatus(401);
    }

    public function test_it_returns_200_and_array_of_countries()
    {
        $this->seedCountries();
        $this->json('get', '/api/countries', [], [
            'Authorization' => 'Bearer ' . $this->getAccessToken()
        ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'name' => [
                            'en',
                            'ka'
                        ],
                        'code'
                    ]
                ]
            ]);
    }

    public function test_it_returns_array_of_statistics_for_countries()
    {
        $this->seedStatistics();
        $this->json('get', '/api/countries/statistics', [], [
            'Authorization' => 'Bearer ' . $this->getAccessToken()
        ])->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'country' => [
                            'name' => [
                                'en',
                                'ka'
                            ],
                            'code'
                        ],
                        'confirmed',
                        'recovered',
                        'critical',
                        'deaths',
                        'date'
                    ]
                ]
            ]);
    }


    private function seedCountries()
    {
        Country::factory()->has(Localization::factory()->count(10))->count(10)->create();
    }

    private function seedStatistics()
    {
        CountryStatistic::factory()->has(Country::factory()->count(10))->count(10)->create();
    }

}
