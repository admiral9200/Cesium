<template>
	<div class="container-fluid">
        <img src="/images/chip_coffee_page.png" class="logo" alt="Chip Coffee Logo">
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
	width: 300px;
}
</style>