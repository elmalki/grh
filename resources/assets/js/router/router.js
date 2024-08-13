import Vue from 'vue'
import Router from 'vue-router'
import add_mission_fnct  from '../components/fonctionnaire/AddMission.vue'
import add_conge_fnct  from '../components/fonctionnaire/AddConge.vue'
import login from '../components/Login.vue'
import add from '../components/Add.vue'
import chauffeur_mission from '../components/chauffeur/Mission.vue'
import chauffeur from '../components/chauffeur/Chauffeur.vue'
import chef_mission from '../components/chef_division/Mission.vue'
import chef_conge from '../components/chef_division/Conge.vue'
import rh_conge from '../components/rh/Conge.vue'
import rh_attestation from '../components/rh/Attestation.vue'
import nature from '../components/chef_division/Nature.vue'
import sg_mission from '../components/sg/Mission.vue'
import gv_mission from '../components/gv/Mission.vue'
import fnct_mission from '../components/fonctionnaire/Mission.vue'
import demander_attestation from '../components/fonctionnaire/DemanderAttestation.vue'
import rh_demande_attestation from '../components/rh/DemandeAttestation.vue'
import menParler from '../components/commun/MenParler.vue'
import generate_conge from '../components/rh/GenerateConge.vue'
import fnct_conge from '../components/fonctionnaire/Conge.vue'



Vue.use(Router) 

export default new Router({
    mode: 'abstract',
    linkActiveClass: 'primary--text',
    routes: [
        {
            path: '/add_mission_fnct',
            name: 'add_mission_fnct',
            component:add_mission_fnct,
            
        },
        {
            path: '/add_conge_fnct',
            name: 'add_conge_fnct',
            component:add_conge_fnct,
            
        },
        {
            path: '/demander_attestation',
            name: 'demander_attestation',
            component:demander_attestation,
            
        },
        {
            path: '/chauffeur_mission',
            name: 'chauffeur_mission',
            component:chauffeur_mission,
            
        },
        {
            path: '/chauffeur',
            name: 'chauffeur',
            component:chauffeur,
            
        },
        {
            path: '/chef_mission',
            name: 'chef_mission',
            component:chef_mission,
            
        },
        {
            path: '/chef_conge',
            name: 'chef_conge',
            component:chef_conge,
            
        },
        {
            path: '/rh_conge',
            name: 'rh_conge',
            component:rh_conge,
            
        },
        {
            path: '/rh_attestation',
            name: 'rh_attestation',
            component:rh_attestation,
            
        },
        {
            path: '/rh_demande_attestation',
            name: 'rh_demande_attestation',
            component:rh_demande_attestation,
            
        },
        {
            path: '/sg_mission',
            name: 'sg_mission',
            component:sg_mission,
            
        },
        {
            path: '/gv_mission',
            name: 'gv_mission',
            component:gv_mission,
            
        },
        {
            path: '/fnct_mission',
            name: 'fnct_mission',
            component:fnct_mission,
            
        },
        {
            path: '/fnct_conge',
            name: 'fnct_conge',
            component:fnct_conge,
            
        },
        {
            path: '/nature',
            name: 'nature',
            component:nature,
            
        },
        {
            path: '/add_example',
            name: 'add_example',
            component:add,
            
        },
        {
            path: '/menParler',
            name: 'menParler',
            component:menParler,
            
        },
        {
            path: '/generate_conge',
            name: 'generate_conge',
            component:generate_conge,
            
        },
    ]
});
