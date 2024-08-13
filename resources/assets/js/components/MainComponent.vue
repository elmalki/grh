<template>
  <v-app>
    <sidebar :drawer="drawer"></sidebar>
    <v-toolbar app color="primary" :clipped-left="$vuetify.breakpoint.mdAndUp" dark fixed>
      <v-toolbar-title style="width: 300px" class="ml-0 pl-3">
        <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
        <span class="hidden-sm-and-down">Ressources Humaines</span>
      </v-toolbar-title>
      <v-spacer></v-spacer>

      <!-- <span class="caption mr-3">All Right Reserved</span>
      <v-icon large>important_devices</v-icon>-->
      <v-tooltip bottom>
        <v-icon slot="activator" class="logout" @click="logout">replay</v-icon>
        <span>Log OUT</span>
      </v-tooltip>
    </v-toolbar>
    <v-content>
      <v-container fluid>
        <form id="logoutForm" action="/logout" method="POST" style="display: none;">
          <input name="_token" value type="hidden" id="token_logout">
        </form>
        <router-view></router-view>
      </v-container>
    </v-content>
    <v-footer app></v-footer>
  </v-app>
</template>

<script>
import getConnectedUser from "../helpers/User";
export default {
  data() {
    return {
      drawer: true,
      fonctionnaire: ""
    };
  },
  mounted() {
    this.fonctionnaire = getConnectedUser();
  },
 
  methods: {
    logout() {
      document.getElementById(
        "token_logout"
      ).value = document.head.querySelector('meta[name="csrf-token"]').content;
      logoutForm.submit();
    }
  }
};
</script>
<style>
.logout {
  cursor: pointer;
}

.logout:hover {
  color: orange;
}
</style>