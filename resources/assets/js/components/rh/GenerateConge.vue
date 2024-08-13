<template>
    <v-layout row wrap>
        <v-flex xs10 offset-xs1>
            <v-btn color="success" block large @click="generateAllConge">AFFECTER L'ENSEMBLE DES CONGES</v-btn>
            <br>
            <v-btn color="info" block large @click="ajouterJourFeries">AJOUTER LES JOURS FERIES</v-btn>

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
            }
        },
        methods: {
            generateAllConge(){
                this.$Progress.start();
                axios
                    .get("/generateAllConge")
                    .then(response => {
                        // JSON responses are automatically parsed.
                        this.$Progress.finish();
                        this.showSnackBar(response.data.message, "success");
                    })
                    .catch(e => {
                        this.$Progress.fail();
                        console.log(e);
                    });
            },
             ajouterJourFeries(){
                this.$Progress.start();
                axios
                    .get("/ajouterJourFeries")
                    .then(response => {
                        // JSON responses are automatically parsed.
                        this.$Progress.finish();
                        this.showSnackBar(response.data.message, "success");
                    })
                    .catch(e => {
                        this.$Progress.fail();
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