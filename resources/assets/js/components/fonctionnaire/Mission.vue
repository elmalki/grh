<template>
    <v-layout row wrap>
        <v-flex xs12 v-if="showMissionDetails">
            <v-btn fab right color="brown" dark fixed @click.stop="back">
                <v-icon>arrow_back</v-icon>
            </v-btn>
            
            <v-container grid-list-md>

                <v-layout row wrap>
                    <v-flex xs10 offset-xs1>
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
                                        <div v-if="selectedMission.statut > 3">
                                                <v-text-field label="Date De Retour" v-model="selectedMission.dateArrive" readonly
                                                    prepend-icon="replay" >
                                                </v-text-field>
                                                <v-text-field label="Compte Rendu" v-model="selectedMission.compteRendu" textarea readonly
                                                    prepend-icon="textsms" >
                                                </v-text-field>
                                                <v-text-field label="Observations" v-model="selectedMission.observations"
                                                    prepend-icon="note_add" textarea readonly> 
                                                </v-text-field>
                                                <v-text-field label="Instructions SG" v-model="selectedMission.instructions_sg"
                                                    prepend-icon="note_add" textarea readonly> 
                                                </v-text-field>
                                                 <v-text-field label="Instructions GV" v-model="selectedMission.instructions_gv"
                                                    prepend-icon="note_add" textarea readonly> 
                                                </v-text-field>
                                        </div>
                                        
                                        <div v-if="selectedMission.statut == 3 ">
                                            <br>
                                            <v-layout>
                                                <v-flex xs4 offset-xs1>
                                                    <div class="subheading">Date Retour</div>
                                                    <v-divider></v-divider>
                                                    <br>
                                                    <v-date-picker v-model="selectedMission.dateArrive" full-width ></v-date-picker>
                                                </v-flex>
                                                <v-flex xs3 offset-xs2>
                                                    <div class="subheading"> Heure Retour</div>
                                                    <v-divider></v-divider>
                                                    <br>
                                                    <v-time-picker v-model="selectedMission.heureArrive" full-width format="24hr"
                                                         scrollable ></v-time-picker>
                                                </v-flex>
                                            </v-layout>
                                            <br>
                                            <v-text-field label="Compte Rendu" v-model="selectedMission.compteRendu" textarea
                                            prepend-icon="textsms" >
                                        </v-text-field>
                                            <v-text-field readonly :rules="[v => !!v || 'Veuillez Joindre une image']" 
                                                required label="Choisir l'image du PV" @click='pickFile' prepend-icon='attach_file' 
                                                v-model.trim.lazy='imageName'>
                                            </v-text-field>
                                            <input type="file" style="display: none" ref="image_file" @change="onFilePicked" accept="image/*" multiple>
                                           <!-- <v-layout>
                                                 <v-flex xs4 offset-xs1>
                                                    <img v-if="selectedMission.image" :src="selectedMission.image" style="border:1px solid black" width="70%" height="70%">       
                                                </v-flex>
                                                <v-flex xs4>
                                                    <img v-if="selectedMission.pv_path" :src="getFullUrl(selectedMission.pv_path)" 
                                                    style="border:1px solid black" width="70%" height="70%">           
                                                </v-flex>

                                            </v-layout> -->
                                             
                                        </div>
                                    </v-flex>

                                </v-layout>

                            </v-card-title>
                            <v-divider></v-divider>
                            <v-card-actions >
                                <v-layout row wrap v-if="selectedMission.statut == 3">
                                <v-flex xs4>

                                    <v-btn color="success" block large @click="saveMissionFnct">Enregistrer</v-btn>
                                    

                                </v-flex>
                                <v-flex xs4 >
                                    <v-btn color="info" block large @click="validerMissionFnct">Valider</v-btn>
                                </v-flex>
                                </v-layout>
                                <br>
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
                            <td class="justify-center">
                            <v-tooltip right v-if="props.item.statut == 3">
                                <v-btn  icon class="mx-0" @click="printMission(props.item)"
                                    slot="activator">
                                    <v-icon color="teal">print</v-icon>
                                </v-btn>
                                <span>Imprimer Ordre</span>
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
          text: "Actions",
          value: "actions"
        }
      ],
      imageName:[],
      imageData:[],
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
      statutList: [
        "En Attente",
        "Départ Validé (CD)",
        "Départ Validé (SG)",
        "Mission Compléte",
        "Arrivé Validé (CD)",
        "Arrivé Validé (SG)"
      ]
    };
  },
  mounted() {},
  created() {
    this.fonctionnaire = getConnectedUser();
    axios
      .get("/getMissionForFnct")
      .then(response => {
        // JSON responses are automatically parsed.
        this.missionItems = response.data.missions;
      })
      .catch(e => {
        console.log(e);
      });
  },
  methods: {
    back() {
      this.showMissionDetails = false;
      if (this.missionItems[this.selectedMissionIndex].dateArrive != null) {
        this.missionItems[
          this.selectedMissionIndex
        ].dateArrive = this.missionItems[this.selectedMissionIndex].dateArrive;
        this.missionItems[
          this.selectedMissionIndex
        ].compteRendu = this.missionItems[
          this.selectedMissionIndex
        ].compteRendu;
        this.missionItems[
          this.selectedMissionIndex
        ].heureArrive = this.missionItems[
          this.selectedMissionIndex
        ].dateArrive.substring(11, 16);
      }
    },
    showMission(item) {
      this.selectedMission = item;
      if (item.dateArrive)
        this.selectedMission.heureArrive = item.dateArrive.substring(11, 16);
      this.showMissionDetails = true;
      this.selectedMissionIndex = this.missionItems.indexOf(item);
    },
    getStatutLibelle(id) {
      return this.statutList[id - 1];
    },
    printMission(item) {
      window.open("/printMission/" + item.id);
    },
     printMissionResume(id) {
      window.open("/printMissionResume/" + id);
    },
    saveMissionFnct() {
      axios
        .post("/saveMissionFnct", this.selectedMission)
        .then(response => {
          // JSON responses are automatically parsed.
          this.$Progress.finish();
          this.showSnackBar(response.data.message, "success");
          this.selectedMission.compteRendu = response.data.mission.compteRendu;
          this.selectedMission.dateArrive = response.data.mission.dateArrive;
          console.log(response.data);
        })
        .catch(e => {
          this.$Progress.fail();
          this.showSnackBar("Une Erreur Est Survenue", "error");
          console.log(e);
        });
    },
    validerMissionFnct() {
      axios
        .post("/validerMissionFnct", this.selectedMission)
        .then(response => {
          // JSON responses are automatically parsed.
          this.$Progress.finish();
          this.showSnackBar(response.data.message, "success");
          this.selectedMission.statut = response.data.mission.statut;
          console.log(response.data);
        })
        .catch(e => {
          this.$Progress.fail();
          this.showSnackBar("Une Erreur Est Survenue", "error");
          console.log(e);
        });
    },
    pickFile() {
            this.$refs.image_file.click();
    },
    onFilePicked(e) {
            const files= e.target.files;
            var _this=this;
            Array.from(files).forEach(function(file){
                const fileReader = new FileReader();
                _this.imageName.push(file.name);
                fileReader.onload = (e) =>{
                    _this.imageData.push(fileReader.result);
                }
                fileReader.readAsDataURL(file);
            });
            // const fileReader = new FileReader();
            // var file=e.target.files[0];
            // fileReader.onload = (e) =>{
            //     this.selectedMission.image = e.target.result;
            //     this.imageName=file.name;
            // }
            // fileReader.readAsDataURL(file);
    },
    getFullUrl(fileName){
            return '/storage/'+fileName;
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