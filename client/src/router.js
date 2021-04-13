import Vue from 'vue';
import VueRouter from 'vue-router';
import VueCookies from 'vue-cookies';
import NProgress from 'nprogress';
import Index from '@/views/Index';
import Home from '@/views/Home';
import Order from '@/views/Order';
import Checkout from '@/views/Checkout';
import Reset from '@/views/Reset';
import Profile from '@/views/Profile';
import Signup from '@/views/Signup';
import PageNotFound from '@/views/PageNotFound';

NProgress.configure({ showSpinner: false });

Vue.use(VueRouter);

const routes = [
	{
		path: '/',
		name: 'Index',
		component: Index
	},
	{
		path: '/reset',
		name: 'Reset',
		component: Reset
	},
	{
		path: '/register',
		name: 'Signup',
		component: Signup
	},
	{
		path: '/home',
		name: 'Home',
		component: Home,
		meta: {
			requiresAuth: true
		}
	},
	{
		path: '/order',
		name: 'Order',
		component: Order,
		meta: {
			requiresAuth: true
		}
	},
	{
		path: '/checkout',
		name: 'Checkout',
		component: Checkout,
		meta: {
			requiresAuth: true
		}
	},
	{
		path: '/profile',
		name: 'Profile',
		component: Profile,
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
		if (VueCookies.get('token') == null && VueCookies.get('user') == null) {
			next({ path: '/' });
		} 
		else {
			next();
		}
	} 
	else {
		next();
	}
	NProgress.done();
});

export default router;