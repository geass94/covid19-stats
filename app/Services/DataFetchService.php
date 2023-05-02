<?php

namespace App\Services;

interface DataFetchService
{
    public function fetchCountries(): array;
    public function fetchCountryStats(string $cc): array;
}
