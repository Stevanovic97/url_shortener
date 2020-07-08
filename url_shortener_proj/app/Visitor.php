<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Visitor extends Model
{
    protected $fillable = ['cookie', 'url'];

    public function urls()
    {
        return $this->belongsToMany(Url::class);
    }
}
