<template>
	<div class="my-4">
		<div v-if="stores.length === 0">
			<content-placeholders class="my-5" :rounded="true" v-for="(item, index) in placeholder" :key="index">
				<content-placeholders-heading />
			</content-placeholders>
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

	props: ['stores'],

	data() {
		return {
			placeholder: 10
		}
	},
}
</script>

<style>

</style>