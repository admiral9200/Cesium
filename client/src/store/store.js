import Vue from 'vue';
import Vuex from 'vuex';
import VueCookies from 'vue-cookies';

Vue.use(Vuex);

const store = new Vuex.Store({
	state: {
		token: null,
		userInfo: {
			name: '',
			surname: '',
			email: '',
		},
		userAddresses: null,
		userCart: null
	},
	mutations: {
		UserisLoggedIn(state){
			if (VueCookies.get('token')) {
				state.token = VueCookies.get('token');
			}
		},
		setUser(state, token){
			if (token) {
				try {
					const res = fetch('http://localhost:3000/auth/user', {
						method: 'GET',
						headers: {
							"Authorization" : token,
						}
					});
	
					if (res.ok) {
						const resolve = res.json();
						
						if (!resolve.error) {
							state.userInfo = {
								email: resolve.email,
								name: resolve.name,
								surname: resolve.surname,
								mobile: resolve.mobile
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
			}
		},
	}
});

store.commit('UserisLoggedIn');
store.commit('setUser', store.state.token);

export default store;