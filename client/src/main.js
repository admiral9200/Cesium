import Vue from 'vue';
import store from './store/store';
import router from './router';
import App from '@/App.vue';
import VueCookies from 'vue-cookies';
import Notifications from 'vue-notification';
import Vuelidate from 'vuelidate';
import VueContentPlaceholders from 'vue-content-placeholders';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import './registerServiceWorker';
import NProgress from 'nprogress';

Vue.use(Notifications);
Vue.use(VueCookies);
Vue.use(Vuelidate);
Vue.use(VueContentPlaceholders);
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);

Vue.config.productionTip = false;

Vue.mixin({
	methods: {
		sessionExpiredHandler: function (message) {
			this.$cookies.remove('token');
			
			this.$store.userOrders = {};
			this.$store.userInfo = {};
			this.$store.userCart = {};
			this.$store.userAddresses = {};
			this.$store.loggedIn = false;

			Vue.notify({
				group: 'main',
				type: 'error',
				title: 'Logged out',
				text: message
			});

			router.push("/");
		}
	}
});

(async () => {
	try {	
		if (VueCookies.get('token')) {
			await store.dispatch('fetchUserInfo');
			await store.dispatch('fetchUserAddresses');
			await store.dispatch('fetchUserCart');
		}
	}
	finally {
		new Vue({
			store,
			router,
			render: h => h(App)
		}).$mount('#app');
		NProgress.done();
	}
})();