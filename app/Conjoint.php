<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conjoint extends Model
{
    //

    public function fonctionnaire(){
        return $this->belongsTo('App\Fonctionnaire');
    }
}
