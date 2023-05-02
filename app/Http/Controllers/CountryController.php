<?php

namespace App\Http\Controllers;

use App\Http\Resources\CountryResource;
use App\Models\Country;
use App\Models\Localization;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function getAll(Request $request)
    {
        return CountryResource::collection(Country::query()->with('localizations')->paginate($request->query('perPage', 15)));
    }

    public function getStatistics(int $countryId)
    {

    }
}
