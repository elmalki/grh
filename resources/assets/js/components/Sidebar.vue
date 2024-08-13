<template>
  <v-navigation-drawer app clipped v-model="drawer">
    <v-list dense class="pt-0">
      <v-divider></v-divider>
      <v-subheader class="primary--text">Fonctionnaire</v-subheader>
      <v-list-tile avatar>
        <v-avatar color="grey lighten-4">
          <img src="../images/avatar.png" alt>
        </v-avatar>
        <v-list-tile-title class="ml-3" v-text="fonctionnaire.nom"></v-list-tile-title>
      </v-list-tile>
      <br>
      <v-divider></v-divider>
      <v-subheader class="primary--text">Traitement</v-subheader>
      <v-divider></v-divider>
      <router-link tag="v-list-tile" to="/fnct_mission" v-if="fonctionnaire.profil_id == 1" class="pl-3">
        <v-list-tile-action>
          <v-icon>directions_bike</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>
          <v-list-tile-title>Mission Fnct</v-list-tile-title>
        </v-list-tile-content>
      </router-link>
      <router-link tag="v-list-tile" to="/add_mission_fnct" v-if="fonctionnaire.profil_id == 1" class="pl-3">
        <v-list-tile-action>
          <v-icon>add</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>
          <v-list-tile-title>Ajouter Mission Fnct</v-list-tile-title>
        </v-list-tile-content>
      </router-link>
      <router-link tag="v-list-tile" to="/chauffeur_mission" v-if="fonctionnaire.profil_id == 6" class="pl-3">
        <v-list-tile-action>
          <v-icon>local_taxi</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>
          <v-list-tile-title>Chauffeur Mission</v-list-tile-title>
        </v-list-tile-content>
      </router-link>
      <router-link tag="v-list-tile" to="/chauffeur" v-if="fonctionnaire.profil_id == 6" class="pl-3">
        <v-list-tile-action>
          <v-icon>local_taxi</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>
          <v-list-tile-title>Gestion Chauffeurs</v-list-tile-title>
        </v-list-tile-content>
      </router-link>
      <router-link tag="v-list-tile" to="/chef_mission" v-if="fonctionnaire.profil_id == 2" class="pl-3">
        <v-list-tile-action>
          <v-icon>directions_bike</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>
          <v-list-tile-title>Chef Division Mission</v-list-tile-title>
        </v-list-tile-content>
      </router-link>
      <router-link tag="v-list-tile" to="/nature" v-if="fonctionnaire.profil_id == 2" class="pl-3">
        <v-list-tile-action>
          <v-icon>art_track</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>
          <v-list-tile-title>Natures</v-list-tile-title>
        </v-list-tile-content>
      </router-link>
      <!-- v-if="fonctionnaire.profil_id == 3" -->
      <router-link tag="v-list-tile" to="/sg_mission" v-if="fonctionnaire.profil_id == 3" class="pl-3" >
        <v-list-tile-action>
          <v-icon>touch_app</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>
          <v-list-tile-title>M.Secrétaire Général Mission</v-list-tile-title>
        </v-list-tile-content>
      </router-link>
      <router-link tag="v-list-tile" to="/gv_mission" v-if="fonctionnaire.profil_id == 4" class="pl-3">
        <v-list-tile-action>
          <v-icon>local_library</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>
          <v-list-tile-title>M.Gouverneur Mission</v-list-tile-title>
        </v-list-tile-content>
      </router-link>
      <router-link tag="v-list-tile" to="/menParler" v-if="fonctionnaire.profil_id == 1 || fonctionnaire.profil_id == 2 || fonctionnaire.profil_id == 3" class="pl-3">
        <v-list-tile-action>
          <v-icon>local_library</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>
          <v-list-tile-title>M'en Parler</v-list-tile-title>
        </v-list-tile-content>
      </router-link>
      <router-link tag="v-list-tile" to="/add_conge_fnct" v-if="fonctionnaire.profil_id == 1" class="pl-3">
        <v-list-tile-action>
          <v-icon>local_library</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>
          <v-list-tile-title>Demander Congé</v-list-tile-title>
        </v-list-tile-content>
      </router-link>
      <router-link tag="v-list-tile" to="/generate_conge" v-if="fonctionnaire.profil_id == 5" class="pl-3">
        <v-list-tile-action>
          <v-icon>local_library</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>
          <v-list-tile-title>Affecter Congés</v-list-tile-title>
        </v-list-tile-content>
      </router-link>
      <router-link tag="v-list-tile" to="/fnct_conge" v-if="fonctionnaire.profil_id == 1" class="pl-3">
        <v-list-tile-action>
          <v-icon>local_library</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>
          <v-list-tile-title>Liste des Congés Fnct</v-list-tile-title>
        </v-list-tile-content>
      </router-link>
      <router-link tag="v-list-tile" to="/chef_conge" v-if="fonctionnaire.profil_id == 2" class="pl-3">
        <v-list-tile-action>
          <v-icon>directions_bike</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>
          <v-list-tile-title>Chef Division Conge</v-list-tile-title>
        </v-list-tile-content>
      </router-link>
      <router-link tag="v-list-tile" to="/rh_conge" v-if="fonctionnaire.profil_id == 5" class="pl-3">
        <v-list-tile-action>
          <v-icon>directions_bike</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>
          <v-list-tile-title>RH Conge</v-list-tile-title>
        </v-list-tile-content>
      </router-link>
      <router-link tag="v-list-tile" to="/rh_attestation" v-if="fonctionnaire.profil_id == 5" class="pl-3">
        <v-list-tile-action>
          <v-icon>directions_bike</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>
          <v-list-tile-title>RH Attestation</v-list-tile-title>
        </v-list-tile-content>
      </router-link>
      <router-link tag="v-list-tile" to="/rh_demande_attestation" v-if="fonctionnaire.profil_id == 5" class="pl-3">
        <v-list-tile-action>
          <v-icon>directions_bike</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>
          <v-list-tile-title>RH Demande Attestation</v-list-tile-title>
        </v-list-tile-content>
      </router-link>
      <router-link tag="v-list-tile" to="/demander_attestation" v-if="fonctionnaire.profil_id == 1" class="pl-3">
        <v-list-tile-action>
          <v-icon>directions_bike</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>
          <v-list-tile-title>Demander Attestation</v-list-tile-title>
        </v-list-tile-content>
      </router-link>
      <!-- <router-link  tag="v-list-tile" to="/add_example" class="pl-3">
        <v-list-tile-action>
          <v-icon>local_library</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>
          <v-list-tile-title>
            Add
          </v-list-tile-title>
        </v-list-tile-content>
      </router-link> -->
    </v-list>
  </v-navigation-drawer>
</template>
<script>

export default {
  props: ["drawer"],
    data() {
    return {
      fonctionnaire: ""
    };
  },
   created() {
    axios
      .get("/getConnectedUser")
      .then(response => {
        // JSON responses are automatically parsed.
        this.fonctionnaire = response.data;
        console.log("Sidebar");
        console.log(this.fonctionnaire);
      })
      .catch(e => {
        this.errors.push(e);
      });
  },
};
</script>

