<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    //

    public function chef_division(){
        return Fonctionnaire::where('division_id',$this->id)->where('profil_id',2)->get()->first();
        
    }

    public function natures(){
        return $this->hasMany('App\Nature');
    }

    public function fonctionnaires(){
        return $this->hasMany('App\Fonctionnaire');
    }
}
