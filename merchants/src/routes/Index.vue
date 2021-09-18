<template>
	<div class="d-flex flex-column align-center">
        <img src="/images/chip_coffee_page.png" class="logo mb-10">
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