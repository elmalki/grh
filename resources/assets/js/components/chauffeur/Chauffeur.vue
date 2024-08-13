<template>
  <v-layout row wrap>
    <v-dialog v-model="dialog" width="600px">
      <v-card>
        <v-card-title class="title">
          <v-icon large color="blue" class="mr-3">info</v-icon>
          {{formTitle}}
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text>
          <v-container grid-list-sm class="pa-4">
            <v-layout row wrap>
              <v-flex xs12 align-center>
                <v-form v-model="valid" ref="form" lazy-validation @submit.prevent="submit">
                  <v-text-field label="CIN" v-model.trim.lazy="chauffeur.cin" :rules="cinRules" required>
                  </v-text-field>
                  <v-text-field label="Nom" v-model.trim.lazy="chauffeur.nom" :rules="nomRules" required>
                  </v-text-field>
                  <v-text-field label="Prénom" v-model.trim.lazy="chauffeur.prenom" :rules="prenomRules" required>
                  </v-text-field>
                  <v-text-field label="Téléphone" v-model.trim.lazy="chauffeur.phone" :rules="phoneRules" required>
                  </v-text-field>
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
    <v-dialog v-model="dialog_delete" width="400px">
      <v-card>
        <v-card-title class="title">
          <v-icon large color="red" class="mr-3">warning</v-icon>
          Supprimer Un Chauffeur
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text class="body-2">Voulez vous vraiment supprimer cet élément de la liste</v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="red" dark @click.native="confirmDelete">
            Oui
            <v-icon right>check_circle</v-icon>

          </v-btn>
          <v-btn dark @click.native="dialog_delete = false">
            Non
            <v-icon right>block</v-icon>
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-flex xs10 offset-xs1>
        <v-text-field
            append-icon="search"
            label="Chercher Un Chauffeur"
            v-model="search"
          ></v-text-field>     
        <v-data-table :headers="headers" :items="items" hide-actions class="elevation-1" :search="search"
             no-results-text="Aucun Enregistrement trouvé"
             no-data-text="La Liste est Vide">
          <template slot="items" slot-scope="props">
            <td>{{ props.item.cin }}</td>
            <td>{{ props.item.nom }}</td>
            <td>{{ props.item.prenom }}</td>
            <td>{{ props.item.phone }}</td>
            <td>{{ props.item.created_at }}</td>
            <td>{{ props.item.updated_at }}</td>
            <td class="justify-center layout px-0">
              <v-btn icon class="mx-0" @click="editItem(props.item)">
                <v-icon color="teal">edit</v-icon>
              </v-btn>
              <v-btn icon class="mx-0" @click="deleteItem(props.item)">
                <v-icon color="red">delete</v-icon>
              </v-btn>
            </td>
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
        search:'',
        snackbar: false,
        timeout: 5000,
        snackbar_color: "",
        snackbar_message: "",
        valid: true,
        cinRules: [v => !!v || "Veuillez Entrer Le CIN du Chauffeur"],
        nomRules: [v => !!v || "Veuillez Entrer Le Nom du Chauffeur"],
        prenomRules: [v => !!v || "Veuillez Entrer Le Prénom du Chauffeur"],
        phoneRules: [v => !!v || "Veuillez Entrer  Le Téléphone du Chauffeur"],
        editedIndex: -1,
        chauffeur: {
          id: "",
          cin: "",
          nom: "",
          prenom: "",
          phone: "",
          
        },
        fonctionnaire: "",
        dialog: false,
        dialog_delete: false,
        items: [],
        item_delete: null,
        headers: [
          { align: "left", text: "CIN", value: "cin" },
          { align: "left", text: "Nom", value: "nom" },
          { align: "left", text: "Prénom", value: "prenom" },
          { align: "left", text: "Téléphone", value: "phone" },
          { align: "left", text: "Crée Le", value: "created_at" },
          { align: "left", text: "Modifié Le", value: "updated_at" },
          { text: "Actions", value: "name", sortable: false }
        ]
      };
    },
    computed: {
      formTitle: function () {
        return this.editedIndex === -1
          ? "Ajouter Un Chauffeur"
          : "Modifier Un Chauffeur";
      }
    },
    created() {
        this.fonctionnaire = getConnectedUser();
      axios
        .get("/chauffeurs")
        .then(response => {
          // JSON responses are automatically parsed.
          this.items = response.data.chauffeurs;
        })
        .catch(e => {
          this.errors.push(e);
        });
    },
    methods: {
      submit() {
        if (this.$refs.form.validate()) {
          if (this.editedIndex == -1) {
            this.$Progress.start();
            axios
              .post("/chauffeurs", this.chauffeur)
              .then(response => {
                // JSON responses are automatically parsed.
                console.log(response);
                this.$Progress.finish();
                this.items.push(response.data.chauffeur);
                this.$refs.form.reset();
                this.dialog = false;
                this.showSnackBar(response.data.message, "success");
              })
              .catch(e => {
                this.$Progress.fail();
                this.showSnackBar("Une Erreur Est Survenue", "error");
                console.log(e);
              });
          } else {
            this.$Progress.start();
            axios
              .patch(
                "/chauffeurs/" + this.chauffeur.id,
                this.chauffeur
              )
              .then(response => {
                console.log(response);
                this.$Progress.finish();
                this.items[this.editedIndex].cin = this.chauffeur.cin;
                this.items[this.editedIndex].nom = this.chauffeur.nom;
                this.items[this.editedIndex].prenom = this.chauffeur.prenom;
                this.items[this.editedIndex].phone = this.chauffeur.phone;
                this.$refs.form.reset();
                this.dialog = false;
                this.showSnackBar(response.data.message, "success");
              })
              .catch(e => {
                this.$Progress.fail();
                this.showSnackBar("Une Erreur Est Survenue", "error");
                console.log(e);
              });
          }
        }
      },
      cancel() {
        this.$refs.form.reset();
        this.dialog = false;
      },
      deleteItem(item) {
        this.item_delete = item;
        //confirm('Voulez vous vraiment supprimer cet élément ??') && this.items.splice(index, 1)
        this.dialog_delete = true;
      },
      confirmDelete() {
        this.$Progress.start();
        axios
          .delete("/chauffeurs/" + this.item_delete.id)
          .then(response => {
            // JSON responses are automatically parsed.
            const index = this.items.indexOf(this.item_delete);
            this.items.splice(index, 1);
            console.log(response);
            this.$Progress.finish();
            this.dialog_delete = false;
            this.showSnackBar(response.data.message, "success");
          })
          .catch(e => {
            this.$Progress.fail();
            this.showSnackBar("Une Erreur Est Survenue", "error");
            console.log(e);
          });
      },
      newItem() {
        this.dialog = !this.dialog;
        this.editedIndex = -1;
        // this.nature={
        //   id:'',
        //   libelle:''
        // }
      },
      editItem(item) {
        this.editedIndex = this.items.indexOf(item);
        this.chauffeur.id = item.id;
        this.chauffeur.cin = item.cin;
        this.chauffeur.nom = item.nom;
        this.chauffeur.prenom = item.prenom;
        this.chauffeur.phone = item.phone;
        this.dialog = true;
      },
      showSnackBar(message, type) {
        this.snackbar_message = message;
        this.snackbar_color = type;
        this.snackbar = true;
      }
    }
  };
</script>