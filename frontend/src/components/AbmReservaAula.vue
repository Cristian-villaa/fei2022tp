<template>
      <v-container>
        <h1 style="color: white; text-shadow: 2px 2px 4px black;">RESERVAS DE AULAS</h1> <br>
  <v-row class="fill-height">
    <v-col>
      <v-sheet height="64">
        <v-toolbar
          flat
        >

        <v-btn color="primary" dark class="mr-4" @click="dialog = true">Crear Reserva</v-btn>
          <v-btn
            outlined
            class="mr-4"
            color="grey darken-2"
            @click="setToday"
          >
            Today
          </v-btn>
          <v-btn
            fab
            text
            small
            color="grey darken-2"
            @click="prev"
          >
            <v-icon small>
              mdi-chevron-left
            </v-icon>
          </v-btn>
          <v-btn
            fab
            text
            small
            color="grey darken-2"
            @click="next"
          >
            <v-icon small>
              mdi-chevron-right
            </v-icon>
          </v-btn>
          <v-toolbar-title v-if="$refs.calendar">
            {{ $refs.calendar.title }}
          </v-toolbar-title>
          <v-spacer></v-spacer>
        
            <template v-slot:activator="{ on, attrs }">
              <v-btn
                outlined
                color="grey darken-2"
                v-bind="attrs"
                v-on="on"
              >
                <span>{{ typeToLabel[type] }}</span>
                <v-icon right>
                  mdi-menu-down
                </v-icon>
              </v-btn>
            </template>
         
        </v-toolbar>
      </v-sheet>
      <!-- Calendario -->
      <v-sheet height="600">
        <v-calendar
          ref="calendar"
          v-model="focus"
          color="primary"
          :events="events"
          :event-color="getEventColor"
          :categories="categories"
          type="category"
          locale="es"
          @click:event="showEvent"
          @click:more="viewDay"
          @click:date="viewDay"
          @change="updateRange"
        ></v-calendar>
        
        <!-- Modal Editar Evento-->
        <v-menu
          v-model="selectedOpen"
          :close-on-content-click="false"
          :activator="selectedElement"
          offset-x
        >
          <v-card
            color="grey lighten-4"
            min-width="350px"
            flat
          >
            <v-toolbar
              :color="selectedEvent.color"
              dark
            >
              <v-btn icon @click="deleteEvent(selectedEvent)">
                <v-icon>mdi-delete</v-icon>
              </v-btn>
              <v-toolbar-title v-html="selectedEvent.id_aula"></v-toolbar-title>
              <v-spacer></v-spacer>
            </v-toolbar>


            <v-card-text>
             
              <v-form v-if="currentlyEditing !== selectedEvent.id">
                {{selectedEvent.name}} - {{selectedEvent.details}}
              </v-form>

              <v-form v-else>

                <v-text-field 
                  type="text" v-model="selectedEvent.id_materia"
                  label="Editar Nombre">
                </v-text-field>

                <textarea-autosize
                  v-model="selectedEvent.id_aula"
                  type="text"
                  style="width: 100%"
                  :min-height="100"
                ></textarea-autosize>

              </v-form>

            </v-card-text>

            
            <v-card-actions>
              <v-btn
                text
                color="secondary"
                @click="selectedOpen = false"
              >
                Cancel
              </v-btn>
              <v-btn text v-if="currentlyEditing !== selectedEvent.id"
              @click.prevent="editEvent(selectedEvent.id)">Editar</v-btn>

              <v-btn text v-else  @click.prevent="updateEvent(selectedEvent)">Guardar Cambios</v-btn>
            </v-card-actions>
          </v-card>
        </v-menu>
             <!-- Modal Agregar Evento Formulario-->
        <v-dialog v-model="dialog">
          <v-card>
            <v-container>
              <v-form @submit.prevent="addEvent">
                <v-select v-model=" nuevaReserva.id_aula" :items=aulas label="Aula a Reservar"
                                  item-value="id" required color="blue" class="mt-4">
                              </v-select>
                <v-text-field 
                  type="text" label="Agregar un Detalle" v-model=" nuevaReserva.observacion">
                </v-text-field>
                <v-text-field 
                  type="date" label="Inicio del evento" v-model="start">
                </v-text-field>
                <v-text-field 
                  type="date" label="Fin del evento" v-model="end">
                </v-text-field>
                <v-btn type="submit" color="primary" class="mr-4" 
                @click.stop="dialog = false">Agregar</v-btn>
              </v-form>
            </v-container>
          </v-card>
        </v-dialog>
      </v-sheet>
    </v-col>
  </v-row>
