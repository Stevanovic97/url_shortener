<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    protected $fillable = ['original', 'short'];

    public function visitors()
    {
        return $this->belongsToMany('App\Visitor');
    }
}
