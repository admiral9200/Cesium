import Vue from 'vue';
import Vuex from 'vuex';
import VueCookies from 'vue-cookies';
import router from '../router';
import NProgress from 'nprogress';

Vue.use(Vuex);

export default new Vuex.Store({
	state: {
		user: {},
		loggedIn: false,
		base_url: window.location.hostname,
		orders: [],
		settings: {
			expandOnHover: false
		}
	},

	mutations: {
		SET_USER_INFO(state, user) {
			state.user = user;
		}
	},

	actions: {
		async fetchUserInfo({ commit }) {
			const token = VueCookies.get('cc_b_id');

			if (token) {
				NProgress.start();

				try {
					const res = await fetch('http://' + this.state.base_url + ':3000/m/user/info', {
						method: 'GET',
						headers: {
							"Authorization" : token,
						}
					});

					const resolve = await res.json();

					if (res.ok) {
						if (resolve.merchant) {
							commit('SET_USER_INFO', resolve.merchant);
							this.state.loggedIn = true;
						}
						else if (resolve.tokenExpired) {
							this.state.loggedIn = false;
	
							Vue.notify({
								group: 'errors',
								type: 'error',
								title: 'Error',
								text: resolve.message
							});

							this.state.user = {
								id: '',
								email: '',
								username: ''
							};

							VueCookies.remove('cc_b_id');

							router.push("/");
						}
						else {
							Vue.notify({
								group: 'errors',
								type: 'error',
								title: 'Error',
								text: resolve.error
							});
						}
					}
				} 
				catch (error) {
					Vue.notify({
						group: 'errors',
						type: 'error',
						title: 'Error',
						text: error
					});
				}
				finally {
					NProgress.inc();
				}
			}
		}
	}
});