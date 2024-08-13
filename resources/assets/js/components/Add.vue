<template>
    <v-layout row wrap>
        <v-flex xs10 offset-xs1>
            <v-stepper v-model="e1">
                <v-stepper-header>
                    <v-stepper-step :complete="e1 > 1" step="1">Renseignements Civils</v-stepper-step>
                    <v-divider></v-divider>
                    <v-stepper-step :complete="e1 > 2" step="2">Conjointes</v-stepper-step>
                    <v-divider></v-divider>
                    <v-stepper-step :complete="e1 > 3" step="3">Enfants</v-stepper-step>
                    <v-divider></v-divider>
                    <v-stepper-step :complete="e1 > 4" step="4">Diplomes</v-stepper-step>
                    <v-divider></v-divider>
                    <v-stepper-step step="5">Formations</v-stepper-step>
                </v-stepper-header>
                <v-stepper-items>
                    <v-stepper-content step="1">
                        <v-form ref="formInfoCivile" v-model="validInfoCivile" lazy-validation>
                            <v-layout row>
                                <v-flex xs3>
                                    <v-text-field label="CIN" v-model="fonctionnaire.cin" required :rules="cinRules"></v-text-field>
                                    <v-text-field label="Nom" v-model="fonctionnaire.nom" required :rules="nomRules"></v-text-field>
                                    <v-text-field label="Prénom" v-model="fonctionnaire.prenom" required :rules="prenomRules"></v-text-field>
                                    <v-menu ref="menu" :close-on-content-click="false" v-model="menu" :nudge-right="40"
                                        :return-value.sync="fonctionnaire.dateNaissance" lazy transition="scale-transition"
                                        offset-y full-width min-width="290px">
                                        <v-text-field slot="activator" v-model="fonctionnaire.dateNaissance" label="Date Naissance"
                                            readonly></v-text-field>
                                        <v-date-picker v-model="fonctionnaire.dateNaissance" no-title scrollable>
                                            <v-spacer></v-spacer>
                                            <v-btn flat color="primary" @click="menu = false">Cancel</v-btn>
                                            <v-btn flat color="primary" @click="$refs.menu.save(fonctionnaire.dateNaissance)">OK</v-btn>
                                        </v-date-picker>
                                    </v-menu>
                                    <v-text-field label="Lieu de Naissance" v-model="fonctionnaire.lieuNaissance"></v-text-field>
                                    <v-select :items="gradeItems" v-model="fonctionnaire.grade_id" label="Grade"
                                        item-value="id" item-text="libelle" required :rules="gradeRules" single-line></v-select>
                                </v-flex>
                                <v-flex xs3 offset-xs1>
                                    <v-select :items="divisionItems" v-model="fonctionnaire.division_id" label="Division"
                                        item-value="id" item-text="libelle" single-line required :rules="divisonRules"></v-select>
                                    <v-select :items="sexeItems" v-model="fonctionnaire.sexe" label="Sexe" single-line></v-select>
                                    <v-select :items="sitFamItems" v-model="fonctionnaire.situationFamilliale" label="Situation Familliale"
                                        single-line></v-select>
                                    <v-text-field label="Tél 1" v-model="fonctionnaire.tel1"></v-text-field>
                                    <v-text-field label="Tél 2" v-model="fonctionnaire.tel2"></v-text-field>
                                    <v-text-field label="Email" v-model="fonctionnaire.email"></v-text-field>
                                </v-flex>
                                <v-flex xs4 offset-xs1>
                                    <v-select :items="niveauItems" v-model="fonctionnaire.niveau" label="Niveau d'instruction"
                                        single-line></v-select>
                                    <v-textarea label="Adresse de Réseidence" v-model="fonctionnaire.adresseResidence"></v-textarea>
                                    <v-textarea label="Adresse de Courrier" v-model="fonctionnaire.adresseCourrier"></v-textarea>
                                </v-flex>

                            </v-layout>
                            <br>
                            <v-layout row>
                                <v-flex xs7>
                                    <v-text-field label="RIB" v-model="fonctionnaire.rib"></v-text-field>
                                </v-flex>
                            </v-layout>
                            <v-layout row>
                                <v-flex xs4>
                                    <v-text-field label="Agence" v-model="fonctionnaire.agence"></v-text-field>
                                    <v-text-field label="Ville" v-model="fonctionnaire.ville"></v-text-field>
                                </v-flex>
                            </v-layout>

                            <v-btn color="primary" :disabled="!validInfoCivile" @click.native="saveInfoCivile">Suivant</v-btn>
                        </v-form>
                    </v-stepper-content>
                    <v-stepper-content step="2">

                        <v-layout row>
                            <v-flex xs3>
                                <v-form ref="formInfoConjoint" v-model="validInfoConjoint" lazy-validation>
                                    <v-text-field label="CIN" v-model="conjoint.cin"></v-text-field>
                                    <v-text-field label="Nom" v-model="conjoint.nom" required :rules="nomRules"></v-text-field>
                                    <v-text-field label="Prénom" v-model="conjoint.prenom" required :rules="prenomRules"></v-text-field>
                                    <v-btn block color="success" :disabled="!validInfoConjoint" @click="addConjoint">Ajouter</v-btn>
                                </v-form>
                            </v-flex>
                            <v-flex xs8 offset-xs1>
                                <br>
                                <v-data-table :headers="headersConjoints" :items="conjointItems" hide-actions class="elevation-2"
                                    dark>
                                    <template slot="items" slot-scope="props">
                                        <td class="text-xs-right">
                                            <v-edit-dialog :return-value.sync="props.item.cin" lazy>
                                                {{ props.item.cin }}
                                                <v-text-field slot="input" v-model="props.item.cin" label="Modifier"
                                                    single-line counter></v-text-field>
                                            </v-edit-dialog>
                                        </td>
                                        <td class="text-xs-right">
                                            <v-edit-dialog :return-value.sync="props.item.nom" lazy>
                                                {{ props.item.nom }}
                                                <v-text-field slot="input" v-model="props.item.nom" label="Modifier"
                                                    single-line counter></v-text-field>
                                            </v-edit-dialog>
                                        </td>
                                        <td class="text-xs-right">
                                            <v-edit-dialog :return-value.sync="props.item.prenom" lazy>
                                                {{ props.item.prenom }}
                                                <v-text-field slot="input" v-model="props.item.prenom" label="Modifier"
                                                    single-line counter></v-text-field>
                                            </v-edit-dialog>
                                        </td>
                                        <td class="justify-center layout px-0">
                                            <v-btn icon class="mx-0" @click="deleteConjoint(props.item)">
                                                <v-icon color="red">delete</v-icon>
                                            </v-btn>
                                        </td>
                                    </template>
                                </v-data-table>
                            </v-flex>
                        </v-layout>

                        <br>
                        <br>
                        <v-btn color="primary" @click.native="saveInfoConjoints">Suivant</v-btn>
                        <v-btn flat @click.native="e1 = 1">Précedent</v-btn>
                    </v-stepper-content>
                    <v-stepper-content step="3">
                        <v-layout row>
                            <v-flex xs3>
                                <v-form ref="formInfoEnfant" v-model="validInfoEnfant" lazy-validation>
                                    <v-text-field label="Nom" v-model="enfant.nom" required :rules="nomRules"></v-text-field>
                                    <v-text-field label="Prénom" v-model="enfant.prenom" required :rules="prenomRules"></v-text-field>
                                    <v-select :items="conjointItems" v-model="enfant.conjoint_id" label="Mère Père"
                                        item-text="nom" item-value="id" single-line required :rules="merePereRules"></v-select>
                                    <v-menu ref="menuEnfant" :close-on-content-click="false" v-model="menuEnfant"
                                        :nudge-right="40" :return-value.sync="enfant.dateNaissance" lazy transition="scale-transition"
                                        offset-y full-width min-width="290px">
                                        <v-text-field slot="activator" v-model="enfant.dateNaissance" label="Date Naissance"
                                            readonly></v-text-field>
                                        <v-date-picker v-model="enfant.dateNaissance" no-title scrollable>
                                            <v-spacer></v-spacer>
                                            <v-btn flat color="primary" @click="menuEnfant = false">Cancel</v-btn>
                                            <v-btn flat color="primary" @click="$refs.menuEnfant.save(enfant.dateNaissance)">OK</v-btn>
                                        </v-date-picker>
                                    </v-menu>

                                    <v-text-field label="Lieu de Naissance" v-model="enfant.lieuNaissance"></v-text-field>
                                    <v-btn block color="success" :disabled="!validInfoEnfant" @click="addEnfant">Ajouter</v-btn>
                                </v-form>
                            </v-flex>
                            <v-flex xs8 offset-xs1>
                                <br>
                                <v-data-table :headers="headersEnfants" :items="enfantItems" hide-actions class="elevation-2"
                                    dark>
                                    <template slot="items" slot-scope="props">
                                        <td class="text-xs-right">
                                            <v-edit-dialog :return-value.sync="props.item.nom" lazy>
                                                {{ props.item.nom }}
                                                <v-text-field slot="input" v-model="props.item.nom" label="Modifier"
                                                    single-line counter></v-text-field>
                                            </v-edit-dialog>
                                        </td>
                                        <td class="text-xs-right">
                                            <v-edit-dialog :return-value.sync="props.item.prenom" lazy>
                                                {{ props.item.prenom }}
                                                <v-text-field slot="input" v-model="props.item.prenom" label="Modifier"
                                                    single-line counter></v-text-field>
                                            </v-edit-dialog>
                                        </td>
                                        <td class="text-xs-right">

                                            {{ props.item.dateNaissance }}
                                        </td>
                                        <td class="text-xs-right">
                                            <v-edit-dialog :return-value.sync="props.item.lieuNaissance" lazy>
                                                {{ props.item.lieuNaissance }}
                                                <v-text-field slot="input" v-model="props.item.lieuNaissance" label="Modifier"
                                                    single-line counter></v-text-field>
                                            </v-edit-dialog>
                                        </td>
                                        <td class="text-xs-right">
                                            {{ find(props.item.conjoint_id) }}
                                        </td>
                                        <td class="justify-center layout px-0">
                                            <v-btn icon class="mx-0" @click="deleteEnfant(props.item)">
                                                <v-icon color="red">delete</v-icon>
                                            </v-btn>
                                        </td>
                                    </template>
                                </v-data-table>
                            </v-flex>
                        </v-layout>
                        <v-btn color="primary" @click.native="saveInfoEnfants">Suivant</v-btn>
                        <v-btn flat @click.native="e1 = 2">Précedent</v-btn>
                    </v-stepper-content>
                    <v-stepper-content step="4">
                        <v-layout row>
                            <v-flex xs3>
                                <v-text-field label="Intitulé" v-model="diplome.intitule"></v-text-field>
                                <v-text-field label="Etablissement" v-model="diplome.etablissement"></v-text-field>
                                <v-menu ref="menuDateObtention" :close-on-content-click="false" v-model="menuDateObtention"
                                    :nudge-right="40" :return-value.sync="diplome.dateObtention" lazy transition="scale-transition"
                                    offset-y full-width min-width="290px">
                                    <v-text-field slot="activator" v-model="diplome.dateObtention" label="Date D'obtention"
                                        readonly></v-text-field>
                                    <v-date-picker v-model="diplome.dateObtention" no-title scrollable>
                                        <v-spacer></v-spacer>
                                        <v-btn flat color="primary" @click="menuDateObtention = false">Cancel</v-btn>
                                        <v-btn flat color="primary" @click="$refs.menuDateObtention.save(diplome.dateObtention)">OK</v-btn>
                                    </v-date-picker>
                                </v-menu>
                                <v-btn block color="success" @click="addDiplome">Ajouter</v-btn>
                            </v-flex>
                            <v-flex xs8 offset-xs1>
                                <br>
                                <v-data-table :headers="headersDiplomes" :items="diplomeItems" hide-actions class="elevation-2"
                                    dark>
                                    <template slot="items" slot-scope="props">
                                        <td class="text-xs-left">
                                            {{ props.item.intitule }}
                                        </td>
                                        <td class="text-xs-left">
                                            {{ props.item.etablissement }}
                                        </td>
                                        <td class="text-xs-left">

                                            {{ props.item.dateObtention }}
                                        </td>
                                        <td class="justify-center layout px-0">
                                            <v-btn icon class="mx-0" @click="deleteDiplome(props.item)">
                                                <v-icon color="red">delete</v-icon>
                                            </v-btn>
                                        </td>
                                    </template>
                                </v-data-table>
                            </v-flex>
                        </v-layout>
                        <v-btn color="primary" @click.native="saveInfoDiplomes">Suivant</v-btn>
                        <v-btn flat @click.native="e1 = 3">Précedent</v-btn>
                    </v-stepper-content>
                    <v-stepper-content step="5">
                        <v-layout row>
                            <v-flex xs3>
                                <v-text-field label="Thème" v-model="formation.theme"></v-text-field>
                                <v-text-field label="Etablissement" v-model="formation.etablissement"></v-text-field>
                                <v-menu ref="menuDateDebut" :close-on-content-click="false" v-model="menuDateDebut"
                                    :nudge-right="40" :return-value.sync="formation.dateDebut" lazy transition="scale-transition"
                                    offset-y full-width min-width="290px">
                                    <v-text-field slot="activator" v-model="formation.dateDebut" label="Date Début"
                                        readonly></v-text-field>
                                    <v-date-picker v-model="formation.dateDebut" no-title scrollable>
                                        <v-spacer></v-spacer>
                                        <v-btn flat color="primary" @click="menuDateDebut = false">Cancel</v-btn>
                                        <v-btn flat color="primary" @click="$refs.menuDateDebut.save(formation.dateDebut)">OK</v-btn>
                                    </v-date-picker>
                                </v-menu>
                                <v-menu ref="menuDateFin" :close-on-content-click="false" v-model="menuDateFin"
                                    :nudge-right="40" :return-value.sync="formation.dateFin" lazy transition="scale-transition"
                                    offset-y full-width min-width="290px">
                                    <v-text-field slot="activator" v-model="formation.dateFin" label="Date Fin"
                                        readonly></v-text-field>
                                    <v-date-picker v-model="formation.dateFin" no-title scrollable>
                                        <v-spacer></v-spacer>
                                        <v-btn flat color="primary" @click="menuDateFin = false">Cancel</v-btn>
                                        <v-btn flat color="primary" @click="$refs.menuDateFin.save(formation.dateFin)">OK</v-btn>
                                    </v-date-picker>
                                </v-menu>
                                <v-text-field label="Ville" v-model="formation.ville"></v-text-field>
                                <v-btn block color="success" @click="addFormation">Ajouter</v-btn>
                            </v-flex>
                            <v-flex xs8 offset-xs1>
                                <br>
                                <v-data-table :headers="headersFormations" :items="formationItems" hide-actions class="elevation-2"
                                    dark>
                                    <template slot="items" slot-scope="props">
                                        <td class="text-xs-left">
                                            {{ props.item.theme }}
                                        </td>
                                        <td class="text-xs-left">
                                            {{ props.item.etablissement }}
                                        </td>
                                        <td class="text-xs-left">
                                            {{ props.item.dateDebut }}
                                        </td>
                                        <td class="text-xs-left">
                                            {{ props.item.dateFin }}
                                        </td>
                                        <td class="text-xs-left">
                                            {{ props.item.ville }}
                                        </td>
                                        <td class="justify-center layout px-0">
                                            <v-btn icon class="mx-0" @click="deleteFormation(props.item)">
                                                <v-icon color="red">delete</v-icon>
                                            </v-btn>
                                        </td>
                                    </template>
                                </v-data-table>
                            </v-flex>
                        </v-layout>
                        <v-btn color="primary" @click.native="saveInfoFormations">Valider</v-btn>
                        <v-btn flat @click.native="e1 = 4">Précedent</v-btn>
                    </v-stepper-content>
                </v-stepper-items>
            </v-stepper>

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
                headersConjoints: [{
                        align: "left",
                        text: "CIN",
                        value: "cin",
                        sortable: false
                    },
                    {
                        align: "left",
                        text: "Nom",
                        value: "nom",
                        sortable: false
                    },
                    {
                        align: "left",
                        text: "Prénom",
                        value: "prenom",
                        sortable: false
                    },
                    {
                        text: "Actions",
                        value: "name",
                        sortable: false
                    }
                ],
                headersEnfants: [{
                        align: "left",
                        text: "Nom",
                        value: "nom",
                        sortable: false
                    },
                    {
                        align: "left",
                        text: "Prénom",
                        value: "prenom",
                        sortable: false
                    },
                    {
                        align: "left",
                        text: "Date Naissance",
                        value: "dateNaissance",
                        sortable: false
                    },
                    {
                        align: "left",
                        text: "Lieu Naissance",
                        value: "lieuNaissance",
                        sortable: false
                    },
                    {
                        align: "left",
                        text: "Père Mère",
                        value: "conjoint.nom",
                        sortable: false
                    },
                    {
                        text: "Actions",
                        value: "name",
                        sortable: false
                    }
                ],
                headersDiplomes: [{
                        align: "left",
                        text: "Intitulé",
                        value: "intitule",
                        sortable: false
                    },
                    {
                        align: "left",
                        text: "Etablissement",
                        value: "etablissement",
                        sortable: false
                    },
                    {
                        align: "left",
                        text: "Date d'obtention",
                        value: "dateObtention",
                        sortable: false
                    },
                    {
                        text: "Actions",
                        value: "name",
                        sortable: false
                    }
                ],
                headersFormations: [{
                        align: "left",
                        text: "Thème",
                        value: "theme",
                        sortable: false
                    },
                    {
                        align: "left",
                        text: "Etablissement",
                        value: "etablissement",
                        sortable: false
                    },
                    {
                        align: "left",
                        text: "Date Début",
                        value: "dateDebut",
                        sortable: false
                    },
                    {
                        align: "left",
                        text: "Date Fin",
                        value: "dateFin",
                        sortable: false
                    },
                    {
                        align: "left",
                        text: "Ville",
                        value: "ville",
                        sortable: false
                    },
                    {
                        text: "Actions",
                        value: "name",
                        sortable: false
                    }
                ],
                snackbar: false,
                timeout: 5000,
                snackbar_color: "",
                snackbar_message: "",
                conjointItems: [],
                enfantItems: [],
                diplomeItems: [],
                formationItems: [],
                divisionItems: [],
                gradeItems: [],
                e1: 0,
                menu: false,
                menuModif: false,
                menuEnfant: false,
                menuDateObtention: false,
                menuDateDebut: false,
                menuDateFin: false,
                sexeItems: ["Homme", "Femme"],
                sitFamItems: ["Célibataire", "Marié(e)", "Divorcé(e)", "Veuf(ve)"],
                niveauItems: [
                    "Primaire",
                    "Collégial",
                    "Secondaire",
                    "Universitaire",
                    "Magistral",
                    "Doctoral"
                ],
                fonctionnaire: {
                    id: null,
                    cin: "",
                    nom: "",
                    prenom: "",
                    sexe: "",
                    situationFamilliale: "",
                    niveau: "",
                    dateNaissance: "",
                    lieuNaissance: "",
                    adresseResidence: "",
                    adresseCourrier: "",
                    tel1: "",
                    tel2: "",
                    email: "",
                    rib: "",
                    agence: "",
                    ville: "",
                    grade_id: "",
                    division_id: ""
                },
                conjoint: {
                    fonctionnaire_id: "",
                    cin: "",
                    nom: "",
                    prenom: ""
                },
                enfant: {
                    nom: "",
                    prenom: "",
                    dateNaissance: "",
                    lieuNaissance: "",
                    fonctionnaire_id: "",
                    conjoint_id: "",
                    conjoint: null,
                },
                diplome: {
                    fonctionnaire_id: "",
                    intitule: "",
                    etablissement: "",
                    dateObtention: ""
                },
                formation: {
                    fonctionnaire_id: "",
                    theme: "",
                    etablissement: "",
                    dateDebut: "",
                    dateFin: "",
                    ville: ""
                },
                validInfoCivile: true,
                validInfoConjoint: true,
                validInfoEnfant: true,
                cinRules: [v => !!v || 'Veuillez Saisir Le Numéro de la CIN'],
                nomRules: [v => !!v || 'Veuillez Saisir Le Nom'],
                prenomRules: [v => !!v || 'Veuillez Saisir Le Prénom'],
                merePereRules: [v => !!v || 'Veuillez Séléctionnez le (Père, Mére)'],
                gradeRules: [v => !!v || 'Veuillez Séléctionnez le Grade'],
                divisonRules: [v => !!v || 'Veuillez Séléctionnez la Division'],
            };
        },
        mounted() {
            axios
                .get("/divisions")
                .then(response => {
                    // JSON responses are automatically parsed.
                    this.divisionItems = response.data.divisions;
                })
                .catch(e => {
                    console.log(e);
                });
            axios
                .get("/grades")
                .then(response => {
                    // JSON responses are automatically parsed.
                    this.gradeItems = response.data.grades;
                })
                .catch(e => {
                    console.log(e);
                });
        },
        methods: {
            addConjoint() {
                if (this.$refs.formInfoConjoint.validate()) {
                    this.conjointItems.push({
                        fonctionnaire_id: this.fonctionnaire.id,
                        cin: this.conjoint.cin,
                        nom: this.conjoint.nom,
                        prenom: this.conjoint.prenom
                    });
                    this.conjoint = {
                        fonctionnaire_id: "",
                        cin: "",
                        nom: "",
                        prenom: ""
                    };
                    this.$refs.formInfoConjoint.reset();
                }
            },
            addEnfant() {
                if (this.$refs.formInfoEnfant.validate()) {
                    this.enfantItems.push({
                        nom: this.enfant.nom,
                        prenom: this.enfant.prenom,
                        lieuNaissance: this.enfant.lieuNaissance,
                        dateNaissance: this.enfant.dateNaissance,
                        conjoint_id: this.enfant.conjoint_id,
                        fonctionnaire_id: this.fonctionnaire.id,
                    });
                    this.enfant = {
                        nom: "",
                        prenom: "",
                        lieuNaissance: "",
                        dateNaissance: "",
                        conjoint_id: "",
                        conjoint: null,
                    };
                    this.$refs.formInfoEnfant.reset();
                }
            },
            addDiplome() {
                this.diplomeItems.push({
                    fonctionnaire_id: this.fonctionnaire.id,
                    intitule: this.diplome.intitule,
                    etablissement: this.diplome.etablissement,
                    dateObtention: this.diplome.dateObtention
                });
                this.diplome = {
                    fonctionnaire_id: "",
                    intitule: "",
                    etablissement: "",
                    dateObtention: ""
                };
            },
            addFormation() {
                this.formationItems.push({
                    fonctionnaire_id: this.fonctionnaire.id,
                    theme: this.formation.theme,
                    etablissement: this.formation.etablissement,
                    dateDebut: this.formation.dateDebut,
                    dateFin: this.formation.dateFin,
                    ville: this.formation.ville
                });
                this.formation = {
                    theme: "",
                    etablissement: "",
                    dateDebut: "",
                    dateFin: "",
                    ville: ""
                };
            },
            deleteConjoint(item) {
                const index = this.conjointItems.indexOf(item);
                this.conjointItems.splice(index, 1);
            },
            deleteEnfant(item) {
                const index = this.enfantItems.indexOf(item);
                this.enfantItems.splice(index, 1);
            },
            deleteDiplome(item) {
                const index = this.diplomeItems.indexOf(item);
                this.diplomeItems.splice(index, 1);
            },
            deleteFormation(item) {
                const index = this.formationItems.indexOf(item);
                this.formationItems.splice(index, 1);
            },
            saveInfoCivile() {
                // if (this.$refs.formInfoCivile.validate()) {
                //     this.$Progress.start();
                //     axios
                //         .post("/saveInfoCivile", this.fonctionnaire)
                //         .then(response => {
                //             // JSON responses are automatically parsed.
                //             console.log(response.data.fonctionnaire);
                //             this.fonctionnaire.id = response.data.fonctionnaire.id;
                //             this.$Progress.finish();
                //             this.showSnackBar(response.data.message, "success");
                //             this.e1 = 2;
                //         })
                //         .catch(e => {
                //             this.$Progress.fail();
                //             this.showSnackBar("Une Erreur Est Survenue", "error");
                //             console.log(e);
                //         });
                // }
                this.e1 = 2;

            },
            saveInfoConjoints() {

                // this.$Progress.start();
                // axios
                //     .post("/saveInfoConjoints", {
                //         conjointItems: this.conjointItems
                //     })
                //     .then(response => {
                //         // JSON responses are automatically parsed.

                //         console.log(response.data);
                //         this.conjointItems = response.data.conjointItems;
                //         this.showSnackBar(response.data.message, "success");
                //         this.$Progress.finish();
                //         this.e1 = 3;
                //     })
                //     .catch(e => {
                //         this.$Progress.fail();
                //         this.showSnackBar("Une Erreur Est Survenue", "error");
                //         console.log(e);
                //     });
                this.e1 = 3;


            },
            saveInfoEnfants() {
                // this.$Progress.start();
                // axios
                //     .post("/saveInfoEnfants", {
                //         enfantItems: this.enfantItems
                //     })
                //     .then(response => {
                //         console.log(response.data);
                //         this.enfantItems = response.data.enfantItems;
                //         this.showSnackBar(response.data.message, "success");
                //         this.$Progress.finish();
                //         this.e1 = 4;
                //     })
                //     .catch(e => {
                //         this.$Progress.fail();
                //         this.showSnackBar("Une Erreur Est Survenue", "error");
                //         console.log(e);
                //     });
                this.e1 = 4;

            },
            saveInfoDiplomes() {
                // this.$Progress.start();
                // axios
                //     .post("/saveInfoDiplomes", {
                //         diplomeItems: this.diplomeItems
                //     })
                //     .then(response => {
                //         console.log(response.data);
                //         this.diplomeItems = response.data.diplomeItems;
                //         this.showSnackBar(response.data.message, "success");
                //         this.$Progress.finish();
                //         this.e1 = 5;
                //     })
                //     .catch(e => {
                //         this.$Progress.fail();
                //         this.showSnackBar("Une Erreur Est Survenue", "error");
                //         console.log(e);
                //     });
                this.e1 = 5;

            },
            saveInfoFormations() {
                this.$Progress.start();
                axios
                    .post("/saveInfoFormations", {
                        formationItems: this.formationItems
                    })
                    .then(response => {
                        console.log(response.data);
                        this.formationItems = response.data.formationItems;
                        this.showSnackBar(response.data.message, "success");
                        this.$Progress.finish();
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
            find(id) {
                var name = "";
                this.conjointItems.forEach(el => {
                    if (el.id == id) {
                        name = el.nom
                        return;
                    }
                });
                return name;
            }
        }
    };

</script>
