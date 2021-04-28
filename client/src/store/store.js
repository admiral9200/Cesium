import Vue from 'vue';
import Vuex from 'vuex';
import VueCookies from 'vue-cookies';

Vue.use(Vuex);

export default new Vuex.Store({
	state: {
		token: VueCookies.get('token') || null,
		userInfo: {
			name: '',
			surname: '',
			email: '',
			mobile: '',
		},
		userAddresses: null,
		userCart: null
	}
});