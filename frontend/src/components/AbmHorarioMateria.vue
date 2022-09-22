<template>
    <v-container>
        <h1 style="color: white; text-shadow: 2px 2px 4px black;"> HORARIOS DE MATERIAS </h1> <br>
        
  <v-row class="fill-height">
    <v-col>
      <v-sheet height="64">
        <v-toolbar flat color="white">
          <v-btn color="primary" dark class="mr-4" @click="dialog = true">
            Agregar
          </v-btn>
          <v-btn outlined class="mr-4" @click="setToday">
            Hoy
          </v-btn>
          <v-btn fab text small @click="prev">
            <v-icon small>mdi-chevron-left</v-icon>
          </v-btn>
          <v-btn fab text small @click="next">
            <v-icon small>mdi-chevron-right</v-icon>
          </v-btn>
          <v-toolbar-title>{{ title }}</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-menu bottom right>
            <template v-slot:activator="{ on }">
              <v-btn
                outlined
                v-on="on"
              >
                <span>{{ typeToLabel[type] }}</span>
                <v-icon right>mdi-menu-down</v-icon>
              </v-btn>
            </template>
            <v-list>
              <v-list-item @click="type = 'day'">
                <v-list-item-title>Día</v-list-item-title>
              </v-list-item>
              <v-list-item @click="type = 'week'">
                <v-list-item-title>Semana</v-list-item-title>
              </v-list-item>
              <v-list-item @click="type = 'month'">
                <v-list-item-title>Mes</v-list-item-title>
              </v-list-item>
              <v-list-item @click="type = '4day'">
                <v-list-item-title>4 días</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
        </v-toolbar>
      </v-sheet>
      <v-sheet height="600">
        
        <v-calendar
          ref="calendar"
          v-model="focus"
          color="primary"
          :events="events"
          :event-color="getEventColor"
          :event-margin-bottom="3"
          :now="today"
          :type="type"
          @click:event="showEvent"
          @click:more="viewDay"
          @click:date="viewDay"
          @change="updateRange"
          :weekdays="[1, 2, 3, 4, 5, 6, 0]"
          locale="es"
          :short-weekdays="false"
        ></v-calendar>

        <!-- Modal Agregar Evento -->
        <v-dialog v-model="dialog">
          <v-card>
            <v-container>
              <v-form @submit.prevent="addEvent">
                <v-select v-model="nuevoHorario.id_materia" :items=aulas label="Materia"
                                  item-value="id" required color="blue" class="mt-4">
                  </v-select>
                <v-select v-model="nuevoHorario.id_reserva" :items=aulas label="Reserva"
                                  item-value="id" required color="blue" class="mt-4">
                 </v-select>
                <v-text-field 
                  type="date" label="Inicio del evento" v-model="fh_desde">
                </v-text-field>
                <v-text-field 
                  type="date" label="Fin del evento" v-model="fh_hasta">
                </v-text-field>
                <v-btn type="submit" color="primary" class="mr-4" 
                @click.stop="dialog = false">Agregar</v-btn>
              </v-form>
            </v-container>
          </v-card>
        </v-dialog>

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
              <v-toolbar-title v-html="selectedEvent.id_materia"></v-toolbar-title>
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
                  v-model="selectedEvent.id_reserva"
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
      </v-sheet>
    </v-col>
  </v-row>
    </v-container>
</template>
<script>

    export default {

      data: () => ({
        colors: ['blue', 'indigo', 'deep-purple', 'cyan', 'green', 'orange', 'grey darken-1'],
      names: ['Arquitectura de sistemas', 'Base de Datos', 'Diseño Grafico', 'Analisis de Sistemas', 'IPOO', 'Web Avanzada', 'Frameword', 'Web Dinamica'],
        today: new Date().toISOString().substr(0,10),
        focus: new Date().toISOString().substr(0,10),
        type: 'month',
        typeToLabel: {
          month: 'Mes',
          week: 'Week',
          day: 'Day',
          '4day': '4 Days',
        },
        id_materia: null,
        id_reserva: null,
        fh_desde: null,
        fh_hasta: null,
   
        color: '#1976D2',
        dialog: false,
        currentlyEditing: null,
        selectedEvent: {},
        selectedElement: null,
        selectedOpen: false,
        events: [],
        materias: [],
        nuevoHorario: {
              id_materia: '',
              id_reserva: '',
              fh_desde: '',
              fh_hasta: '',
            
          },
      }),
      computed: {
        title () {
          const { fh_desde, fh_hasta } = this
          if (!fh_desde || !fh_hasta) {
            return ''
          }
  
          const startMonth = this.monthFormatter(fh_desde)
          const endMonth = this.monthFormatter(fh_hasta)
          const suffixMonth = startMonth === endMonth ? '' : endMonth
  
          const startYear = fh_desde.year
          const endYear = fh_hasta.year
          const suffixYear = startYear === endYear ? '' : endYear
  
          const startDay = fh_desde.day + this.nth(fh_desde.day)
          const endDay = fh_hasta.day + this.nth(fh_hasta.day)
  
          switch (this.type) {
            case 'month':
              return `${startMonth} ${startYear}`
            case 'week':
            case '4day':
              return `${startMonth} ${startDay} ${startYear} - ${suffixMonth} ${endDay} ${suffixYear}`
            case 'day':
              return `${startMonth} ${startDay} ${startYear}`
          }
          return ''
        },
        monthFormatter () {
          return this.$refs.calendar.getFormatter({
            timeZone: 'UTC', month: 'long',
          })
        },
      },
      mounted () {
        this.$refs.calendar.checkChange();
      },
      created(){
        this.getEvents();
      },
      methods: {
        async updateEvent(ev){
          try {
  
            await this.axios.collection('eventos').doc(ev.id).update({
              id_materia: ev.id_materia,
              id_reserva: ev.id_reserva
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
        async addEvent(){
          try {
            if(this.id_materia  && this.id_reserva  && this.fh_desde && this.fh_hasta){
  
              await this.axios.collection('eventos').add({
                id_materia: this.id_materia,
                id_reserva: this.id_reserva,
                fh_desde: this.fh_desde,
                fh_hasta: this.fh_hasta,
                color: this.color
              })
  
              this.getEvents();
  
              this.id_materia = null;
              this.id_reserva = null;
              this.fh_desde = null;
              this.fh_hasta = null;
              this.color = '#1976D2';
  
            }else{
              console.log('Campos obligatorios');
            }
          } catch (error) {
            console.log(error);
          }
        },
        async getEvents(){
          try {
  
            const snapshot = await this.axios.collection('eventos').get("apiv1/horario");
            const events = [];
  
            snapshot.forEach(doc => {
              // console.log(doc.id);
              let eventoData = doc.data();
              eventoData.id = doc.id;
              events.push(eventoData);
            })
  
            this.events = events;
            
          } catch (error) {
            console.log(error);
          }
        },
        viewDay ({ date }) {
          this.focus = date
          this.type = 'day'
        },
        getEventColor (event) {
          return event.color
        },
        setToday () {
          this.focus = this.today
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
  