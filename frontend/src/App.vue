<template>
  <v-app ref="app">

    <main-menu></main-menu>
     <v-main>
      <v-container fluid>
        <router-view/>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
import MainMenu from './components/MainMenu.vue';


export default {
  name: 'App',

  components: {
    MainMenu
   
  },

  data: () => ({
    //
    showMenu: true,
    items: [
     { title: 'Home', icon: 'mdi-view-dashboard', to: '/' },
      ],
  }),
};
</script>
<style>
#app {
  width: 100%;
    height: 100%;
  background:url('https://web.curza.uncoma.edu.ar/images/fondos/fondo5.jpg') no-repeat center center;
  background-size: cover;

}

</style>
