require('./bootstrap');

window.Vue = require('vue').default;

import vuetify from './vuetify';
import VueCookies from 'vue-cookies'

import App  from './components/App.vue'
import { router  }from './router'

Vue.use(VueCookies)

router.beforeEach((to, from, next) => {
    if (to.name !== 'Login' && !$cookies.get("token")) next({ name: 'Login' })
    else next()

 });


new Vue({
    vuetify,
    el: '#app',
    components:{App},
    router,
  });
