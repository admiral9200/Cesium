import Vue from 'vue';
// import store from './store/store';
import VueRouter from 'vue-router';
import VueCookies from 'vue-cookies';
import NProgress from 'nprogress';

//Components
import Index from '../routes/Index';
import Home from '../routes/Home';

NProgress.configure({ showSpinner: false });

Vue.use(VueRouter);

const routes = [
	{
		path: '/',
		name: 'Index',
		component: Index
	},
	{
		path: '/home',
		name: 'Home',
		component: Home
	}
];

const router = new VueRouter({
	mode: 'history',
	base: process.env.BASE_URL,
	routes
});

router.beforeEach((to, from, next) => {
	NProgress.start();
	window.scrollTo(0, 0);

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