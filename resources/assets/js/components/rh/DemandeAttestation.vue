<template>
  <v-layout row wrap>
    <v-flex xs10 offset-xs1>
      <v-select
        :items="statutItems"
        v-model="selectedStatut"
        label="Statut"
        item-value="id"
        item-text="libelle"
        single-line
        @change="loadAttestationByStatut"
      ></v-select>
      <v-data-table
        :headers="headers"
        :items="demandes"
        hide-actions
        class="elevation-1"
        no-results-text="Aucun Enregistrement trouvé"
        no-data-text="La Liste est Vide"
      >
        <template slot="items" slot-scope="props">
          <td>{{ props.item.fonctionnaire }}</td>
          <td>{{ props.item.libelle }}</td>
          <td>{{ props.item.statut }}</td>
          <td>{{ props.item.nombre }}</td>
          <td>{{ props.item.created_at }}</td>
          <td>{{ props.item.updated_at }}</td>
          <td class="justify-center">
            <v-tooltip right v-if="props.item.statut == 'En Attente'">
              <v-btn icon class="mx-0" @click="validerDeamnde(props.item)" slot="activator">
                <v-icon color="teal">check</v-icon>
              </v-btn>
              <span>Attestation Préparée</span>
            </v-tooltip>
          </td>
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
        { align: "left", text: "Fonctionnaire", value: "fonctionnaire" },
        { align: "left", text: "Libelle", value: "libelle" },
        { align: "left", text: "Statut", value: "statut" },
        { align: "left", text: "Nombre", value: "nombre" },
        { align: "left", text: "Date Demande", value: "created_at" },
        { align: "left", text: "Préparée Le", value: "updated_at" },
        { align: "left", text: "Action", value: "" }
      ],
      fonctionnaire: "",
      demande: {
        attestation_id: "",
        fonctionnaire_id: "",
        nombre: 1,
        statut: ""
      },
      statutItems:["Tous","En Attente","Validé"],
      selectedStatut:"Tous"
    };
  },
  mounted() {
    this.fonctionnaire = getConnectedUser();
    this.loadRequestAttestation();
  },
  methods: {
    loadRequestAttestation() {
      axios
        .get("/getDemandeAttestationForRH/Tous")
        .then(response => {
          // JSON responses are automatically parsed.
          this.demandes = response.data.demandes;
        })
        .catch(e => {
          this.errors.push(e);
        });
    },
    validerDeamnde(item) {
      this.$Progress.start();
      axios
        .get("/validerDemande/"+item.id)
        .then(response => {
          // JSON responses are automatically parsed.
          
          this.$Progress.finish();
          this.showSnackBar(response.data.message, "success");
          item.statut = "Validé"
        })
        .catch(e => {
          this.errors.push(e);
          this.$Progress.fail();
        });
    },
    loadAttestationByStatut(){
      this.$Progress.start();
      axios
        .get("/getDemandeAttestationForRH/"+this.selectedStatut)
        .then(response => {
          // JSON responses are automatically parsed.
          this.$Progress.finish();
          this.demandes = response.data.demandes;
        })
        .catch(e => {
          this.$Progress.fail();
          this.errors.push(e);
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