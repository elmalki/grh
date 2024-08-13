<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Attestation;

class AttestationFonctionnaire extends Model
{
    //
    protected $guarded =[];
    protected $appends = ['libelle','fonctionnaire',''];
    protected $table='attestation_fonctionnaire';

    public function getLibelleAttribute()
    {
        return Attestation::find($this->attestation_id)->libelle;
    }

    public function getFonctionnaireAttribute()
    {
        $fonctionnaire = Fonctionnaire::find($this->fonctionnaire_id);
        return $fonctionnaire->nom." ".$fonctionnaire->prenom;
    }
}
