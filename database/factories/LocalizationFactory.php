<?php

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocalizationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $localizable = $this->localizable();
        $country = $this->faker->country();
        $locales = ['en', 'ka'];
        return [
            'locale' => $locales[rand(0,1)],
            'title' => $country,
            'localizable_id' => $localizable::factory(),
            'localizable_type' => $localizable,
        ];
    }

    public function localizable()
    {
        return $this->faker->randomElement([
            Country::class,
        ]);
    }
}
