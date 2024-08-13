<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MenParler;
use App\Fonctionnaire;
use App\Statut;

class Mission extends Model
{
    //
    protected $guarded=[];

    protected $appends = ['appele_id_sg','appele_id_gv','current_statut'];

    public function getAppeleIdSgAttribute(){
        $sg = Fonctionnaire::where('profil_id','3')->get()->first();
        $appeleBySg = MenParler::where(['mission_id' => $this->id,'appelant_id' => $sg->id])->get()->first();
        if($appeleBySg)
            return Fonctionnaire::find($appeleBySg->appele_id)->id;

        return '-1';
    }

    public function getAppeleIdGvAttribute(){
        $gv = Fonctionnaire::where('profil_id','4')->get()->first();
        $appeleByGv = MenParler::where(['mission_id' => $this->id,'appelant_id' => $gv->id])->get()->first();
        if($appeleByGv)
            return Fonctionnaire::find($appeleByGv->appele_id)->id;

        return '-1';
    }


    public function statuts(){
        return $this->belongsToMany('App\Statut');
    }

    public function getCurrentStatutAttribute(){
        return Statut::find($this->statut)->libelle;
    }

    public function fonctionnaire(){
        return $this->belongsTo('App\Fonctionnaire');
    }

    public function deplacement(){
        return $this->belongsTo('App\Deplacement');
    }

    public function chauffeur(){
        return $this->belongsTo('App\Chauffeur');
    }

    public function type_vehicule(){
        return $this->belongsTo('App\TypeVehicule');
    }

    public function vehicule(){
        return $this->belongsTo('App\Vehicule');
    }

    public function division(){
        return $this->belongsTo('App\Division');
    }

    public function nature(){
        return $this->belongsTo('App\Nature');
    }
}