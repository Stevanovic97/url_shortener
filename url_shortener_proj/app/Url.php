<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    protected $fillable = ['original', 'short', 'detail'];

    public function visitors()
    {
        return $this->belongsToMany(Visitor::class);
    }
}
