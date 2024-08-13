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
                  <v-text-field label="Libellé" v-model.trim.lazy="nature.libelle" :rules="libelleRules" required>
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
          Supprimer Une nature
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
            label="Chercher Une nature"
            v-model="search"
          ></v-text-field>     
        <v-data-table :headers="headers" :items="items" hide-actions class="elevation-1" :search="search"
             no-results-text="Aucun Enregistrement trouvé"
             no-data-text="La Liste est Vide">
          <template slot="items" slot-scope="props">
            <td>{{ props.item.libelle }}</td>
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
        libelleRules: [v => !!v || "Veuillez Entrer Le libellé de la nature"],
        editedIndex: -1,
        nature: {
          id: "",
          libelle: "",
          division_id:""
        },
        fonctionnaire: "",
        dialog: false,
        dialog_delete: false,
        items: [],
        item_delete: null,
        headers: [
          { align: "left", text: "Libelle", value: "libelle" },
          { align: "left", text: "Crée Le", value: "created_at" },
          { align: "left", text: "Modifié Le", value: "updated_at" },
          { text: "Actions", value: "name", sortable: false }
        ]
      };
    },
    computed: {
      formTitle: function () {
        return this.editedIndex === -1
          ? "Ajouter Une nature"
          : "Modifier Une nature";
      }
    },
    created() {
        this.fonctionnaire = getConnectedUser();
      axios
        .get("/getNatureByDivision/"+this.fonctionnaire.division_id)
        .then(response => {
          // JSON responses are automatically parsed.
          this.items = response.data.natures;
        })
        .catch(e => {
          this.errors.push(e);
        });
    },
    methods: {
      submit() {
        if (this.$refs.form.validate()) {
          if (this.editedIndex == -1) {
              this.nature.division_id=this.fonctionnaire.division_id;
            this.$Progress.start();
            axios
              .post("/natures", this.nature)
              .then(response => {
                // JSON responses are automatically parsed.
                console.log(response);
                this.$Progress.finish();
                this.items.push(response.data.nature);
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
                "/natures/" + this.nature.id,
                this.nature
              )
              .then(response => {
                console.log(response);
                this.$Progress.finish();
                this.items[this.editedIndex].libelle = this.nature.libelle;
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
          .delete("/natures/" + this.item_delete.id)
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
        this.nature.id = item.id;
        this.nature.libelle = item.libelle;
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