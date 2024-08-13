<template>
  <v-layout row wrap>
    <v-flex xs10 offset-xs1>
      <v-chip class="headline" color="blue-grey lighten-3">
        <v-icon class="pr-3">list</v-icon>Liste Des Congés Chef Division RH
      </v-chip>
      <v-divider></v-divider>
      <br>
      <v-select
        :items="statutItems"
        v-model="selectedStatut"
        label="Statut"
        item-value="id"
        item-text="libelle"
        single-line
        @change="loadCongeForRH"
      ></v-select>
      <br>
      <v-data-table
        :headers="headers"
        :items="congeItems"
        class="elevation-1"
        no-results-text="Aucun Enregistrement trouvé"
        no-data-text="La Liste est Vide"
      >
        <template slot="items" slot-scope="props">
          <tr style="cursor: pointer">
            <td>{{props.item.fonctionnaire.nom }} {{props.item.fonctionnaire.prenom }}</td>
            <td>{{props.item.dateDebut }}</td>
            <td>{{props.item.dateFin }}</td>
            <td>{{props.item.nb_jours }}</td>
            <td>{{props.item.adresse }}</td>
            <td>{{props.item.remplacant }}</td>
            <td>{{statutItems[props.item.statut].libelle }}</td>
            <td class="justify-center">
              <v-tooltip right v-if="props.item.statut == 2">
                <v-btn
                  icon
                  class="mx-0"
                  slot="activator"
                  @click="changeStatutConge(props.item,'valider')"
                >
                  <v-icon color="teal">done</v-icon>
                </v-btn>
                <span>Valider</span>
              </v-tooltip>
              <v-tooltip right v-if="props.item.statut == 3">
                <v-btn
                  icon
                  class="mx-0"
                  slot="activator"
                  @click="changeStatutConge(props.item,'annuler')"
                >
                  <v-icon color="red">cancel</v-icon>
                </v-btn>
                <span>Annuler</span>
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
          text: "Nom & Prénom",
          sortable: false,
          value: "nom"
        },
        {
          align: "left",
          text: "Date Début",
          sortable: false,
          value: "dateDebut"
        },
        {
          align: "left",
          text: "Date Fin",
          sortable: false,
          value: "dateFin"
        },
        {
          align: "left",
          text: "Nombde de Jour",
          sortable: false,
          value: "nb_jours"
        },
        {
          align: "left",
          text: "Adresse",
          sortable: false,
          value: "adress"
        },
        {
          align: "left",
          text: "Remplaçant",
          sortable: false,
          value: "remplacant"
        },
        {
          align: "left",
          text: "Statut",
          sortable: false,
          value: "statut"
        },
        {
          align: "left",
          text: "Action",
          sortable: false
        }
      ],
      fonctionnaire: "",
      search: "",
      snackbar: false,
      timeout: 5000,
      snackbar_color: "",
      snackbar_message: "",
      statutItems: [
        { id: "-1", libelle: "Tous Les Congés" },
        { id: "1", libelle: "En Attente" },
        { id: "2", libelle: "Congé Validé (CD)" },
        { id: "3", libelle: "Congé Validé (RH)" }
      ],
      selectedStatut: "-1",
      congeItems: []
    };
  },
  mounted() {
    console.log(" im here");
    this.fonctionnaire = getConnectedUser();
    this.loadCongeForRH();
  },
  methods: {
    changeStatutConge(item, action) {
      //var missionIndex = this.missionItems.indexOf(item);
      var payload = null;
      if (action == "valider") {
        payload = {
          id: item.id,
          statut: 3
        };
      } else {
        payload = {
          id: item.id,
          statut: 2
        };
      }
      axios
        .post("/changeCongeStatut", payload)
        .then(response => {
          // JSON responses are automatically parsed.
          this.$Progress.finish();
          this.showSnackBar("Opération effectuée Avec Succées", "success");
          item.statut = response.data.conge.statut;
        })
        .catch(e => {
          this.$Progress.fail();
          this.showSnackBar("Une Erreur Est Survenue", "error");
          console.log(e);
        });
    },
    loadCongeForRH() {
      axios
        .get("/loadCongeForRH/" + this.selectedStatut)
        .then(response => {
          // JSON responses are automatically parsed.
          this.$Progress.finish();
          this.congeItems = response.data.conges;
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
    }
  }
};
</script>