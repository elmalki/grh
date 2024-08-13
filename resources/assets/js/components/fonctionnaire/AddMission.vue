<template>
    <v-layout row wrap>
        <v-flex xs10 offset-xs1>
            <v-card>
                <v-toolbar>
                    <v-toolbar-title>Ajouter Une Mission</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-toolbar-items class="hidden-sm-and-down">
                        <v-icon>add</v-icon>
                    </v-toolbar-items>
                </v-toolbar>
                <v-card-text>
                    <v-layout>
                        <v-flex xs10 offset-xs1>
                            <v-select :items="type_deplacementItems" v-model="mission.type_deplacement_id" label="Nature de Déplacement"
                                item-value="id" item-text="libelle" required :rules="typeDeplacementRules" single-line
                                @change="loadDeplacement"></v-select>
                            <v-select :items="deplacementItems" v-model="mission.deplacement_id" label="Se Rendre A"
                                item-value="id" item-text="destination" required :rules="deplacementRules" single-line></v-select>
                            <v-select :items="natureItems" v-model="mission.nature_id" label="Nature de la mission"
                                item-value="id" item-text="libelle" single-line></v-select>
                            <v-select :items="typeVehiculeItems" v-model="mission.type_vehicule_id" label="Moyen de Transport"
                                item-value="id" item-text="libelle" single-line></v-select>
                                <br>
                                <v-layout row wrap>
                                    <v-flex >
                                            <div class="subheading">Date Départ</div>
                                            <v-divider></v-divider>
                                            <br>
                                            <v-date-picker v-model="mission.dateDepart" full-width landscape></v-date-picker>
                                            <br>
                                 
                                            <div class="subheading"> Heure Départ</div>
                                            <v-divider></v-divider>
                                            <br>
                                            <v-time-picker v-model="mission.heureDepart" full-width format="24hr" landscape scrollable></v-time-picker>
                                    </v-flex>
                                </v-layout>
                                
                        </v-flex>
                    </v-layout>

                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-flex xs8 offset-xs2>
                        <br>
                            <v-btn color="success" large block @click="saveMission">Enregistrer</v-btn>
                            
                    </v-flex>
                        
                </v-card-actions>
            </v-card>

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
import getConnectedUser from '../../helpers/User';
    export default {
        data() {
            return {
                snackbar: false,
                timeout: 5000,
                snackbar_color: "",
                snackbar_message: "",
                fonctionnaire: "",
                mission: {
                    id: "",
                    dateDepart: "",
                    dateArrive: "",
                    heureDepart: null,
                    heureArrive: null,
                    compteRendu: "",
                    pv_path: "",
                    fonctionnaire_id:"",
                    type_deplacement_id: "",
                    deplacement_id: "",
                    nature_id: "",
                    type_vehicule_id: "",
                    vehicule_id: "",
                    chauffeur_id: "",
                    division_id: "",
            
                },
                type_deplacementItems: [],
                deplacementItems: [],
                natureItems: [],
                chauffeurItems: [],
                typeVehiculeItems: [],
                deplacementRules: [v => !!v || "Veuillez Sélectionner votre Déstination"],
                typeDeplacementRules: [v => !!v || "Veuillez Sélectionner la Nature de déplacement"],
            };
        },
        mounted() {

        },
        created() {
            
            this.fonctionnaire=getConnectedUser();
            axios
                .get("/type_vehicules")
                .then(response => {
                    // JSON responses are automatically parsed.
                    this.typeVehiculeItems = response.data.type_vehicules;
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
                .get("/type_deplacements")
                .then(response => {
                    // JSON responses are automatically parsed.
                    this.type_deplacementItems = response.data.type_deplacements;
                })
                .catch(e => {
                    console.log(e);
                });
            axios
                .get("/getNatureByDivision/"+this.fonctionnaire.division_id)
                .then(response => {
                    // JSON responses are automatically parsed.
                    this.natureItems = response.data.natures;
                })
                .catch(e => {
                    console.log(e);
                });
        },
        methods: {
            loadDeplacement() {
                axios
                    .get("/deplacements/" + this.mission.type_deplacement_id)
                    .then(response => {
                        // JSON responses are automatically parsed.
                        this.deplacementItems = response.data.deplacements;
                    })
                    .catch(e => {
                        console.log(e);
                    });
            },
            saveMission(){
                this.mission.fonctionnaire_id=this.fonctionnaire.id;
                this.mission.division_id=this.fonctionnaire.division_id;
                this.$Progress.start();
                axios
                    .post("/missions" , this.mission)
                    .then(response => {
                        // JSON responses are automatically parsed.
                        this.$Progress.finish();
                        this.showSnackBar(response.data.message, "success");
                        console.log(response.data);
                        this.$router.push('fnct_mission');
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
            },

        }
    };

</script>