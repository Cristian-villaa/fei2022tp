import Vue from 'vue'
import VueRouter from 'vue-router'

import AulasHome from '../components/AulasHome'
import AcercaDe from '@/components/AcercaDe'
import AbmAulas from '@/components/AbmAulas'
import AbmMateria from '@/components/AbmMateria'
import AbmProfesor from '@/components/AbmProfesor'
import AbmHorarioMateria from '@/components/AbmHorarioMateria'
import AbmCarrera from '@/components/AbmCarrera';
import AbmReservaAula from '@/components/AbmReservaAula';

Vue.use(VueRouter)

const routes = [
    {path: '/', name: 'AulasHome', component: AulasHome},
    {path: '/about', name: 'AcercaDe', component: AcercaDe},
    {path: '/AbmAulas', name: 'AbmAulas', component: AbmAulas},
    {path: '/materias', name:'AbmMateria', component: AbmMateria},
    {path: '/profesor', name:'AbmProfesor', component: AbmProfesor},
    {path: '/horario', name:'AbmHorarioMateria', component: AbmHorarioMateria}, 
    {path:'/carrera',   name:'AbmCarrera',component:AbmCarrera},
    {path:'/reserva',   name:'AbmReservaAula',component:AbmReservaAula}

]
const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
})


export default router
