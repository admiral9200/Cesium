<template>
	<div class="d-flex flex-column justify-center align-center align-self-stretch flex-grow-1">
        <img src="/images/chip_coffee_page.png" class="logo mb-10" alt="Chip Coffee Logo">
		<Form/>
    </div>
</template>

<script>
import Form from '../components/Index/Form';

export default {
	components: {
		Form
	}
}
</script>

<style scoped>
.logo {
	width: 400px;
}
</style>