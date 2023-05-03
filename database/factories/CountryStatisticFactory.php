<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Localization;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CountryStatisticFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'country_id' => Country::factory()->has(Localization::factory()->count(10)),
            'confirmed' => rand(0, 10000),
            'recovered' => rand(0, 10000),
            'critical' => rand(0, 10000),
            'deaths' => rand(0, 10000)
        ];
    }
}
