import Vue from 'vue';
import Vuex from 'vuex';
import VueCookies from 'vue-cookies';
import router from '../router';
import NProgress from 'nprogress';

Vue.use(Vuex);

export default new Vuex.Store({
	state: {
		userInfo: {
			id: '',
			email: '',
			name: '',
			surname: '',
			mobile: ''
		},
		userAddresses: [],
		userCart: {
			products: [],
			store_id: ''
		}
	},

	mutations: {
		SET_USER_INFO(state, user) {
			state.userInfo = user;
		},

		SET_USER_ADDRESSES (state, userAddresses) {
			state.userAddresses = userAddresses;
		},

		SET_USER_CART (state, userCart) {
			state.userCart = userCart;
		}
	},

	actions: {
		async fetchUserInfo({ commit }) {
			const token = VueCookies.get('token');

			if (token) {
				NProgress.start();

				try {	
					const res = await fetch('http://localhost:3000/user/info', {
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
						this.$store.state.userInfo.name = null;
						this.$store.state.userInfo.surname = null;
						this.$store.state.userInfo.mobile = null;
						this.$store.state.userInfo.email = null;
						this.$store.state.token = null;
						this.$cookies.keys().forEach(cookie => this.$cookies.remove(cookie));
						router.push("/");
					}
				} 
				catch (error) {	
					this.$notify({
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
		},

		async fetchUserAddresses ({ commit }) {
			const token = VueCookies.get('token');

			if (token) {
				NProgress.start();

				try {	
					const res = await fetch('http://localhost:3000/user/addresses', {
						method: 'GET',
						headers: {
							"Authorization" : token,
						}
					});

					if (res.ok) {
						const resolve = await res.json();

						if (!resolve.error) {
							if (resolve.hasAddress) {
								commit('SET_USER_ADDRESSES', resolve.addresses);
							}
							else {
								commit('SET_USER_ADDRESSES', []);
							}
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
				} 
				catch (error) {	
					this.$notify({
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
		},

		async fetchUserCart ({ commit }) {
			const token = VueCookies.get('token');

			if (token) {
				NProgress.start();

				try {
					const res = await fetch('http://localhost:3000/user/cart', {
						method: 'GET',
						headers: {
							"Authorization" : token,
						}
					});

					if (res.ok) {
						const resolve = await res.json();

						if (resolve.cart) {
							commit('SET_USER_CART', resolve.cart);
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
				} 
				catch (error) {	
					this.$notify({
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
		},
	}
});