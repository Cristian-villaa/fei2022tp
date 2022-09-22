<template>
    <v-container>
        <h1 style="color: white; text-shadow: 2px 2px 4px black;">LISTADO DE AULAS</h1> <br>
        <v-window v-model=step>
            <v-window-item :value="1">
  <h2 style="color: white; text-shadow: 2px 2px 4px black;">CREAR AULA:
         
        <v-btn color="primary" dark fab  class="mx-2"  @click="(step = 2)">
            <v-icon dark>
              mdi-plus
            </v-icon>
          </v-btn></h2><br>



                <v-simple-table>

                    <template v-slot:default>
                        <thead>
                            <tr>
                                <th class="text-left">
                                    ID
                                </th>
                                <th class="text-left">
                                    Aula Nro
                                </th>
                                <th class="text-left">
                                    Ubicacion
                                </th>
                                <th class="text-left">
                                    Cantidad de Proyectores
                                </th>
                                <th class="text-left">
                                    Aforo
                                </th>
                                <th class="text-left">
                                    Climatizada
                                </th>
                                <th class="text-left">
                                    Acciones
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="aula in aulas" :key="aula.id">
                                <td>{{ aula.id }}</td>
                                <td>{{ aula.descripcion }}</td>
                                <td>{{ aula.ubicacion }}</td>
                                <td>{{ aula.cant_proyector }}</td>
                                <td>{{ aula.aforo }}</td>
                                <td>{{ aula.es_climatizada }}</td>

                                 <v-icon right
                                            dark
                                            class="mt-4" 
                                            small
                                            color="green"
                                    @click="mostrarAula(aula.id, step = 3)"> mdi-pencil</v-icon>
                                                        
                                 <v-icon
                                    right
                                        small
                                        dark
                                        class="mt-4" 
                                        color="red"
                                    @click="eliminarAula(aula.id)">
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
                     
                        <v-spacer></v-spacer>
               
                        <v-row>
                            
                            <v-col cols="12" sm="12">
                                <v-text-field v-model="nuevaAula.descripcion" elevation="10" label="Aula Numero"
                                     color="blue" class="mt-4"></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="12">
                                <v-text-field v-model="nuevaAula.ubicacion" elevation="10" label="Ubicacion" 
                                     color="blue" class="mt-4"></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="12">
                                <v-text-field v-model="nuevaAula.cant_proyector" elevation="10"
                                    label="Cantidad de proyectores"  color="blue" class="mt-4">
                                </v-text-field>
                            </v-col>
                            <v-col cols="12" sm="12">
                                <v-text-field v-model="nuevaAula.aforo" elevation="10" label="Aforo" 
                                    color="blue" class="mt-4"></v-text-field>
                            </v-col>
                <v-checkbox v-model="nuevaAula.es_climatizada" color="primary"
                 elevation="10" :label="`Es_climatizada: ${checkbox.toString()}`">
                </v-checkbox>
                        </v-row>
                        <v-btn color="primary" dark block title elevation="10" @click="agregarAula(step = 1)">Crear
                        </v-btn>

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
                        <h2 style="color:black ; text-shadow: 2px 2px 4px white;" class="tex-center">Editar Aula</h2>
                        <v-spacer></v-spacer>
                        <v-row>
                            <v-col cols="12" sm="12">
                                <v-text-field v-model="aula.descripcion" elevation="10" label="Descripcion" 
                                  color="blue" class="mt-4"></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="12">
                                <v-text-field v-model="aula.ubicacion" elevation="10" label="Ubicacion" 
                                    color="blue" class="mt-4"></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="12">
                                <v-text-field v-model="aula.cant_proyector" elevation="10"
                                    label="Cantidad de Proyectores"  color="blue" class="mt-4">
                                </v-text-field>
                            </v-col>
                            <v-col cols="12" sm="12">
                                <v-text-field v-model="aula.aforo" elevation="10" label="Aforo" 
                                    color="blue" class="mt-4"></v-text-field>
                            </v-col>

                                
                            <v-checkbox v-model="aula.es_climatizada" color="primary" 
                            elevation="10" :label="`Es_climatizada: ${checkbox.toString()}`"></v-checkbox>
                        
                        </v-row>
                        <v-btn color="primary" dark block title elevation="10"
                            @click="editarAula(aula.id, aula, (step = 1))">
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
    name: 'AbmAulas',
    data() {
        return {
            aulas: [],
            nuevaAula: {
                descripcion: '',
                ubicacion: '',
                cant_proyector: '',
                aforo: '',
                es_climatizada: '',
            },
            aula: {
                id: '',
                descripcion: '',
                ubicacion: '',
                cant_proyector: '',
                aforo: '',
                es_climatizada: '',
            },
            step: 1,
            checkbox: true,
        }
    },
    mounted: function () {
        var that = this
        that.listarAulas()
    },
    methods: {
        agregarAula() {
            var that = this
            console.log(this.nuevaAula)
           this.axios.post("apiv1/aula", this.nuevaAula)
           .then(function (response) {
                  console.log(response)
                    that.listarAulas()
                    alert('Aula Creada con exito')
                })
        },
        listarAulas() {
            var that = this
            this.axios.get("apiv1/aula")
                .then(function (response) {
                    that.aulas = response.data;
                })
        },
        eliminarAula(id) {
            var that = this
            this.axios.delete("apiv1/aula/" + id)
                .then(function (response) {
                    console.log(response);
                    that.listarAulas()
                    alert('Aula eliminada con exito')
                })
        },
        editarAula(id, aula) {
            var that = this
            console.log(aula)
           this.axios.put("apiv1/aula/" + id, aula)
                .then(function (response) {
                    console.log(response)
                    that.listarAulas()
                    alert('Aula modificada con exito')
                })
        },
        mostrarAula(id) {
            var that = this
           this.axios.get("apiv1/aula/" + id)
                .then(function (response) {
                    that.aula = response.data;
                })
        },
    }
}
</script> 
