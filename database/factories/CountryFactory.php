<?php

namespace Database\Factories;

use App\Models\Localization;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CountryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $cc = $this->faker->countryCode();
        return [
            'country_code' => $cc
        ];
    }
}
