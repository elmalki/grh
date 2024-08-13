<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Fonctionnaire extends Authenticatable
{
    use Notifiable;
    protected $with = ['division'];
    protected $hidden = ['password','remember_token'];
    protected $fillable=['cin','nom','prenom','division_id','grade_id','password'];

    public function conjoints(){
        return $this->hasMany('App\Conjoint');

    }

    public function enfants(){
        return $this->hasMany('App\Enfants');

    }

    public function diplomes(){
        return $this->hasMany('App\Diplomes');

    }

    public function formations(){
        return $this->hasMany('App\Formations');

    }

    public function division(){
        return $this->belongsTo('App\Division');

    }

    public function grade(){
        return $this->belongsTo('App\Grade');

    }

    public function profil(){
        return $this->belongsTo('App\Profil');
    }

    public function conges(){
        return $this->hasMany('App\Conge');
    }

    public function attestations(){
        return $this->belongsTomany('App\Attestation')->withPivot('statut','nombre','id')->withTimestamps();
    }
}
