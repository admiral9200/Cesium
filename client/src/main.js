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

const token = VueCookies.get('token');

if (token !== null) {
	fetch('http://localhost:3000/auth/user', {
		method: 'GET',
		headers: {
			"Authorization" : token,
		}
	})
	.then(res => res.json())
	.then(resolve => {
		if (!resolve.error) {
			store.state.userInfo = {
				email: resolve.email,
				name: resolve.name,
				surname: resolve.surname
			};
		}
		else {
			this.$notify({
				group: 'errors',
				type: 'error',
				title: 'Error',
				text: resolve.error
			});
		}
	})
	.catch(error => {
		this.$notify({
			group: 'errors',
			type: 'error',
			title: 'Error',
			text: error
		});
	});
}

new Vue({
	store,
	router,
	render: h => h(App)
}).$mount('#app');