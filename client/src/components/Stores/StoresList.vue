<template>
	<div class="my-4">
		<StoreItem v-bind:key="store.id" v-for="store in stores" :store="store"/>
	</div>
</template>

<script>
import StoreItem from './StoreItem';

export default {
	name: 'StoresList',

	components: {
		StoreItem
	},

	props: ['stores']
}
</script>

<style>

</style>