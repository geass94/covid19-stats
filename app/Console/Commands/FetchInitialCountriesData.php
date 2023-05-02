<?php

namespace App\Console\Commands;

use App\Models\Country;
use App\Services\Impl\Devtestge;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class FetchInitialCountriesData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:countries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(Devtestge $api)
    {
        if (Country::query()->exists()) return 0;
        $res = [];
        try {
            $res = $api->fetchCountries();
        } catch (\Exception $exception) {

        }

        foreach ($res as $data) {
            $country = new Country();
            $country->country_code = strtoupper($data['code']);
            $country->save();
            $localizations = [];
            $locales = array_keys($data['name']);
            foreach ($locales as $locale) {
                $localizations[] = [
                    'locale' => strtolower($locale),
                    'title' => $data['name'][$locale]
                ];
            }
            echo "Created Country[$country->country_code]";
            $country->localizations()->createMany($localizations);
        }
        return 0;
    }
}
