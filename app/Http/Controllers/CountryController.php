<?php

namespace App\Http\Controllers;

use App\Http\Resources\CountryResource;
use App\Http\Resources\CountryStatisticResource;
use App\Models\Country;
use App\Models\CountryStatistic;
use App\Models\Localization;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function getAll(Request $request)
    {
        return CountryResource::collection(Country::query()->with('localizations')->paginate($request->query('perPage', 15)));
    }

    public function getStatistics()
    {
        return CountryStatisticResource::collection(CountryStatistic::query()->whereDate('created_at', Carbon::today())->with('country')->get());
    }
}
