<template>
    <div>
        <h1 style="color: white; text-shadow: 2px 2px 4px black;">Acerca de</h1>
      
     
   <v-card color="blue accent-3"
   
    class="mx-auto"
    max-width="434"
    tile
  >
  <v-card-text  
  class="mt-12">
   
      <v-row
        align="end"
        class="fill-height"
      >
        <v-col
          align-self="start"
          class="pa-0"
          cols="12"
        >
        <v-avatar
          class="profile"
            size="100"
            tile
            left
          >
            <v-img 
            :src="require('../assets/unc.png')"></v-img>
          </v-avatar>
        </v-col>
        
        <v-col class="py-0">
          <v-list-item
            color="rgba(0, 0, 0, .4)"
            dark
          > 
            <v-list-item-content>
              <v-list-item-title class="text-h6" style="color: white; text-shadow: 2px 2px 4px black;">
                Universidad del Comahue
              
              </v-list-item-title>
              <p class="text-justify" style="color: white; text-shadow: 2px 2px 4px black;">
                La Universidad Nacional del Comahue es una universidad pública argentina distribuida entre las provincias de Neuquén y Río Negro con centro en la ciudad de Neuquén y dependencias en Choele Choel, Cinco Saltos, Cipolletti, General Roca, San Antonio Oeste, San Carlos de Bariloche, San Martín de los Andes, Viedma, Villa Regina y Zapala Según el ranking SIR de SCImago,
               la universidad se ubica entre las diez universidades nacionales de Argentina que más producen ciencia y tecnología.
  </p>
            </v-list-item-content>
          </v-list-item>
        </v-col>
      </v-row>
  
  </v-card-text>
  </v-card>
    
  
  
  
   
    </div>
  
</template>


<script>

export default {
    name: 'AcercaDe',



    computed: {
        id(){
            return this.$route.params.id
        }
    }
}

</script>
