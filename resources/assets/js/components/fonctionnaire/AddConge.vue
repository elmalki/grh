<template>
  <v-layout row wrap>
    <v-flex xs10 offset-xs1>
      <v-card>
        <v-toolbar>
          <v-toolbar-title>Demander Un Congé</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-toolbar-items class="hidden-sm-and-down">
            <v-icon>add</v-icon>
          </v-toolbar-items>
        </v-toolbar>
        <v-card-text>
          <v-layout>
            <v-flex xs10 offset-xs1>
              <v-menu
                ref="menu2"
                :close-on-content-click="false"
                v-model="menu2"
                :nudge-right="40"
                :return-value.sync="date"
                lazy
                transition="scale-transition"
                offset-y
                full-width
                min-width="290px"
              >
                <v-text-field
                  slot="activator"
                  v-model="conge.dateDebut"
                  label="Date Début"
                  prepend-icon="event"
                  readonly
                ></v-text-field>
                <v-date-picker
                  v-model="conge.dateDebut"
                  @input="$refs.menu2.save(date)"
                  :allowed-dates="allowedDates"
                  @change="calculerDate"
                ></v-date-picker>
              </v-menu>

              <v-slider
                :max="fonctionnaire.solde_conge"
                v-model="conge.nb_jours"
                @change="calculerDate"
                thumb-color="orange"
                thumb-label="always"
                prepend-icon="trending_up"
                :thumb-size="24"
              ></v-slider>

              <v-text-field
                label="Date Retour"
                readonly
                v-model="conge.dateFin"
                prepend-icon="replay"
              ></v-text-field>

              <v-text-field label="Remplaçant" prepend-icon="person_pin" v-model="conge.remplacant"></v-text-field>
              <v-text-field label="Adresse" v-model="conge.adresse" prepend-icon="home" textarea></v-text-field>
            </v-flex>
          </v-layout>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-flex xs8 offset-xs2>
            <br>
            <v-btn color="success" large block @click="save">Enregistrer</v-btn>
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
import getConnectedUser from "../../helpers/User";
import Moment from "moment";
import { extendMoment } from "moment-range";
const moment = extendMoment(Moment);
export default {
  data() {
    return {
      snackbar: false,
      timeout: 5000,
      snackbar_color: "",
      snackbar_message: "",
      fonctionnaire: "",
      menu2: false,
      date: null,
      jourRepos: [],
      conge: {
        dateDebut: "",
        dateFin: "",
        nb_jours: "",
        adresse: "",
        statut: "",
        fonctionnaire_id: "",
        remplacant: ""
      },
      dateDebutObject: null,
      dateFinObject: null,
      dateFinFinal: null
    };
  },
  mounted() {
    this.fonctionnaire = getConnectedUser();
    this.getJourReposByCurrentYear();
  },
  methods: {
    allowedDates: val => ![0, 6].includes(new Date(val).getDay()),

    getJourReposByCurrentYear() {
      axios
        .get("/getJourReposByCurrentYear")
        .then(response => {
          // JSON responses are automatically parsed.
          this.$Progress.finish();
          this.jourRepos = response.data;
        })
        .catch(e => {
          this.$Progress.fail();
          console.log(e);
        });
    },
    save() {
      this.$Progress.start();
      this.conge.fonctionnaire_id = this.fonctionnaire.id;
      this.conge.statut = "1";
      axios
        .post("/demanderConge", this.conge)
        .then(response => {
          // JSON responses are automatically parsed.
          this.$Progress.finish();
          this.showSnackBar(response.data.message, "success");
          console.log(response.data);
          this.$router.push("fnct_conge");
        })
        .catch(e => {
          this.$Progress.fail();
          this.showSnackBar("Une Erreur Est Survenue", "error");
          console.log(e);
        });
    },
    calculerDate() {
      this.dateDebutObject = moment(this.conge.dateDebut);
      this.addDays2();

      this.conge.dateFin = this.dateFinObject.format("YYYY-MM-DD");
    },
    addDays2() {
      var tmpDate = moment(this.dateDebutObject.format("YYYY-MM-DD"));
      var i;
      var nbr_to_add = this.conge.nb_jours;
      for (i = 0; i < nbr_to_add; i++) {
        console.log(tmpDate.format("YYYY-MM-DD"));

        if (this.checkIfRepos(tmpDate.format("YYYY-MM-DD"))) {
          console.log(tmpDate.format("YYYY-MM-DD") + " is repos");
          nbr_to_add++;
        }

        if (tmpDate.weekday() == 0 || tmpDate.weekday() == 6) {
          nbr_to_add++;
        }
        tmpDate.add(1, "d");
        console.log("new nbr to add " + nbr_to_add);
      }
      if (tmpDate.weekday() == 0 ) {
          tmpDate.add(1, "d");
        }
        if (tmpDate.weekday() == 6) {
          tmpDate.add(2, "d");
        }
      this.dateFinObject = tmpDate;

    },
    checkIfRepos(item) {
      var itemObject = moment(item);
      var i;
      for (i = 0; i < this.jourRepos.length; i++) {
        if (
          this.jourRepos[i] == item &&
          itemObject.weekday() != 0 &&
          itemObject.weekday() != 6
        )
          return true;
      }
      return false;
    },
    showSnackBar(message, type) {
      this.snackbar_message = message;
      this.snackbar_color = type;
      this.snackbar = true;
    }
  }
};
</script>
