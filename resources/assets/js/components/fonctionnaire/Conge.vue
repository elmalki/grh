<template>
    <v-layout row wrap>
        
        <v-flex xs10 offset-xs1>
            <v-chip class="headline" color="blue-grey lighten-3">
                <v-icon class="pr-3">list</v-icon>
                Liste Des Congés
            </v-chip>
            <v-divider></v-divider>
            <br>
            
            <v-data-table :headers="headers" :items="congeItems" class="elevation-1"
                no-results-text="Aucun Enregistrement trouvé" no-data-text="La Liste est Vide">
                <template slot="items" slot-scope="props">
                    <tr style="cursor: pointer">
                      <td>{{props.item.created_at }}</td>
                        <td>{{props.item.dateDebut }}</td>
                        <td>{{props.item.dateFin }}</td>
                        <td>{{props.item.nb_jours }}</td>
                        <td>{{props.item.adresse }}</td>
                        <td>{{props.item.remplacant }}</td>
                        <td>{{ statutList[props.item.statut] }}</td>
                        <td class="justify-center">
                            <v-tooltip right v-if="props.item.statut == 1">
                                <v-btn  icon class="mx-0" 
                                    slot="activator" @click="annulerConge(props.item)">
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
          text: "Date Demande",
          sortable: true,
          value: "created_at"
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
          text: "Nbr Jour",
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
      statutList: ["","En Attente", "Congé Validé (CD)", "Congé Validé (RH)"],
      congeItems: []
    };
  },
  mounted() {
    this.fonctionnaire = getConnectedUser();

    axios
      .get("/getCongesByFnctID/" + this.fonctionnaire.id)
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
  methods: {
    annulerConge(item) {
      const index = this.congeItems.indexOf(item);
      this.$Progress.start();
      axios
        .post("/supprimerConge/" + item.id)
        .then(response => {
          // JSON responses are automatically parsed.
          this.$Progress.finish();
          this.congeItems.splice(index, 1);
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