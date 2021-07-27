import Vue from 'vue';
import store from './store/store';
import VueRouter from 'vue-router';
import VueCookies from 'vue-cookies';
import NProgress from 'nprogress';
//Components
import Index from '@/routes/Index';
import Home from '@/routes/Home';
import Order from '@/routes/Order';
import Checkout from '@/routes/Checkout';
import Stores from '@/routes/Stores';
import Reset from '@/routes/Reset';
import Profile from '@/routes/Profile';
import Signup from '@/routes/Signup';
import PageNotFound from '@/routes/PageNotFound';

NProgress.configure({ showSpinner: false });

Vue.use(VueRouter);

const routes = [
	{
		path: '/',
		name: 'Index',
		component: Index,
		meta: {
			disallowAuthed: true
		},
		beforeEnter (to, from, next) {
			if (VueCookies.get('token')) {
				if (from.path === '/home') {
					next({ 
						path: '/'
					});
				}
				else {
					next({ 
						path: '/home'
					});
				}
			} 
			else {
				next();
			}
		}
	},
	{
		path: '/reset',
		name: 'Reset',
		component: Reset,
		meta: {
			disallowAuthed: true
		},
		beforeEnter (to, from, next) {
			if (VueCookies.get('token') === null) {
				next();
			} 
			else {
				next({ path: '/home'});
			}
		}
	},
	{
		path: '/register',
		name: 'Signup',
		component: Signup,
		meta: {
			disallowAuthed: true
		},
		beforeEnter (to, from, next) {
			if (VueCookies.get('token') === null) {
				next();
			} 
			else {
				next({ path: '/home'});
			}
		}
	},
	{
		path: '/home',
		name: 'Home',
		component: Home,
		props: {
			default: true
		},
		meta: {
			requiresAuth: true
		}
	},
	{
		path: '/order',
		name: 'Order',
		component: Order,
		props: {
			default: true
		},
		meta: {
			requiresAuth: true
		},
		beforeEnter (to, from, next) {
			store.state.userCart.store_id = '';

			if (store.state.userAddresses.length === 0) {
				next({ path: '/home'});
			}
			else {
				next();
			}
		}
	},
	{
		path: '/stores',
		name: 'Stores',
		component: Stores,
		props: {
			default: true
		},
		meta: {
			requiresAuth: true
		},
		beforeEnter (to, from, next) {
			if (store.state.userCart.products.length === 0) {
				next({ path: '/order' });
			}
			else next();
		}
	},
	{
		path: '/checkout',
		name: 'Checkout',
		component: Checkout,
		props: {
			default: true
		},
		meta: {
			requiresAuth: true
		},
		beforeEnter (to, from, next) {
			if (store.state.userCart.products.length === 0) {
				next({ path: '/order' });
			}
			else if (store.state.userCart.store_id === '') {
				next({ path: '/stores' });
			}
			else next();
		},
	},
	{
		path: '/profile',
		name: 'Profile',
		component: Profile,
		props: {
			default: true
		},
		meta: {
			requiresAuth: true
		}
	},
	{
		path: '/:catchAll(.*)*',
		name: "404",
		component: PageNotFound,
	}
];

const router = new VueRouter({
	mode: 'history',
	base: process.env.BASE_URL,
	routes
});

router.beforeEach((to, from, next) => {
	NProgress.start();

	if (to.matched.some(record => record.meta.requiresAuth)) {
		if (!VueCookies.get('token')) {
			next({ path: '/' });
		} 
		else {
			next();
		}
	}
	else if (to.matched.some(attr => attr.meta.disallowAuthed)) {
		if (!VueCookies.get('token')) {
			next();
		} 
		else {
			next({ path: '/home'});
		}
	}
	else {
		next();
	}
});

router.afterEach(() => {
	NProgress.done();
});

export default router;