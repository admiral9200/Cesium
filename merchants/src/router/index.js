import Vue from 'vue';
import VueRouter from 'vue-router';
import Index from '../routes/Index';
import Home from '../routes/Home';

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

export default router;