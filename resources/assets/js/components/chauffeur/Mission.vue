<template>
    <v-layout row wrap>
        <v-flex xs12 v-if="showMissionDetails">
            <v-btn fab right color="brown" dark fixed @click.stop="back">
                <v-icon>arrow_back</v-icon>
            </v-btn>
            <br>
            <v-container grid-list-md>

                <v-layout row wrap>

                    <v-flex xs2>
                        <v-card>
                            <v-card-media src="../images/avatar.png" height="270px">
                            </v-card-media>
                            <v-card-title primary-title>
                                <div>
                                    <h3 class="headline mb-0">{{selectedMission.fonctionnaire.nom.toUpperCase()}}
                                        {{selectedMission.fonctionnaire.prenom.toUpperCase()}}</h3>
                                    <v-divider></v-divider>
                                    <br>
                                    <div class="ml-3">
                                        <v-icon class="mr-3" color="teal darken-2">phone</v-icon> <span class="subheading">{{selectedMission.fonctionnaire.tel1}}</span>
                                        <br>
                                        <br>
                                        <v-icon class="mr-3" color="blue darken-2">chat</v-icon>
                                        <span class="subheading">
                                            test
                                        </span>
                                    </div>
                                </div>
                            </v-card-title>
                        </v-card>
                    </v-flex>
                    <v-flex xs10>
                        <v-chip class="headline" color="blue-grey lighten-3">
                            <v-icon class="pr-3">flight_takeoff</v-icon>
                            Détails de la Mission
                        </v-chip>
                        <v-divider></v-divider>
                        <br>
                        <v-card>
                            <v-card-title>
                                <v-layout row wrap>
                                    <v-flex xs12>
                                        <v-text-field label="Déstination" v-model="selectedMission.deplacement.destination" readonly prepend-icon="place"> 
                                        </v-text-field>
                                        <v-text-field label="Date Départ" v-model="selectedMission.dateDepart" readonly prepend-icon="update">
                                        </v-text-field>
                                        <v-select :items="chauffeurItems" v-model="selectedMission.chauffeur_id" label="Chauffeur" 
                                            item-value="id" item-text="nom" single-line prepend-icon="airline_seat_recline_normal"></v-select>
                                            <v-select :items="vehiculeItems" v-model="selectedMission.vehicule_id" label="Véhicule" 
                                            item-value="id" item-text="numero" single-line prepend-icon="vpn_key"></v-select>
                                    </v-flex>

                                </v-layout>

                            </v-card-title>
                            <v-divider></v-divider>
                            <v-card-actions>
                                <v-flex xs8 offset-xs2>
                        
                            <v-btn color="success" large block @click="saveMission">Enregistrer</v-btn>
                            
                        </v-flex>
                            </v-card-actions>
                        </v-card>
                        <br>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-flex>
        <v-flex xs10 offset-xs1 v-if="!showMissionDetails">
            <v-chip class="headline" color="blue-grey lighten-3">
                <v-icon class="pr-3">list</v-icon>
                Liste Des Missions
            </v-chip>
            <v-divider></v-divider>
            <br>
            <v-text-field append-icon="search" label="Chercher Une Mission" v-model="search"></v-text-field>
            <v-data-table :headers="headers" :items="missionItems" hide-actions class="elevation-1" :search="search"
                no-results-text="Aucun Enregistrement trouvé" no-data-text="La Liste est Vide">
                <template slot="items" slot-scope="props">
                    <tr style="cursor: pointer">
                        <td v-bind:class="{'cell_red' : (props.item.chauffeur == null)}" @click.stop="showMission(props.item)">{{ props.item.dateDepart }}</td>
                        <td v-bind:class="{'cell_red' : (props.item.chauffeur == null)}" @click.stop="showMission(props.item)">{{ props.item.fonctionnaire.nom }}</td>
                        <td v-bind:class="{'cell_red' : (props.item.chauffeur == null)}" @click.stop="showMission(props.item)">{{ props.item.fonctionnaire.prenom }}</td>
                        <td v-bind:class="{'cell_red' : (props.item.chauffeur == null)}" @click.stop="showMission(props.item)">{{ props.item.fonctionnaire.tel1 }}</td>
                        <td v-bind:class="{'cell_red' : (props.item.chauffeur == null)}" @click.stop="showMission(props.item)">{{ props.item.deplacement.destination }}</td>
                        <td v-bind:class="{'cell_red' : (props.item.chauffeur == null)}" @click.stop="showMission(props.item)"><span v-if="props.item.chauffeur">{{ props.item.chauffeur.nom }}</span></td>
                        <td v-bind:class="{'cell_red' : (props.item.chauffeur == null)}" @click.stop="showMission(props.item)"><span v-if="props.item.vehicule">{{ props.item.vehicule.marque+"/"+props.item.vehicule.numero }}</span></td>
                    </tr>
                </template>
            </v-data-table>
        </v-flex>
        <v-snackbar top right :timeout="timeout" :color="snackbar_color" v-model="snackbar">
            {{ snackbar_message }}
            <v-btn dark flat @click.native="snackbar = false">
                <v-icon>close</v-icon>
            </v-btn>
        </v-snackbar>
    </v-layout>
