
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import 'vuetify/dist/vuetify.min.css'
import Vuetify from 'vuetify'
import axios from 'axios'
import VueAxios from 'vue-axios'
import Router from 'vue-router'
import VueProgressBar from 'vue-progressbar'
import router from './router/router.js'

Vue.component('maincomponent', require('./components/MainComponent.vue'));
Vue.component('sidebar', require('./components/Sidebar.vue'));
Vue.component('add', require('./components/Add.vue'));
Vue.component('add_mission_fnct', require('./components/fonctionnaire/AddMission.vue'));
Vue.component('demander_attestation', require('./components/fonctionnaire/DemanderAttestation.vue'));
Vue.component('rh_demande_attestation', require('./components/rh/DemandeAttestation.vue'));
Vue.component('add_conge_fnct', require('./components/fonctionnaire/AddConge.vue'));
Vue.component('login', require('./components/Login.vue'));
Vue.component('chauffeur_mission', require('./components/chauffeur/Mission.vue'));
Vue.component('chauffeur', require('./components/chauffeur/Chauffeur.vue'));
Vue.component('chef_mission', require('./components/chef_division/Mission.vue'));
Vue.component('chef_conge', require('./components/chef_division/Conge.vue'));
Vue.component('rh_conge', require('./components/rh/Conge.vue'));
Vue.component('rh_attestation', require('./components/rh/Attestation.vue'));
Vue.component('nature', require('./components/chef_division/Nature.vue'));
Vue.component('sg_mission', require('./components/sg/Mission.vue'));
Vue.component('gv_mission', require('./components/gv/Mission.vue'));
Vue.component('fnct_mission', require('./components/fonctionnaire/Mission.vue'));
Vue.component('fnct_conge', require('./components/fonctionnaire/Conge.vue'));
Vue.component('menParler', require('./components/commun/MenParler.vue'));

Vue.component('generate_conge', require('./components/rh/GenerateConge.vue'));

Vue.use(Vuetify, {
    theme: 
    {
      primary: "#5E35B1",
      secondary: "#9575CD",
      accent: "#9c27b0",
      error: "#f44336",
      warning: "#ffeb3b",
      info: "#7B1FA2",
      success: "#4caf50"
    }
  });

Vue.use(Vuetify,VueAxios,axios,Router)
Vue.use(VueProgressBar, {
    color: 'white',
    failedColor: 'red',
    thickness: '3px'
  })


const app = new Vue({
    el: '#app',
    router,
    // created(){
    //     this.$router.push('login');
    // }
});
