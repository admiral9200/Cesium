<template>
	<div class="d-flex flex-column">
		<div class="background">
			<Header/>
		</div>
		<div class="h-100 d-grid justify-content-center align-items-center">
			<div class="col mx-auto">
				<h1 class="text-center display-1">404</h1>
				<h2 class="text-center">Φαίνεσαι λίγο χαμένος, μήπως θες ένα καφέ να ξυπνήσεις??</h2>
				<div class="d-flex justify-content-center">
					<router-link to="/" class="btn btn-lg mainbtn">Ναι!</router-link>
				</div>
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