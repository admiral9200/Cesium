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

Vue.mixin({
	methods: {
		TokenExpiredHelper: async function() {
			const user = store.state.user._id;

			try {	
				const response = await fetch('http://' + store.state.base_url + ':3000/m/auth/logout', {
					method: 'POST',
					body: JSON.stringify({
						user
					}),
					headers: {
						"Content-type" : "application/json; charset=UTF-8"
					}
				});

				if (response.ok) {
					let res = await response.json();

					if (res.auth === false) {
						store.state.user = {};
						VueCookies.remove('cc_b_id');
						store.state.loggedIn = false;
						router.push("/");
					}
				}
			} 
			catch (error) {
				Vue.notify({
					group: 'main',
					type: 'error',
					title: 'Error',
					text: error
				});
			}
		}
	},
});

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
