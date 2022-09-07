<template >
  <v-container >
 <h1 style="color: white; text-shadow: 2px 2px 4px black;">LISTA GENERAL DE PROFESORES</h1> <br>
    <v-window v-model=step >
      <v-window-item :value="1" color="blue">
       
       <h1 style="color: white; text-shadow: 2px 2px 4px black;">INGRESAR UN NUEVO PROFESOR:
         
        <v-btn color="blue" dark    fab  class="mx-2"  @click="(step = 2)">
            <v-icon dark>
              mdi-plus
            </v-icon>
          </v-btn></h1><br>

        <v-simple-table>

          <template v-slot:default  >
            <thead>
              <tr>
                <th class="text-xs-left" >
                  ID
                </th>
                <th class="text-xs-left">
                  Nombre
                </th>
                <th class="text-xs-left">
                  Apellido
                </th>
                <th class="text-xs-left">
                  Mostrar
                </th>
                <th class="text-xs-left">
                  Acciones
                </th>

              </tr>
            </thead>
            <tbody >
              <tr v-for="profesor in profesores" :key="profesor.id">
                <td>{{ profesor.id }}</td>
                <td>{{ profesor.nombre }}</td>
                <td>{{ profesor.apellido }}</td>
                <td>{{ profesor.mostrar }}</td>
  
       <v-icon right
                dark
                class="mt-4" 
                small
                color="green"
         @click="mostrarProfesor(profesor.id, step = 3)"> mdi-pencil</v-icon>

        <v-icon
            right
            small
            dark
            class="mt-4" 
            color="red"
          @click="eliminarProfesor(profesor.id)"
          >
            mdi-delete
          </v-icon>
              </tr>
            </tbody>
          </template>
        </v-simple-table>

      </v-window-item>
      <v-window-item :value="2">
        <div>
          <v-btn color="blue" elevation="10" dark title @click="(step = 1)">Volver</v-btn>
        </div>
        <v-col cols="12" sm="6">
            <v-card >
          <v-card-text class="mt-12">
            <h2 style="color: black ; text-shadow: 2px 2px 4px white;" class="tex-center">Crear Nuevo Profesor</h2>
            <v-spacer></v-spacer>
            <v-row>
              <v-col cols="12" sm="12">
                <v-text-field v-model="nuevoProfesor.nombre" elevation="10" label="Nombre"  color="blue"
                  class="mt-4"></v-text-field>
              </v-col>
              <v-col cols="12" sm="12">
                <v-text-field v-model="nuevoProfesor.apellido" elevation="10" label="Apellido" 
                  color="blue" class="mt-4"></v-text-field>
              </v-col>
              <v-col cols="12" sm="12">
                <v-text-field v-model="nuevoProfesor.mostrar" elevation="10" label="Mostrar"  color="blue"
                  class="mt-4"></v-text-field>
              </v-col>
            </v-row>
            <v-btn color="green" dark block title elevation="10" @click="agregarProfesor(step=1)">Crear</v-btn>

          </v-card-text>
          </v-card>
        </v-col>
      </v-window-item>
      <v-window-item :value="3">
        <div>
          <v-btn color="blue" elevation="10" dark title @click="(step = 1)">Volver</v-btn>
        </div>
        <v-col cols="12" sm="6">
          <v-card >
          <v-card-text class="mt-12">
            <h2 style="color: black ; text-shadow: 2px 2px 4px white;">Editar Profesor</h2>
            <v-spacer></v-spacer>
            <v-row>
              <v-col cols="12" sm="12">
                <v-text-field v-model="profesor.nombre" elevation="10" label="Nombre" color="blue"
                  class="mt-4"></v-text-field>
              </v-col>
              <v-col cols="12" sm="12">
                <v-text-field v-model="profesor.apellido" elevation="10" label="Apellido"  color="blue"
                  class="mt-4"></v-text-field>
              </v-col>
              <v-col cols="12" sm="12">
                <v-text-field v-model="profesor.mostrar" elevation="10" label="Mostrar"  color="blue"
                  class="mt-4"></v-text-field>
              </v-col>
            </v-row>
            <v-btn color="green" dark block title elevation="10" @click="editarProfesor(profesor.id,profesor,(step=1))">Guardar</v-btn>

          </v-card-text>
        </v-card>
        </v-col>
      </v-window-item>

    </v-window>
  </v-container>
  
</template>

<script>

export default {
  name: 'AbmProfesor',
  data() {
    return {
       
      search: '',
      profesores:[],
      nuevoProfesor: {
        nombre: '',
        apellido: '',
        mostrar: '',
      },
      profesor: {
        id: '',
        nombre: '',
        apellido: '',
        mostrar: '',
      },
      step: 1,
    }
  },
  mounted: function () {
    var that = this
    that.listarProfesores()
  },
  methods: {
    agregarProfesor() {
      var that = this
      console.log(this.nuevoProfesor)
     this.axios.post("apiv1/profesor", this.nuevoProfesor)
        .then(function (response) {
          console.log(response)
          that.listarProfesores()
          alert('Profesor Creado con exito')
        })
    },
    listarProfesores() {
      var that = this
     this.axios.get("apiv1/profesor")
        .then(function (response) {
          that.profesores = response.data;
        })
    },
    eliminarProfesor(id) {
      var that = this
     this.axios.delete("apiv1/profesor/" + id)
        .then(function (response) {
          console.log(response);
          that.listarProfesores()
          alert('Profesor eliminado con exito')
        })
    },
    editarProfesor(id,profesor) {
      var that = this
      console.log(profesor)
     this.axios.put("apiv1/profesor/" + id, profesor)
        .then(function (response) {
          console.log(response)
        that.listarProfesores()
        alert('Profesor editado con exito')  
        })
    },
    mostrarProfesor(id) {
      var that = this
     this.axios.get("apiv1/profesor/" + id)
        .then(function (response) {
          that.profesor = response.data;
         
        })
    },
  }
}
</script> 




<style>

h1 { color: #fcfcfc; }

thead{

  background: #2a83cc;

}



</style> 