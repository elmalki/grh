<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deplacement extends Model
{
    //

    public function typeDeplacement(){
        return $this->belongsTo('App\Deplacement');
    }
}
