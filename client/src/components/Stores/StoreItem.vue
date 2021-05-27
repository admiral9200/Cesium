<template>
	<div class="card my-4">
		<div class="d-flex">
			<div class="card-body flex-grow-0">
				<img :src="store.logo" class="store-img">
			</div>
			<div class="card-body flex-grow-1">
				<h5 class="card-title">{{ store.name }}</h5>
				<p class="card-text">{{ store.location + ' - ' + '15\'' }}</p>
			</div>
			<div class="card-body flex-grow-0 d-flex justify-content-center align-self-center">
				<a class="btn mainbtn">Παράγγειλε από εδώ</a>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	name: 'StoreItem',

	props: ['store'],
}
</script>

<style scoped>
.store-img {
	width: 60px;
}
</style>