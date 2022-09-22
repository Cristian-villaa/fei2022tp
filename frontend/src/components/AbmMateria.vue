
<template>
    <v-col cols="12" sm="12">
        <v-container>
              <h1 style="color: white; text-shadow: 2px 2px 4px black;">LISTADO DE MATERIAS</h1> <br>
            <v-window v-model=step>
                <v-window-item :value="1">
                  
                      <h2 style="color: white; text-shadow: 2px 2px 4px black;">NUEVA MATERIA:
                            
                            <v-btn color="primary" dark    fab  class="mx-2"  @click="(step = 2)">
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
                                        Nombre
                                    </th>
                                    <th class="text-left">
                                        Cantidad de Alumnos
                                    </th>
                                    <th class="text-left">
                                        Carrera
                                    </th>
                                    <th class="text-left">
                                        Profesor
                                    </th>
                                    <th class="text-left">
                                        Acciones
                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="materia in materias" :key="materia.id">

                                    <td>{{ materia.id }}</td>
                                    <td>{{ materia.nombre }}</td>
                                    <td>{{ materia.cant_alumnos }}</td>
                                    <td>{{ materia.carrera.nombre }}</td>
                                    <td>{{ materia.profesor.nombre }} {{ materia.profesor.apellido }}</td>
                                     <v-icon right
                                                dark
                                                class="mt-4" 
                                                small
                                                color="green"
                                         @click="mostrarMateria(materia.id, step = 3)"> mdi-pencil</v-icon>
                                            <v-icon
                                                right
                                                small
                                                dark
                                                class="mt-4" 
                                                color="red"
                                            @click="eliminarMateria(materia.id)"
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
                            <h2  style="color: black ; text-shadow: 2px 2px 4px white;" class="tex-center">Crear Nueva Materia</h2>
                            <v-spacer></v-spacer>
                            <v-row>
                                <v-col cols="12" sm="12">
                                    <v-text-field v-model="nuevaMateria.nombre" elevation="10" label="Nombre Materia"
                                         color="blue" class="mt-4"></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="12">
                                    <v-text-field v-model="nuevaMateria.cant_alumnos" elevation="10"
                                        label="Cantidad de Alumnos"  color="blue" class="mt-4">
                                    </v-text-field>
                                </v-col>
                                <v-col cols="12" sm="12">
                                    <v-select v-model="nuevaMateria.id_carrera" :items=carreras item-value="id"
                                        label="Carrera" required  color="blue" class="mt-4">
                                    </v-select>
                                </v-col>
                                <v-spacer></v-spacer>
                                <v-col cols="12" sm="12">
                                    <v-select v-model="nuevaMateria.id_profesor" :items=profesores item-value="id"
                                        label="Profesor" required  color="blue" class="mt-4">
                                    </v-select>
                                </v-col>
                            </v-row>
                            <br>
                            <br>
                            <v-btn color="primary" dark block title elevation="10" @click="crearMateria(step = 1)">Crear
                            </v-btn>

                        </v-card-text>
                        </v-card>
                    </v-col>
                </v-window-item>
                <v-window-item :value="3">
                    <div>
                        <v-btn color="blue" elevation="10" dark title @click="(step = 1)">Volver</v-btn>
                    </div>
                    <v-col cols="12" sm="6">
                        <v-card>
                        <v-card-text class="mt-12">
                            <h2 style="color: black; text-shadow: 2px 2px 4px white;" class="tex-center">Editar Materia</h2>
                            <v-spacer></v-spacer>
                            <v-row>
                                <v-col cols="12" sm="12">
                                    <v-text-field v-model="materiamodificada.nombre" elevation="10"
                                        label="Nombre Materia"  color="blue" class="mt-4"></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="12">
                                    <v-text-field v-model="materiamodificada.cant_alumnos" elevation="10"
                                        label="Cantidad de Alumnos"  color="blue" class="mt-4">
                                    </v-text-field>
                                </v-col>
                                <v-col cols="12" sm="12">
                                    <v-select v-model="carrera_select" :items=carreras item-value="id"
                                        @input="capturarIdCarrera()" required  color="blue" class="mt-4">
                                    </v-select>
                                </v-col>
                                <v-spacer></v-spacer>
                                <v-col cols="12" sm="12">
                                    <v-select v-model="profesor_select" :items=profesores item-value="id"
                                        @input="capturarIdProfesor()" required  color="blue" class="mt-4">
                                    </v-select>
                                </v-col>
                                
                            </v-row>
                            
                            <br>
                            <br>
                            <v-btn color="primary" dark block title elevation="10"
                                @click="editarMateria(materiamodificada.id, materiamodificada, step = 1)">Guardar Cambios
                            </v-btn>

                        </v-card-text>
                    </v-card>
                    </v-col>
                </v-window-item>
            </v-window>
        </v-container>
    </v-col>
