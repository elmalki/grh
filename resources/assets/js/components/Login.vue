<template>
    <v-app>
        <v-content>
            <v-container fluid fill-height>
                <v-layout align-center justify-center>
                    <v-flex xs12 sm8 md4>
                        <v-card class="elevation-12">
                            <v-toolbar dark color="primary">
                                <v-toolbar-title v-if="login">Se Connecter</v-toolbar-title>
                                <v-toolbar-title v-else>S'inscrire</v-toolbar-title>
                                <v-spacer></v-spacer>

                                <v-tooltip bottom>
                                    <v-icon @click="login=true;" slot="activator" v-if="!login" style="cursor: pointer;">vpn_key</v-icon>
                                    <v-icon @click="login=false;" slot="activator" v-else style="cursor: pointer;">person_add</v-icon>
                                    <span v-if="!login">Se Connecter</span>
                                    <span v-else>S'inscrire</span>

                                </v-tooltip>


                            </v-toolbar>
                            <v-card-text v-if="login">
                                <v-form method="post" action="/login" id="loginForm">
                                    <v-text-field prepend-icon="person" name="cin" label="Cin" type="text"></v-text-field>
                                    <v-text-field id="password" prepend-icon="lock" name="password" label="Mot de Passe"
                                        type="password"></v-text-field>
                                        <input name="_token" value="" type="hidden" id="token_login"/>
                                </v-form>
                            </v-card-text>
                            <v-card-text v-else>
                                <v-form method="post" action="/register" id="registerForm">
                                    <v-text-field label="CIN" v-model="fonctionnaire.cin" name="cin">
                                    </v-text-field>
                                    <!-- <img width="50px" height="50px" src="images/loading.gif" /> -->
                                    <v-text-field label="Nom" v-model="fonctionnaire.nom" name="nom"></v-text-field>
                                    <v-text-field label="Prénom" v-model="fonctionnaire.prenom" name="prenom"></v-text-field>

                                    <v-select :items="gradeItems" v-model="fonctionnaire.grade_id" label="Grade"
                                        item-value="id" item-text="libelle" required :rules="gradeRules" single-line ></v-select>
                                        <input name="grade_id" value="" type="hidden" id="grade_id"/>    
                                    <v-select :items="divisionItems" v-model="fonctionnaire.division_id" label="Division"
                                        item-value="id" item-text="libelle" single-line required :rules="divisonRules" ></v-select>
                                        <input name="division_id" value="" type="hidden" id="division_id"/>    
                                    <v-text-field label="Mot de Passe" type="password" v-model="fonctionnaire.password" name="password"></v-text-field>
                                    <v-text-field label="Confirmer le mot de passe" type="password" v-model="fonctionnaire.password_confirmation" name="password_confirmation"></v-text-field>
                                    <input name="_token" value="" type="hidden" id="token_register"/>
                                </v-form>
                            </v-card-text>
                            <v-card-actions>

                                <v-spacer></v-spacer>
                                <v-btn color="yellow accent-4" v-if="login" @click="login_method">Se Connecter</v-btn>
                                <v-btn color="yellow accent-4" v-else @click="subscribe">S'inscrire</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-content>
    </v-app>
</template>
<script>
    export default {
        data() {
            return {
                login: true,
                divisionItems: [],
                gradeItems: [],
                fonctionnaire: {
                    cin: "",
                    nom: "",
                    prenom: "",
                    division_id: "",
                    grade_id: "",
                    password: "",
                    password_confirmation: "",
                },
                cinRules: [v => !!v || "Veuillez Saisir Le Numéro de la CIN"],
                nomRules: [v => !!v || "Veuillez Saisir Le Nom"],
                prenomRules: [v => !!v || "Veuillez Saisir Le Prénom"],
                gradeRules: [v => !!v || "Veuillez Séléctionnez le Grade"],
                divisonRules: [v => !!v || "Veuillez Séléctionnez la Division"]
            };
        },
        mounted() {
            
            // if(document.getElementById('errors')){
            //     var data = JSON.parse(document.getElementById('errors').textContent.trim());
            //     if(data.length != 0)
            //         console.log(data);
                
            // }
            
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
            // searchByCin() {
            //     axios
            //         .post("/searchFonctionnaireByCin", {
            //             cin: this.fonctionnaire.cin
            //         })
            //         .then(response => {
            //             console.log(response.data.fonctionnaire);
            //         })
            //         .catch(e => {
            //             console.log(e);
            //         });
            // },
            subscribe() {
                document.getElementById('grade_id').value=this.fonctionnaire.grade_id;
                document.getElementById('division_id').value=this.fonctionnaire.division_id;
                document.getElementById('token_register').value=document.head.querySelector('meta[name="csrf-token"]').content;
                registerForm.submit();
            },
            login_method(){
                document.getElementById('token_login').value=document.head.querySelector('meta[name="csrf-token"]').content;
                loginForm.submit();
            }
        }
    };

</script>
