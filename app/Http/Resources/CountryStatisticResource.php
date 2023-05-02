<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CountryStatisticResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'country' => CountryResource::make($this->country),
            'confirmed' => $this->confirmed,
            'recovered' => $this->recovered,
            'critical' => $this->critical,
            'deaths' => $this->deaths,
            'date' => $this->created_at
        ];
    }
}
