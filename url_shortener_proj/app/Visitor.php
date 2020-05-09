<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = ['ip_address', 'url'];

    public function urls()
    {
        return $this->belongsToMany('App\Url');
    }
}
