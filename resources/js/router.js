
import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)


import Login  from './components/Login.vue'

import Dashboard  from './components/Dashboard.vue'
import Permintaan from './components/Permintaan.vue';
import DataKaryawan from './components/DataKaryawan.vue';
import DataBarang from './components/DataBarang.vue';

let routes =[
    {
    path:'/',
    name :"Login",
    component:Login,
    },{
        path:'/Dashboard',
        name :"Dashboard",
        component:Dashboard,
        children :[{
              path :'/Dashboard',
              name :"Dashboard",
              component:Permintaan
            },
            {
                path :'/Dashboard/data-karyawan/',
                name :"DataKaryawan",
                component:DataKaryawan
              },
              {
                path :'/Dashboard/data-barang',
                name :"DataBarang",
                component:DataBarang
              }]

    }
]


export const router = new VueRouter({
    mode:"history",
    routes
});