</v-container>
</template>
<script>
  export default {
    data: () => ({
      activePicker: null,
      date: null,
      dialog: false,
      focus: '',
      horaDesde: '',
          horaHasta: '',
          Reservas: [],
          aulas: [],
      type: 'month',
      typeToLabel: {
        month: 'Month',
        week: 'Week',
        day: 'Day',
        '4day': '4 Days',
      },
      reservaModificada: {
              id_aula: '',
              fh_desde: '',
              fh_hasta: '',
              observacion: '',
          },
          nuevaReserva: {
              id_aula: '',
              fh_desde: '',
              fh_hasta: '',
              observacion: '',
          },aula: [],
          aula_select: '',
          horad_select: '',
          horah_select: '',
          date_select: '',
      selectedEvent: {},
      selectedElement: null,
      selectedOpen: false,
      events: [],
      colors: ['blue', 'indigo', 'deep-purple', 'cyan', 'green', 'orange', 'grey darken-1'],
      names: ['Base de Datos', 'Diseño Grafico', 'Analisis de Sistemas', 'IPOO', 'Web Avanzada', 'Frameword', 'Web Dinamica'],
      categories: ['Aula 1', 'Aula 2', 'Aula 3'],
    }),
    mounted () {
      var that = this
      that.listarReservas()
      that.cargarAulas()
      this.$refs.calendar.checkChange()
    },
    methods: {

      async updateEvent(ev){
          try {
  
            await this.axios.collection('eventos').doc(ev.id).update({
              id_aula: ev.id_aula,
            
            })
  
            this.selectedOpen = false;
            this.currentlyEditing = null;
  
            
          } catch (error) {
            console.log(error);
          }
        },
        editEvent(id){
          this.currentlyEditing = id
        },
        async deleteEvent(ev){
          try {
  
            await this.axios.collection('eventos').doc(ev.id).delete();
            this.selectedOpen = false;
            this.getEvents();
            
          } catch (error) {
            console.log(error);
          }
        },




      save(date) {
          var that = this
          that.$refs.menu.save(date)
          console.log(that.date)
          that.nuevaReserva.fh_desde = that.date
          that.nuevaReserva.fh_hasta = that.date
      },
      listarReservas() {
          var that = this
          this.axios.get("apiv1/reserva")
              .then(function (response) {
                  that.Reservas = response.data;
              })
      },
      crearReserva() {
          var that = this
          that.nuevaReserva.fh_desde += " " + that.horaDesde
          that.nuevaReserva.fh_hasta += " " + that.horaHasta
          console.log(that.nuevaReserva.start)

        this.axios.post("apiv1/reserva", this.nuevaReserva)
              .then(function (response) {
                  console.log(response)
                  that.listarReservas()
                  alert('Reserva creada con exito')
              })
      },
      eliminarReserva(id) {
          var that = this
          this.axios.delete("apiv1/reserva" + id)
              .then(function (response) {
                  console.log(response);
                  that.listarReservas()
                  alert('Reserva eliminada con exito')
              })
      },
      cargarAulas() {
          var that = this
          this.axios.get("apiv1/aula")
              .then(function (response) {
                  for (let i = 0; i < response.data.length; i++) {
                      let aulas = []
                      aulas.id = response.data[i].id;
                      aulas.text = response.data[i].descripcion;
                      that.aulas.push(aulas)
                  }
              })
      },editarReserva(id, reserva) {
          var that = this
          this.axios.put("apiv1/reserva" + id, reserva)
              .then(function () {
                  that.listarReservas()
                  alert('Reserva modificada con exito')
              })
      },
      mostrarReserva(id) {
          var that = this
          this.axios.get("apiv1/reserva" + id)
              .then(function (response) {
              const {
                      id,
                      start,
                      end,
                      aula,
                      observacion,
                  } = response.data;
                  that.reservaModificada.id = id;
                  that.reservaModificada.id_aula = aula.id;
                  that.reservaModificada.start =start;
                  that.reservaModificada.end= end;
                  that.reservaModificada.observacion = observacion
                  that.aula_select = { text: response.data.aula.descripcion, id: response.data.aula.id }
                  console.log(that.reservaModificada)
              })
      },
      capturarIdAula() {
          this.reservaModificada.id_aula = this.aula_select
      },
      separarHorad() {
          var that = this
          const date = that.reservaModificada.start.split(" ")
          that.date_select= date[0];
          that.horad_select=date[1];
          console.log(date)
      },
      separarHorah() {
          var that = this
          const date = that.reserva.end.split(" ")
          that.date_select = date[0];
          that.horah_select = date[1];
           console.log(date)
      },
      viewDay ({ date }) {
        this.focus = date
        this.type = 'day'
      },
      getEventColor (event) {
        return event.color
      },
      setToday () {
        this.focus = ''
      },
      prev () {
        this.$refs.calendar.prev()
      },
      next () {
        this.$refs.calendar.next()
      },
      showEvent ({ nativeEvent, event }) {
        const open = () => {
          this.selectedEvent = event
          this.selectedElement = nativeEvent.target
          requestAnimationFrame(() => requestAnimationFrame(() => this.selectedOpen = true))
        }

        if (this.selectedOpen) {
          this.selectedOpen = false
          requestAnimationFrame(() => requestAnimationFrame(() => open()))
        } else {
          open()
        }

        nativeEvent.stopPropagation()
      },
      updateRange ({ start, end }) {
        const events = []

        const min = new Date(`${start.date}T00:00:00`)
        const max = new Date(`${end.date}T23:59:59`)
        const days = (max.getTime() - min.getTime()) / 86400000
        const eventCount = this.rnd(days, days + 20)

        for (let i = 0; i < eventCount; i++) {
          const allDay = this.rnd(0, 3) === 0
          const firstTimestamp = this.rnd(min.getTime(), max.getTime())
          const first = new Date(firstTimestamp - (firstTimestamp % 900000))
          const secondTimestamp = this.rnd(2, allDay ? 288 : 8) * 900000
          const second = new Date(first.getTime() + secondTimestamp)

          events.push({
            name: this.names[this.rnd(0, this.names.length - 1)],
            start: first,
            end: second,
            color: this.colors[this.rnd(0, this.colors.length - 1)],
            timed: !allDay,
            category: this.categories[this.rnd(0, this.categories.length - 1)],
          })
        }

        this.events = events
      },
      rnd (a, b) {
        return Math.floor((b - a + 1) * Math.random()) + a
      },
    },
  }
</script>