</template>



<script>

export default {
    data() {
        return {
            carreras: [],
            profesores: [],
            materias: [],
            materiamodificada: {
                id: '',
                nombre: '',
                cant_alumnos: '',
                id_carrera: '',
                id_profesor: '',
            },
            profesor_select: '',
            carrera_select: '',
            nuevaMateria: {
                id: '',
                nombre: '',
                cant_alumnos: '',
                id_carrera: '',
                id_profesor: '',
                carrera: [],
                profesor: [],
            },
            step: 1,
        }
    },
    mounted: function () {
        var that = this
        that.listarMaterias()
        that.cargarCarreras()
        that.cargarProfesores()
    },
    methods: {
        listarMaterias() {
            var that = this
          this.axios.get("apiv1/materia")
                .then(function (response) {
                    that.materias = response.data;
                    console.log(response.data)
                });
        },
        crearMateria() {
            var that = this
           this.axios.post("apiv1/materia", this.nuevaMateria)
                .then(function (response) {
                    console.log(response)
                    that.listarMaterias()
                    alert('Materia creada con exito')
                })
        },
        cargarCarreras() {
            var that = this
            this.axios.get("apiv1/carrera")
                .then(function (response) {
                    for (let i = 0; i < response.data.length; i++) {
                        let carrera = []
                        carrera.id = response.data[i].id;
                        carrera.text = response.data[i].nombre;
                        that.carreras.push(carrera)
                    }
                })
        },
        cargarProfesores() {
            var that = this
            this.axios.get("apiv1/profesor")
                .then(function (response) {
                    for (let i = 0; i < response.data.length; i++) {
                        let profesor = []
                        profesor.id = response.data[i].id;
                        profesor.text = response.data[i].nombre + ' ' + response.data[i].apellido;
                        that.profesores.push(profesor)
                    }
                })
        },
        eliminarMateria(id) {
            var that = this
            this.axios.delete("apiv1/materia/" + id)
                .then(function (response) {
                    console.log(response);
                    that.listarMaterias()
                    alert('Materia eliminada con exito')
                })
        },
        mostrarMateria(id) {
            var that = this
            this.axios.get("apiv1/materia/" + id)
                .then(function (response) {
                    const { id,nombre,cant_alumnos,profesor,carrera} = response.data;
                    that.materiamodificada.id = id;
                    that.materiamodificada.nombre = nombre;
                    that.materiamodificada.cant_alumnos = cant_alumnos;
                    that.materiamodificada.id_carrera = carrera.id
                    that.materiamodificada.id_profesor = profesor.id
                    that.carrera_select = { text: response.data.carrera.nombre, id: response.data.carrera.id }
                    that.profesor_select = { text: response.data.profesor.nombre + " " + response.data.profesor.apellido, id: response.data.profesor.id }
                    console.log(that.materiamodificada)
                })
        },
        editarMateria(id, materia) {
            var that = this
            console.log(materia)
            this.axios.put("apiv1/materia/" + id, materia)
                .then(function () {
                    that.listarMaterias()
                    alert('Materia modificada con exito')
                })
        },
        capturarIdProfesor() {
            this.materiamodificada.id_profesor = this.profesor_select
        },
        capturarIdCarrera() {
            this.materiamodificada.id_carrera = this.carrera_select
        },
    }
}
</script>

<style>


</style>
