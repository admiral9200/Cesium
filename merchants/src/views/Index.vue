<template>
	<div class="container-fluid h-100">
		<Form/>
        <div class="row justify-content-center align-items-center h-100">
            <div class="col col-sm-6 col-md-6 col-lg-4 col-xl-4 text-center">
                <img src="/images/chip_coffee_page.png" class="logo" alt="Chip Coffee Logo">
                <form class="form-group mx-auto pl-3 pr-3">
                    <div class="form-group">
                        <input class="form-control form-control-lg" placeholder="Email" type="email">
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-lg" placeholder="Password" type="password">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-lg btn-block" id="login">Login</button>
                    </div>
                </form>
            </div>
        </div>
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
	width: 500px;
}
</style>