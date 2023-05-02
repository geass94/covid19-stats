<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localization extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body', 'locale'];

    public function localizable()
    {
        return $this->morphTo();
    }
}
