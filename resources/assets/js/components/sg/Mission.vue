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
                                        <v-text-field label="Déstination" v-model="selectedMission.deplacement.destination"
                                            readonly prepend-icon="place">
                                        </v-text-field>
                                        <v-text-field label="Date Départ" v-model="selectedMission.dateDepart" readonly
                                            prepend-icon="update">
                                        </v-text-field>
                                        <v-text-field label="Nature" v-model="selectedMission.nature.libelle" readonly
                                            prepend-icon="rowing">
                                        </v-text-field>
                                        <div v-if="selectedMission.dateArrive">
                                            <v-text-field label="Date Arrivée" v-model="selectedMission.dateArrive"
                                                readonly prepend-icon="update">
                                            </v-text-field>
                                            <v-text-field label="Compte Rendu" v-model="selectedMission.compteRendu"
                                                readonly prepend-icon="textsms" textarea>
                                            </v-text-field>
                                             <v-text-field label="Observations (CD)" v-model="selectedMission.observations"
                                            prepend-icon="note_add" textarea readonly> 
                                            </v-text-field>
                                             <v-text-field label="Instructions SG" v-model="selectedMission.instructions_sg"
                                            prepend-icon="reorder" textarea :readonly="selectedMission.statut > 5"> 
                                            </v-text-field>
                                            <!-- <v-select v-model="selectedMission.feedback_sg" :items="itemsParler" label="M'en Parler"
                                            :readonly="selectedMission.statut > 5" prepend-icon="person_pin"></v-select> -->
                                            <br>
                                            <v-select v-model="selectedMission.appele_id_sg" :items="itemsMenParler" label="M'en Parler" item-text="nom" item-value="id"
                                            :readonly="selectedMission.statut > 5" prepend-icon="person_pin"></v-select>
                                            <br>
                                            <v-text-field label="Instructions GV" v-model="selectedMission.instructions_gv"
                                            prepend-icon="reorder" textarea readonly> 
                                            </v-text-field>
                                        </div>
                                    </v-flex>

                                </v-layout>

                            </v-card-title>
                            <v-divider></v-divider>
                            <v-card-actions>
                                <v-layout  v-if="selectedMission.statut == 5">
                                    <v-flex xs8 offset-xs2>
                                        <v-btn color="success" large block @click="saveMissionInstructions">Enregistrer</v-btn>
                                    </v-flex>
                                </v-layout>
                                
                                <v-layout  row wrap>
                                <v-flex xs10 offset-xs1 >
                                    <v-btn color="error" block large @click="printMissionResume(selectedMission.id)">Imprimer</v-btn>
                                </v-flex>
                                </v-layout>
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
            <v-select :items="statutItems" v-model="selectedStatut" label="Statut"
            item-value="id" item-text="libelle"  single-line @change="loadMission"></v-select>
            
            <v-text-field append-icon="search" label="Chercher Une Mission" v-model="search"></v-text-field>
            <v-data-table :headers="headers" :items="missionItems" hide-actions class="elevation-1" :search="search"
                no-results-text="Aucun Enregistrement trouvé" no-data-text="La Liste est Vide">
                <template slot="items" slot-scope="props">
                    <tr style="cursor: pointer">
                        <td @click.stop="showMission(props.item)">{{
                            props.item.dateDepart }}</td>
                        <td @click.stop="showMission(props.item)">{{
                            props.item.fonctionnaire.nom }}</td>
                        <td @click.stop="showMission(props.item)">{{
                            props.item.fonctionnaire.prenom }}</td>
                        <td @click.stop="showMission(props.item)">{{
                            props.item.nature.libelle }}</td>
                        <td @click.stop="showMission(props.item)">{{
                            props.item.deplacement.destination }}</td>
                        <td @click.stop="showMission(props.item)">
                            {{ getStatutLibelle(props.item.statut) }}</td>
                        <td @click.stop="showMission(props.item)">
                            <div v-if="props.item.type_vehicule">
                                {{ props.item.type_vehicule.libelle }}
                            </div>
                        </td>
                        <td @click.stop="showMission(props.item)">
                            <div v-if="props.item.chauffeur">{{ props.item.chauffeur.nom }}</div>
                        </td>
                        <td @click.stop="showMission(props.item)">
                            <div v-if="props.item.vehicule">{{ props.item.vehicule.marque+" / "+
                                props.item.vehicule.numero}}</div>
                        </td>
                        <td class="justify-center">
                            <v-tooltip right v-if="props.item.statut == 2">
                                <v-btn icon class="mx-0" @click="validerDepart(props.item)" slot="activator">
                                    <v-icon color="teal">check</v-icon>
                                </v-btn>
                                <span>Valider le Départ</span>
                            </v-tooltip>
                            <v-tooltip right v-if="props.item.statut == 3">
                                <v-btn icon class="mx-0" @click="annulerDepart(props.item)" slot="activator">
                                    <v-icon color="red">remove</v-icon>
                                </v-btn>
                                <span>Annuler le Départ</span>
                            </v-tooltip>
                            <v-tooltip right v-if="props.item.statut == 5">
                                <v-btn icon class="mx-0" @click="validerArrive(props.item)" slot="activator">
                                    <v-icon color="orange">reply</v-icon>
                                </v-btn>
                                <span>Valider l'arrivé</span>
                            </v-tooltip>
                            <v-tooltip right v-if="props.item.statut == 6">
                                <v-btn icon class="mx-0" @click="annulerArrive(props.item)" slot="activator">
                                    <v-icon color="red">remove</v-icon>
                                </v-btn>
                                <span>Annuler l'arrivé</span>
                            </v-tooltip>
                        </td>
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
import getConnectedUser from "../../helpers/User";
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
          text: "Nature",
          sortable: false,
          value: "nature.libelle"
        },
        {
          align: "left",
          text: "Déstination",
          value: "deplacement.destination"
        },
        {
          align: "left",
          text: "Statut",
          value: "statut"
        },
        {
          align: "left",
          text: "Type Véhicule",
          value: "type_vehicule.libelle"
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
        },
        {
          align: "left",
          text: "Actions",
          value: "name"
        }
      ],
      itemsParler:['','Fonctionnaire','Chef Division'],
      itemsMenParler:[],
      feedback:'Fonctionnaire',
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
      selectedStatut: "-1",
      statutItems: [
        { id: "-1", libelle: "Toutes les missions" },
        { id: "1", libelle: "En Attente" },
        { id: "2", libelle: "Départ Validé (CD)" },
        { id: "3", libelle: "Départ Validé (SG)" },
        { id: "4", libelle: "Mission Compléte" },
        { id: "5", libelle: "Arrivé Validé (CD)" },
        { id: "6", libelle: "Arrivé Validé (SG)" }
      ]
    };
  },
  mounted() {},
  created() {
    this.fonctionnaire = getConnectedUser();
    this.loadMission();
    
  },
  methods: {
    back() {
      this.showMissionDetails = false;
    },
    showMission(item) {
      this.selectedMission = item;
      this.showMissionDetails = true;
      this.selectedMissionIndex = this.missionItems.indexOf(item);
      this.loadMenParlerList();
    },
    validerDepart(item) {
      //var missionIndex = this.missionItems.indexOf(item);
      axios
        .post("/changeMissionStatut", {
          id: item.id,
          statut: 3
        })
        .then(response => {
          // JSON responses are automatically parsed.
          this.$Progress.finish();
          this.showSnackBar("Départ Validé Avec Succées", "success");
          item.statut = 3;
        })
        .catch(e => {
          this.$Progress.fail();
          this.showSnackBar("Une Erreur Est Survenue", "error");
          console.log(e);
        });
    },
    annulerDepart(item) {
      //missionIndex = this.missionItems.indexOf(item);

      axios
        .post("/changeMissionStatut", {
          id: item.id,
          statut: 2
        })
        .then(response => {
          // JSON responses are automatically parsed.
          this.$Progress.finish();
          this.showSnackBar("Départ Annulé Avec Succées", "success");
          item.statut = 2;
        })
        .catch(e => {
          this.$Progress.fail();
          this.showSnackBar("Une Erreur Est Survenue", "error");
          console.log(e);
        });
    },
    validerArrive(item) {
      axios
        .post("/changeMissionStatut", {
          id: item.id,
          statut: 6
        })
        .then(response => {
          // JSON responses are automatically parsed.
          this.$Progress.finish();
          this.showSnackBar("Retour Validé Avec Succées", "success");
          item.statut = 6;
        })
        .catch(e => {
          this.$Progress.fail();
          this.showSnackBar("Une Erreur Est Survenue", "error");
          console.log(e);
        });
    },
    annulerArrive(item) {
      //missionIndex = this.missionItems.indexOf(item);

      axios
        .post("/changeMissionStatut", {
          id: item.id,
          statut: 5
        })
        .then(response => {
          // JSON responses are automatically parsed.
          this.$Progress.finish();
          this.showSnackBar("Départ Annulé Avec Succées", "success");
          item.statut = 5;
        })
        .catch(e => {
          this.$Progress.fail();
          this.showSnackBar("Une Erreur Est Survenue", "error");
          console.log(e);
        });
    },
    getStatutLibelle(id) {
      return this.statutItems[id].libelle;
    },
    saveMissionInstructions() {
        this.selectedMission.appelant_id = this.fonctionnaire.id;
      axios
        .post("/saveMissionInstructions", this.selectedMission)
        .then(response => {
          // JSON responses are automatically parsed.
          this.$Progress.finish();
          this.showSnackBar(response.data.message, "success");
          this.selectedMission.instructions_sg =
            response.data.mission.instructions_sg;
          console.log(response.data);
        })
        .catch(e => {
          this.$Progress.fail();
          this.showSnackBar("Une Erreur Est Survenue", "error");
          console.log(e);
        });
    },
    loadMission() {
      this.$Progress.start();
      axios
        .get("/getMissionForSG/" + this.selectedStatut)
        .then(response => {
          // JSON responses are automatically parsed.
          this.missionItems = response.data.missions;
          this.$Progress.finish();
        })
        .catch(e => {
          console.log(e);
          this.$Progress.fail();
        });
    },
    loadMenParlerList(){
        axios
        .post("/loadMenParlerList", {
            'fonctionnaire_id': this.selectedMission.fonctionnaire_id,
            'division_id' : this.selectedMission.division_id,
            'profile_id' : this.fonctionnaire.profil_id})
        .then(response => {
          console.log(response.data);
          this.itemsMenParler = response.data;
        })
        .catch(e => {
          this.$Progress.fail();
          this.showSnackBar("Une Erreur Est Survenue", "error");
          console.log(e);
        });
    },
     printMissionResume(id) {
      window.open("/printMissionResume/" + id);
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
  background-color: #ffcc80;
}
</style>