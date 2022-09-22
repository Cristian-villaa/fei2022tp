<template>
  <v-container>

    <v-app-bar
    app
    color=" blue darken-3"
    dark
    elevation="4"
     
      src="https://cdn.vuetifyjs.com/images/backgrounds/vbanner.jpg"
    >
        <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
            <v-toolbar-title>Aulas Curza</v-toolbar-title>
   
      <v-spacer></v-spacer>
     

     <v-btn text to="/">
       Inicio
          
         </v-btn>  
    
 
      <v-btn text to="/about/">
         Acerca De
   </v-btn> 


  <v-btn text to="/AbmAulas">
        Aulas
     </v-btn> 


     <v-btn text to="/materias">
      Materias
   </v-btn> 


     <v-btn  text to="/profesor">
        Profesores
  </v-btn> 


      <v-btn text to="/carrera">
        Carreras
  </v-btn> 
  
  <v-btn text to="/reserva">
        Reservas
  </v-btn> 
  <v-btn text to="/horario">
        Horarios
  </v-btn> 
<template>
    
      <v-dialog
        v-model="dialog"
        fullscreen
        hide-overlay
        transition="dialog-bottom-transition"
      >
        <template v-slot:activator="{ on, attrs }">
        

          <v-btn  small text to="/" fab 
            dark @click="logout">
        <v-icon>mdi-exit-to-app</v-icon>
      </v-btn>
      <v-btn 
          small text fab 
            dark
            v-bind="attrs"
            v-on="on"
          >
          <v-icon>mdi-cog-outline</v-icon>
          </v-btn>
        </template>
        <v-card>
          <v-toolbar
            dark
            color="primary"
          >
            <v-btn
              icon
              dark
              @click="dialog = false"
            >
              <v-icon>mdi-close</v-icon>
            </v-btn>
            <v-toolbar-title>Configuraciòn</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items>
              <v-btn
                dark
                text
                @click="dialog = false"
              >
                Guardar
              </v-btn>
            </v-toolbar-items>
          </v-toolbar>
          <v-list
            three-line
            subheader
          >
            <v-subheader>Controles de usuario</v-subheader>
            <v-list-item>
              <v-list-item-content>
                <v-list-item-title>Filtrado de contenido</v-list-item-title>
                <v-list-item-subtitle>Set the content filtering level to restrict apps that can be downloaded</v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
            <v-list-item>
              <v-list-item-content>
                <v-list-item-title>Contraseña</v-list-item-title>
                <v-list-item-subtitle>Requerir de contraseña para poder realizar los cambios efectuados en las tablas</v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
          </v-list>
          <v-divider></v-divider>
          <v-list
            three-line
            subheader
          >
            <v-subheader>General</v-subheader>
            <v-list-item>
              <v-list-item-action>
                <v-checkbox v-model="notifications"></v-checkbox>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>Notificaciones</v-list-item-title>
                <v-list-item-subtitle>Notificarme sobre actualizaciones de  la aplicacion</v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
            <v-list-item>
              <v-list-item-action>
                <v-checkbox v-model="sound"></v-checkbox>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>Sound</v-list-item-title>
                <v-list-item-subtitle>Actualización automática de la aplicacion en cualquier momento. Se pueden aplicar cargos de datos</v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
            <v-list-item>
              <v-list-item-action>
                <v-checkbox v-model="widgets"></v-checkbox>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>Auto-add widgets</v-list-item-title>
                <v-list-item-subtitle>Agregar widgets automáticamente</v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
          </v-list>
          
        </v-card>
      </v-dialog>
      
  </template>
     
    </v-app-bar>
  
    <v-navigation-drawer
      app
      v-model="drawer"
      absolute
      bottom
      temporary
      dark
      color="blue accent-3"
      
    >
      <v-list-item>
        <v-img
          alt="Aulas Logo"
          class="shrink mr-2"
          contain
          :src="require('../assets/uncoma.png')"
          transition="scale-transition"
          width="50" 
        />
        <v-list-item-content>
          <v-list-item-title class="text-h6">
            Aulas Curza
          </v-list-item-title>
          <v-list-item-subtitle>
            Universidad del Comahue
          </v-list-item-subtitle>
          </v-list-item-content>
      </v-list-item>
      <v-divider ></v-divider>
      <v-list dense
       nav
>
        <v-list-item
            v-for="item in items"
            :key="item.title"
            :to="item.to"
            link
        >
          <v-list-item-icon>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>


  </v-container>
</template>

<script>
  export default {
    name: 'MainMenu',

    data: () => ({
          dialog: false,
          notifications: false,
          sound: true,
          widgets: false,
       drawer: false,
      group: null,
      items: [
        { title: 'Home', icon: 'mdi-home', to: '/' },
        { title: 'Acerca de', icon: 'mdi-information', to: '/about' },
        { title: 'Aulas', icon: 'mdi-human-male-board', to: '/AbmAulas' },
        { title: 'Materias', icon: 'mdi-book-open-outline', to: '/materias'},
        { title: 'Profesores', icon: 'mdi-account-group-outline', to: '/profesor'},
         { title: 'Carreras', icon: 'mdi-account-school', to: '/carrera'},
         { title: 'Horario-Materia', icon: 'mdi-calendar-clock', to: '/horario'},
         { title: 'Reserva-Aula', icon: 'mdi-calendar', to: '/reserva'},
        ],
    }),
    
    mounted(){
      
    },
    computed: {

   },
   watch: {
      group () {
        this.drawer = false
      },
    },
    methods: {
      logout(){
        console.log('Logout...')
      }
    },
    

   
  }
</script>

