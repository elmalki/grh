<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attestation extends Model
{
    //

    protected $fillable = ['libelle'];
    public function fonctionnaires(){
        return $this->belongsTomany('App\Fonctionnaire');
    }
}
