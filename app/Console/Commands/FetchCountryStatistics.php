<?php

namespace App\Console\Commands;

use App\Models\Country;
use App\Models\CountryStatistic;
use App\Services\Impl\Devtestge;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class FetchCountryStatistics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:country:stats';

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
        Country::query()->chunk(10, function ($rows) use ($api) {
            foreach ($rows as $country) {
                $res = $api->fetchCountryStats($country->country_code);
                logger('RESPONSE', $res);
                CountryStatistic::query()->updateOrCreate(['country_id' => $country->id], [
                    'country_id' => $country->id,
                    'confirmed' => $res['confirmed'],
                    'recovered' => $res['recovered'],
                    'critical' => $res['critical'],
                    'deaths' => $res['deaths'],
                ]);
            }
        });

        return 0;
    }
}
