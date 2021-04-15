import Vue from 'vue';
import App from './App.vue';
import router from '@/router.js';
import VueCookies from 'vue-cookies';
import Notifications from 'vue-notification';

Vue.use(Notifications);
Vue.use(VueCookies);

Vue.config.productionTip = false;

const vm = new Vue({
	router,
	render: h => h(App)
});

vm.$mount('#app');