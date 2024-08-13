<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nature extends Model
{
    //

    protected $guarded=[];
    
    public function division(){
        return $this->belongsTo('App\Division');
    }
}
