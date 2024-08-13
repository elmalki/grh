<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JourRepos;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class JourReposController extends Controller
{
    //

    public function ajouterJourFeries(){
        $now = Carbon::now();
        JourRepos::insert([
            ['jourRepos' => $now->year.'-01-01','created_at' => $now],
            ['jourRepos' => $now->year.'-01-11','created_at' => $now],
            ['jourRepos' => $now->year.'-05-01','created_at' => $now],
            ['jourRepos' => $now->year.'-07-30','created_at' => $now],
            ['jourRepos' => $now->year.'-08-14','created_at' => $now],
            ['jourRepos' => $now->year.'-08-20','created_at' => $now],
            ['jourRepos' => $now->year.'-08-21','created_at' => $now],
            ['jourRepos' => $now->year.'-11-06','created_at' => $now],
            ['jourRepos' => $now->year.'-11-18','created_at' => $now]
        ]);

        return response()->json([
            'message' => 'L\'ensemble des jours féries est généré avec succées'
        ]);
    }

    public function getJourReposByCurrentYear(){
        $now = Carbon::now();
        $jourRepos = DB::table('jour_repos')->whereYear('jourRepos',$now->year)->get();
        return $jourRepos->pluck('jourRepos');
    }
}
