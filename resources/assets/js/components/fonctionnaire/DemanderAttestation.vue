<template>
  <v-layout row wrap>
    <v-dialog v-model="dialog" width="600px">
      <v-card>
        <v-card-title class="title">
          <v-icon large color="blue" class="mr-3">info</v-icon>Demander Une Attestation
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text>
          <v-container grid-list-sm class="pa-4">
            <v-layout row wrap>
              <v-flex xs12 align-center>
                <v-form v-model="valid" ref="form" lazy-validation @submit.prevent="submit">
                  <v-select
                    :items="attestationItems"
                    v-model="demande.attestation_id"
                    label="Attestation"
                    item-value="id"
                    item-text="libelle"
                    required
                    :rules="attestationRules"
                    single-line
                  ></v-select>
                  <v-text-field
                    v-model="demande.nombre"
                    label="Nombre"
                    :rules="nombreRules"
                    required
                  ></v-text-field>
                </v-form>
              </v-flex>
            </v-layout>
          </v-container>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn @click="submit" large color="success" :disabled="!valid">Enregistrer</v-btn>
          <v-btn @click="cancel" large color="warning">Annuler</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-flex xs10 offset-xs1>
      <v-data-table
        :headers="headers"
        :items="demandes"
        hide-actions
        class="elevation-1"
        no-results-text="Aucun Enregistrement trouvé"
        no-data-text="La Liste est Vide"
      >
        <template slot="items" slot-scope="props">
          <td v-bind:class="{'cell_red' : (props.item.statut == 'En Attente')}">{{ props.item.libelle }}</td>
          <td v-bind:class="{'cell_red' : (props.item.statut == 'En Attente')}">{{ props.item.statut }}</td>
          <td v-bind:class="{'cell_red' : (props.item.statut == 'En Attente')}">{{ props.item.nombre }}</td>
          <td v-bind:class="{'cell_red' : (props.item.statut == 'En Attente')}">{{ props.item.created_at }}</td>
          <td v-bind:class="{'cell_red' : (props.item.statut == 'En Attente')}">{{ props.item.updated_at }}</td>
        </template>
      </v-data-table>
    </v-flex>
    <v-btn fab bottom right color="pink" dark fixed @click.stop="newItem">
      <v-icon>add</v-icon>
    </v-btn>
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
      search: "",
      snackbar: false,
      timeout: 5000,
      snackbar_color: "",
      snackbar_message: "",
      valid: true,
      dialog: false,
      libelleRules: [
        v => !!v || "Veuillez Entrer Le libellé de la attestation"
      ],
      attestationRules: [v => !!v || "Veuillez Sélectionner une Attestation"],
      nombreRules: [v => !!v || "Veuillez Saisir Le nombre que vous voulez"],
      editedIndex: -1,
      attestation: {
        id: "",
        libelle: ""
      },
      dialog: false,
      dialog_delete: false,
      items: [],
      attestationItems: [],
      demandes: [],
      item_delete: null,
      headers: [
        { align: "left", text: "Libelle", value: "libelle" },
        { align: "left", text: "Statut", value: "statut" },
        { align: "left", text: "Nombre", value: "nombre" },
        { align: "left", text: "Date Demande", value: "created_at" },
        { align: "left", text: "Préparée Le", value: "updated_at" }
      ],
      fonctionnaire: "",
      demande: {
        attestation_id: "",
        fonctionnaire_id: "",
        nombre: 1,
        statut:"",
      }
    };
  },
  mounted() {
    this.fonctionnaire = getConnectedUser();
    this.loadRequestAttestation();
    this.loadAttestations();
  },
  methods: {
    loadRequestAttestation() {
      axios
        .get("/getAttestationByFonctionnaireId/" + this.fonctionnaire.id)
        .then(response => {
          // JSON responses are automatically parsed.
          this.demandes = response.data.demandes;
        })
        .catch(e => {
          this.errors.push(e);
        });
    },
    loadAttestations() {
      axios
        .get("/attestations")
        .then(response => {
          // JSON responses are automatically parsed.
          this.attestationItems = response.data;
        })
        .catch(e => {
          this.errors.push(e);
        });
    },
    newItem() {
      this.dialog = !this.dialog;
    },
    submit() {
      if (this.$refs.form.validate()) {
        this.demande.fonctionnaire_id = this.fonctionnaire.id;
        this.demande.statut= "En Attente";
        this.$Progress.start();
        axios
          .post("/addAttestationForFnct", this.demande)
          .then(response => {
            // JSON responses are automatically parsed.
            this.$Progress.finish();
            this.showSnackBar(response.data.message, "success");
            this.demandes.push(response.data.demande);
            console.log(response.data.demande);
            this.$refs.form.reset();
            this.dialog = false;
          })
          .catch(e => {
            this.$Progress.fail();
            this.showSnackBar("Une Erreur Est Survenue", "error");
            this.errors.push(e);
          });
      }
    },
    cancel() {
      this.$refs.form.reset();
      this.dialog = false;
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