<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diplome extends Model
{
    //

    public function fonctionnaire(){
        return $this->belongsTo('App\Fonctionnaire');
    }
}
