<template>
	<div class="my-4">
		<div v-if="!isApiStoresResolved && stores.length === 0">
			<content-placeholders class="my-5" :rounded="true" v-for="(item, index) in placeholder" :key="index">
				<content-placeholders-heading :img="true"/>
			</content-placeholders>
		</div>
		<div v-else-if="isApiStoresResolved && noStoresFound">
			<h3 class="text-center msg">{{ msg }}</h3>
		</div>
		<StoreItem v-else v-bind:key="store.id" v-for="store in stores" :store="store"/>
	</div>
</template>

<script>
import StoreItem from './StoreItem';

export default {
	name: 'StoresList',

	components: {
		StoreItem
	},

	props: [
		'stores',
		'isApiStoresResolved',
		'noStoresFound',
		'msg'
	],

	data() {
		return {
			placeholder: 8
		}
	},
}
</script>

<style scoped>
.msg {
	margin: 15rem 0 15rem 0;
}
</style>