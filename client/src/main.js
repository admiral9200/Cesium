import Vue from 'vue';
import store from './store/store';
import router from './router';
import App from '@/App.vue';
import VueCookies from 'vue-cookies';
import Notifications from 'vue-notification';
import Vuelidate from 'vuelidate';

Vue.use(Notifications);
Vue.use(VueCookies);
Vue.use(Vuelidate);

Vue.config.productionTip = false;

const app = new Vue({
	store,
	router,
	render: h => h(App)
});

app.$mount('#app');