<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $localizations = [];
        foreach ($this->localizations as $localization) {
            $localizations[$localization->locale] = $localization->title;
        }
        return [
            'id' => $this->id,
            'name' => $localizations,
            'code' => $this->country_code
        ];
    }
}
