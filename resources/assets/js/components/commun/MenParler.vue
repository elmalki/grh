<template>
    <v-layout row wrap>
        <v-flex xs12 v-if="showMissionDetails">
            <v-btn fab right color="brown" dark fixed @click.stop="back">
                <v-icon>arrow_back</v-icon>
            </v-btn>
            <br>
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
                                        <v-text-field label="Déstination" v-model="selectedItem.mission.deplacement.destination"
                                            readonly prepend-icon="place">
                                        </v-text-field>
                                        <v-text-field label="Date Départ" v-model="selectedItem.mission.dateDepart" readonly
                                            prepend-icon="update">
                                        </v-text-field>
                                        <v-text-field label="Nature" v-model="selectedItem.mission.nature.libelle" readonly
                                            prepend-icon="rowing">
                                        </v-text-field>
                                        <div v-if="selectedItem.mission.dateArrive">
                                        <v-text-field label="Date Arrivée" v-model="selectedItem.mission.dateArrive" readonly
                                            prepend-icon="replay">
                                        </v-text-field>
                                        <v-text-field label="Compte Rendu" v-model="selectedItem.mission.compteRendu" readonly 
                                            prepend-icon="textsms" textarea>
                                        </v-text-field>
                                        <v-text-field label="Observations" v-model="selectedItem.mission.observations"
                                            prepend-icon="note_add" textarea :readonly="selectedItem.mission.statut != 4"> 
                                        </v-text-field>
                                        <v-text-field label="Instructions SG" v-model="selectedItem.mission.instructions_sg"
                                            prepend-icon="note_add" textarea readonly> 
                                        </v-text-field>
                                        <v-text-field label="Instructions GV" v-model="selectedItem.mission.instructions_gv"
                                            prepend-icon="note_add" textarea readonly> 
                                        </v-text-field>
                                        </div>
                                        <v-text-field label="Déscription" v-model="selectedItem.description"
                                            prepend-icon="note_add" textarea> 
                                        </v-text-field>
                                    </v-flex>

                                </v-layout>

                            </v-card-title>
                            <v-divider></v-divider>
                            <v-card-actions >
                                <v-layout  row wrap>
                                <v-flex xs10 offset-xs1 >
                                    <v-btn color="success" block large @click="saveDescription">Enregisterer</v-btn>
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
                Liste Des MenParler
            </v-chip>
            <v-divider></v-divider>
            <br>
            <v-text-field append-icon="search" label="Chercher Un MenParler" v-model="search"></v-text-field>
            <v-data-table :headers="headers" :items="menParlerItems" hide-actions class="elevation-1" :search="search"
                no-results-text="Aucun Enregistrement trouvé" no-data-text="La Liste est Vide">
                <template slot="items" slot-scope="props">
                    <tr style="cursor: pointer">
                        <td @click.stop="showMission(props.item)">{{ props.item.mission_id }}</td>
                        <td @click.stop="showMission(props.item)">{{ props.item.mission.current_statut }}</td>
                        <td @click.stop="showMission(props.item)">{{ props.item.appelant.nom }} {{ props.item.appelant.prenom }}</td>
                        <td @click.stop="showMission(props.item)">{{ props.item.created_at }}</td>
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
          text: "Mission Id",
          sortable: false,
          value: "mission_id",
          width: "25px"
        },
        {
          align: "left",
          text: "Statut",
          sortable: false,
          value: "mission.current_statut"
        },
        {
          align: "left",
          text: "Appelant",
          value: "appelant.nom"
        },
        {
          align: "left",
          text: "Crée Le",
          sortable: true,
          sortable: true,
          value: "created_at"
        }
      ],
      snackbar: false,
      timeout: 5000,
      snackbar_color: "",
      snackbar_message: "",
      fonctionnaire: null,
      search: "",
      menParlerItems: [],
      showMissionDetails: false,
      selectedMission: null,
      selectedItem: null
    };
  },
  mounted() {},
  created() {
    this.fonctionnaire = getConnectedUser();
    axios
      .get("/getMenParlerByAppele/" + this.fonctionnaire.id)
      .then(response => {
        // JSON responses are automatically parsed.
        this.menParlerItems = response.data;
      })
      .catch(e => {
        console.log(e);
      });
  },
  methods: {
    back() {
      this.showMissionDetails = false;
    },
    showMission(item) {
      this.selectedItem = item;
      this.showMissionDetails = true;
    },
    saveDescription() {
      axios
        .post("/saveDescription", this.selectedItem)
        .then(response => {
          // JSON responses are automatically parsed.
          this.$Progress.finish();
          this.showSnackBar(response.data.message, "success");
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