</template>
<script>
export default {
  data() {
    return {
      headers: [
        {
          align: "left",
          text: "Date Départ",
          value: "dateDepart",
          width: "150px"
        },
        {
          align: "left",
          text: "Nom",
          sortable: false,
          value: "fonctionnaire.nom"
        },
        {
          align: "left",
          text: "Prénom",
          sortable: false,
          value: "fonctionnaire.prenom"
        },
        {
          align: "left",
          text: "Téléphone",
          sortable: false,
          value: "fonctionnaire.tel1"
        },
        {
          align: "left",
          text: "Déstination",
          value: "deplacement.destination"
        },
        {
          align: "left",
          text: "Chauffeur",
          value: "chauffeur.nom"
        },
        {
          align: "left",
          text: "Véhicule",
          value: "vehicule.numero"
        }
      ],
      showMissionDetails: false,
      selectedMission: null,
      selectedMissionIndex: "-1",
      search: "",
      snackbar: false,
      timeout: 5000,
      snackbar_color: "",
      snackbar_message: "",
      fonctionnaire: "",
      missionItems: [],
      chauffeurItems: [],
      vehiculeItems: []
    };
  },
  mounted() {},
  created() {
    axios
      .get("/getMissionEnAttente")
      .then(response => {
        // JSON responses are automatically parsed.
        this.missionItems = response.data.missions;
      })
      .catch(e => {
        console.log(e);
      });
    axios
      .get("/chauffeurs")
      .then(response => {
        // JSON responses are automatically parsed.
        this.chauffeurItems = response.data.chauffeurs;
      })
      .catch(e => {
        console.log(e);
      });
    axios
      .get("/vehicules")
      .then(response => {
        // JSON responses are automatically parsed.
        this.vehiculeItems = response.data.vehicules;
      })
      .catch(e => {
        console.log(e);
      });
  },
  methods: {
    back(){
        this.showMissionDetails=false;
        if(this.missionItems[this.selectedMissionIndex].chauffeur != null){
            this.missionItems[this.selectedMissionIndex].chauffeur_id=this.missionItems[this.selectedMissionIndex].chauffeur.id;
            this.missionItems[this.selectedMissionIndex].vehicule_id=this.missionItems[this.selectedMissionIndex].vehicule.id;
        }
        

    },
    showMission(item) {
      this.selectedMission = item;
      this.showMissionDetails = true;
      this.selectedMissionIndex=this.missionItems.indexOf(item);
    },
    saveMission() {
      this.$Progress.start();
      axios
        .post("/saveMissionChauffeur", this.selectedMission)
        .then(response => {
          // JSON responses are automatically parsed.
          this.$Progress.finish();
          this.showSnackBar(response.data.message, "success");
          this.missionItems.splice(this.selectedMissionIndex,1,response.data.mission);
          this.showMissionDetails=false;
          console.log(response.data);
        })
        .catch(e => {
          this.$Progress.fail();
          this.showSnackBar("Une Erreur Est Survenue", "error");
          console.log(e);
        });
    },
    showSnackBar(message, type) {
      this.snackbar_message = message;
      this.snackbar_color = type;
      this.snackbar = true;
    }
  }
};
</script>
<style>
.cell_red {
    background-color: #FFCC80;
}
</style>
