<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenParler extends Model
{
    //
    protected $guarded = [];

    public function mission(){
        return $this->belongsTo('App\Mission');
    }

    public function appelant(){
        return $this->belongsTo('App\Fonctionnaire');
    }
}