<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enfant extends Model
{
    //

    protected $guarded=['conjoint'];

    public function fonctionnaire(){
        return $this->belongsTo('App\Fonctionnaire');
    }

    public function conjoint(){
        return $this->belongsTo('App\Conjoint');
    }
}
