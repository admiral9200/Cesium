import Vue from 'vue';
//import store from './store/store';
import VueRouter from 'vue-router';
import VueCookies from 'vue-cookies';
import NProgress from 'nprogress';

//Components
import Index from '../routes/Index';
import Home from '../routes/Home';
import Orders from '../routes/Orders';
import LiveOrders from '../routes/LiveOrders';

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
			if (VueCookies.get('cc_b_id')) {
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
		path: '/liveorders',
		name: 'Live Orders',
		component: LiveOrders,
		props: {
			default: true
		},
		meta: {
			requiresAuth: true
		},
	},
	{
		path: '/orders',
		name: 'Orders',
		component: Orders,
		props: {
			default: true
		},
		meta: {
			requiresAuth: true
		},
	}
];

const router = new VueRouter({
	mode: 'history',
	base: process.env.BASE_URL,
	routes
});

router.beforeEach((to, from, next) => {
	NProgress.start();
	if (to.matched.some(route => route.meta.requiresAuth)) {
		if (!VueCookies.get('cc_b_id')) {
			next({ path: '/' });
		} 
		else {
			next();
		}
	}
	else if (to.matched.some(attr => attr.meta.disallowAuthed)) {
		if (!VueCookies.get('cc_b_id')) {
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

router.afterEach(() => NProgress.done());

export default router;