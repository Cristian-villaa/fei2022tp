<template>
  <v-container>
    <h1 style="color: white; text-shadow: 2px 2px 4px black;">LISTADO GENERAL DE CARRERAS</h1> <br>
    <v-window v-model=step>
      <v-window-item :value="1">
     
 <h2 style="color: white; text-shadow: 2px 2px 4px black;">CREAR UNA NUEVA CARRERA:
          <v-btn color="primary" dark    fab  class="mx-2"  @click="(step = 2)">
            <v-icon dark>
              mdi-plus
            </v-icon>
          </v-btn> 
       </h2><br>
            <v-spacer></v-spacer>
        <v-simple-table>

          <template v-slot:default >
            <thead>
              <tr>
                <th class="text-left"  dark>
                  ID
                </th>
                <th class="text-left">
                  Nombre
                </th>
                <th class="text-left">
                  Acciones
                </th>

              </tr>
              
            </thead>
            <tbody>
              <tr v-for="carrera in carreras" :key="carrera.id">
                <td>{{ carrera.id }}</td>
                <td>{{ carrera.nombre }}</td>
                
             <v-icon right
                dark
                class="mt-4" 
                small
                color="green"
              @click="mostrarCarrera(carrera.id, step = 3)"> mdi-pencil</v-icon>
                 
            <v-icon
               right
                small
               dark
              class="mt-4" 
             color="red"
          @click="eliminarCarrera(carrera.id)"
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
          <v-btn color="primary" elevation="10" dark title @click="(step = 1)">Atras</v-btn>
        </div>
        <v-col cols="12" sm="6">
          <v-card>
          <v-card-text class="mt-12">
            <h2 class="tex-center">Agregar Carrera</h2>
            <v-spacer></v-spacer>
            <v-row>
              <v-col cols="12" sm="12">

              <v-text-field
                    v-model="nuevaCarrera.nombre"
                    label="Nombre"
                    required
                  ></v-text-field>

              </v-col>
            </v-row>
            <v-btn color="primary" dark block title elevation="5" @click="agregarCarrera(step = 1)">Crear</v-btn>

          </v-card-text>
          </v-card>
        </v-col>
      </v-window-item>
      <v-window-item :value="3">
        <div>
          <v-btn color="primary" elevation="10" dark title @click="(step = 1)">Volver</v-btn>
        </div>
        <v-col cols="12" sm="6">
          <v-card>
          <v-card-text class="mt-12">
            <h2 style="color: black ; text-shadow: 2px 2px 4px white;" class="tex-center">Editar Carrera</h2>
            <v-spacer></v-spacer>
            <v-row>
              <v-col cols="12" sm="12">
                <v-text-field v-model="carrera.nombre" elevation="10" label="Nombre"  color="blue"
                  class="mt-4"></v-text-field>
              </v-col>
             </v-row>
            
            <v-btn color="primary" type="success" dark block title elevation="10" @click="editarCarrera(carrera.id, carrera, (step = 1))">
              Guardar Cambios</v-btn>
          </v-card-text>
        </v-card> 
        </v-col>
      </v-window-item>

    </v-window>
  </v-container>
</template>

<script>


export default {
  name: 'AbmCarrera',
  data() {
    return {
        editedIndex: -1,
       dialogDelete: false,
      carreras: {
        id: '',
        nombre: '',

      },
      nuevaCarrera: {
        nombre: '',
      },
      carrera: {
        id: '',
        nombre: '',

      },
      step: 1,
    }
  },
  mounted: function () {
    var that = this
    that.listarCarreras()
  },

  methods: {
    agregarCarrera() {
      var that = this
      console.log(this.nuevaCarrera)
     this.axios.post("apiv1/carrera", this.nuevaCarrera)
        .then(function (response) {
          console.log(response)
          that.listarCarreras()
          alert('Carrera Creada con exito')
          
        })

    },
    listarCarreras() {
      var that = this
    this.axios.get("apiv1/carrera")
        .then(function (response) {
          that.carreras = response.data;
        })
    },
    eliminarCarrera(id) {
      var that = this
     this.axios.delete("apiv1/carrera/" + id)
        .then(function (response) {
          console.log(response);
          that.listarCarreras()
          alert('Carrera eliminada con exito')

        })
    },
    editarCarrera(id, carrera) {
      var that = this
      console.log(carrera)
     this.axios.put("apiv1/carrera/" + id, carrera)
        .then(function (response) {
          console.log(response)
          that.listarCarreras()
          alert('Carrera modificada con exito')
        })
    },
    mostrarCarrera(id) {
      var that = this
      this.axios.get("apiv1/carrera/" + id)
        .then(function (response) {
          that.carrera = response.data;

        })
    }

  }


}
</script>
<style>





h1,h2 { color: #fcfcfc; }





thead{

  background: #2a83cc;

}



</style> 