<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conge extends Model
{
    //

    protected $guarded = [];
    protected $with = ['fonctionnaire'];

    public function fonctionnaire(){
        return $this->belongsTo('App\Fonctionnaire');
    }
}
