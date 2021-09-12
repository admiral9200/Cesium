import Vue from 'vue';
import Vuex from 'vuex';
import VueCookies from 'vue-cookies';
import router from '../router';
import NProgress from 'nprogress';
import Notifications from 'vue-notification';

Vue.use(Vuex);
Vue.use(Notifications);

export default new Vuex.Store({
	state: {
		user: {
			id: '',
			email: '',
			username: '',
		},
		base_url: window.location.hostname
	},

	mutations: {
		SET_USER_INFO(state, user) {
			state.userInfo = user;
		}
	},

	actions: {
		async fetchUserInfo({ commit }) {
			const token = VueCookies.get('token');

			if (token) {
				NProgress.start();

				try {
					const res = await fetch('http://' + this.state.base_url + ':3000/m/user', {
						method: 'GET',
						headers: {
							"Authorization" : token,
						}
					});

					const resolve = await res.json();

					if (res.ok) {
						if (!resolve.error) {
							commit('SET_USER_INFO', resolve);
						}
						else {
							this.$notify({
								group: 'errors',
								type: 'error',
								title: 'Error',
								text: resolve.error
							});
						}
					}
					else if (resolve.auth === false && res.status === 403) {
						this.state.userInfo.name = null;
						this.state.userInfo.surname = null;
						this.state.userInfo.mobile = null;
						this.state.userInfo.email = null;
						this.state.token = null;
						this.cookies.keys().forEach(cookie => this.$cookies.remove(cookie));
						router.push("/");
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