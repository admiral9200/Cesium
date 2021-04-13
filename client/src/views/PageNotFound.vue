<template>
	<div class="d-flex flex-column">
		<div class="background">
			<Header/>
		</div>
		<div class="h-100 d-flex justify-content-center align-items-center">
			<div class="col mx-auto">
				<img src="">
				<h1 class="text-center">Φαίνεσαι λίγο χαμένος, μήπως θες ένα καφέ να ξυπνήσεις??</h1>
				<router-link to="/" class="btn btn-lg mainbtn">Θέλω καφέ!</router-link>
			</div>
		</div>
		<Footer/>
	</div>
</template>

<script>
import Header from '../components/layout/Header';
import Footer from '../components/layout/Footer';

export default {
	components: {
		Header,
		Footer
	}
}
</script>

<style>

</style>