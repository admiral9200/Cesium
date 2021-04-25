import Vue from 'vue';
import VueRouter from 'vue-router';
import VueCookies from 'vue-cookies';
import NProgress from 'nprogress';
import Index from '@/routes/Index';
import Home from '@/routes/Home';
import Order from '@/routes/Order';
import Checkout from '@/routes/Checkout';
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
		beforeRouteEnter (to, from, next) {
			if (VueCookies.get('token') === null) {
				next();
			} 
			else {
				next({ path: '/home'});
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
	},
	{
		path: '/register',
		name: 'Signup',
		component: Signup,
		meta: {
			disallowAuthed: true
		},
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
		}
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
			next({ path: '/'});
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

router.afterEach((to) => {
	if (to.matched.some(record => !record.meta.requiresAuth)) {
		NProgress.done();
	}
});

export default router;