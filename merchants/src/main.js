import Vue from 'vue';
import store from '@/store/index';
import vuetify from '@/plugins/vuetify';
import router from './router';
import App from '@/App.vue';
import VueCookies from 'vue-cookies';
import Notifications from 'vue-notification';
import Vuelidate from 'vuelidate';
import VueContentPlaceholders from 'vue-content-placeholders';
import NProgress from 'nprogress';

Vue.use(Notifications);
Vue.use(VueCookies);
Vue.use(Vuelidate);
Vue.use(VueContentPlaceholders);

Vue.config.productionTip = false;

(async () => {
	try {	
		if (VueCookies.get('cc_b_id')) {
			await store.dispatch('fetchUserInfo');
		}
	}
	finally {
		new Vue({
			store,
			router,
            vuetify,
			render: h => h(App)
		}).$mount('#app');
		NProgress.done();
	}
})();
