<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statut extends Model
{
    //

    public function missions(){
        return $this->belongsToMany('App\Mission');
    }
}
