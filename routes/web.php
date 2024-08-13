<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
})->middleware('auth');

Route::get('/printMission/{id}','MissionController@printMission');
Route::get('/printMissionResume/{id}','MissionController@printMissionResume');
Route::get('/print/{id}','MissionController@print');


Route::post('/saveInfoCivile','FonctionnaireController@saveInfoCivile');
Route::post('/saveInfoConjoints','FonctionnaireController@saveInfoConjoints');
Route::post('/saveInfoEnfants','FonctionnaireController@saveInfoEnfants');
Route::post('/saveInfoDiplomes','FonctionnaireController@saveInfoDiplomes');
Route::post('/saveInfoFormations','FonctionnaireController@saveInfoFormations');
Route::post('/searchFonctionnaireByCin','FonctionnaireController@searchFonctionnaireByCin');
Route::post('/subscribe','FonctionnaireController@subscribe');
Route::get('/getConnectedUser','FonctionnaireController@getConnectedUser');
Route::get('/printAttestationDeTravail/{id}','FonctionnaireController@printAttestationDeTravail');


Route::get('/getMissionEnAttente','MissionController@getMissionEnAttente');
Route::post('/saveMissionChauffeur','MissionController@saveMissionChauffeur');
Route::get('/getMissionByDivision/{id}','MissionController@getMissionByDivision');
Route::get('/getMissionForSG/{statut}','MissionController@getMissionForSG');
Route::get('/getMissionForGV/{statut}','MissionController@getMissionForSG');
Route::get('/getMissionForFnct','MissionController@getMissionForFnct');
Route::post('/completeMission','MissionController@completeMission');
Route::post('/saveMissionFnct','MissionController@saveMissionFnct');
Route::post('/saveMissionObservations','MissionController@saveMissionObservations');
Route::post('/saveMissionInstructions','MissionController@saveMissionInstructions');
Route::post('/saveMissionInstructionsGV','MissionController@saveMissionInstructionsGV');
Route::post('/validerMissionFnct','MissionController@validerMissionFnct');
Route::post('/loadMenParlerList','MissionController@loadMenParlerList');

Route::get('/getMenParlerByAppele/{appele_id}','MenParlerController@getMenParlerByAppele');
Route::post('/saveDescription','MenParlerController@saveDescription');


Route::get('/generateAllConge','CongeController@generateAllConge');
Route::post('/demanderConge','CongeController@demanderConge');
Route::post('/supprimerConge/{id}','CongeController@supprimerConge');
Route::get('/getCongesByFnctID/{id}','CongeController@getCongesByFnctID');
Route::get('/ajouterJourFeries','JourReposController@ajouterJourFeries');
Route::get('/getJourReposByCurrentYear','JourReposController@getJourReposByCurrentYear');
Route::get('/loadCongeForChefDivision/{id}/statut/{statut}','CongeController@loadCongeForChefDivision');
Route::get('/loadCongeForRH/{statut}','CongeController@loadCongeForRH');
Route::post('/changeCongeStatut','CongeController@changeCongeStatut');
Route::get('/getAttestationByFonctionnaireId/{id}','AttestationController@getAttestationByFonctionnaireId');
Route::get('/getDemandeAttestationForRH/{statut}','AttestationController@getDemandeAttestationForRH');
Route::get('/validerDemande/{id}','AttestationController@validerDemande');



Route::post('/addAttestationForFnct','AttestationController@addAttestationForFnct');


Route::post('/changeMissionStatut','MissionController@changeMissionStatut');





Route::get('/test','FonctionnaireController@test');

Route::get('/getNatureByDivision/{id}','NatureController@getNatureByDivision');
Route::resource('divisions','DivisionController');
Route::resource('grades','GradeController');
Route::resource('deplacements','DeplacementController');
Route::resource('type_deplacements','TypeDeplacementController');
Route::resource('chauffeurs','ChauffeurController');
Route::resource('type_vehicules','TypeVehiculeController');
Route::resource('vehicules','VehiculeController');
Route::resource('missions','MissionController');
Route::resource('natures','NatureController');
Route::resource('statuts','StatutController');
Route::resource('attestations','AttestationController');




Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/getConnectedUser', function(){
    return Auth::user();
});

