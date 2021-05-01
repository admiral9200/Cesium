import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const store = new Vuex.Store({
	state: {
		token: null,
		userInfo: {
			name: '',
			email: '',
		},
		userAddresses: null,
		userCart: null
	},
});

export default store;