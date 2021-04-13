<template>
	<div>
		<div class="background">
			<Header/>
			<div class="jumbotron jumbotron-fluid">
				<div class="container">
					<h1>Διάλεξε τον καφέ που θες</h1>
				</div>
			</div>
		</div>
		<div class="container">
			<div id="false"></div>
			<div class="row">
				<div class="col-12 col-xl-9 order-1 order-xl-0 coffees">
					<div id="info"></div>
					<div class="accordion">
						<Menu/>
					</div>
				</div>
				<div class="col-xl-3 col-12 order-0 order-xl-1">
					<Cart/>
				</div>
			</div>
		</div>
		<Sale/>
		<Newsletter/>
		<Footer/>
	</div>
</template>

<script>
import Sale from '../components/layout/Sale';
import Newsletter from '../components/layout/Newsletter';
import Header from '../components/layout/Header';
import Footer from '../components/layout/Footer';
import Menu from '../components/Order/Menu';
import Cart from '../components/Order/Cart';

export default {
	name: 'Order',
	components: { 
		Sale,
		Newsletter,
		Header,
		Menu,
		Cart,
		Footer
	}
}
</script>

<style scoped>
.background h1 {
  color: white;
  padding: 10%;
  padding-left: 0;
  padding-bottom: 0;
  text-align: left;
  font-size: 75px;
  font-weight: 300;
}

.background h2{
	color: white;
	font-weight: 300;
}

.background h3{
  color: white;
  padding: 3%;
  padding-left: 0;
  text-align: left;
  font-size: 20px;
  font-weight: 300;
}

.stop-scrolling {
	height: 100%;
	overflow: hidden;
}

.blurred {
	position: fixed;
	width: 100%;
	height: 100%;
	display: none;
	backdrop-filter: blur(8px);
	background-color: rgba(97, 97, 97, 0.603);
	z-index: 9000;
}

.loader {
	position: fixed;
	top: 50%;
	left: 50%;
	margin-top: -50px;
	margin-left: -50px;
	width: 100px;
	height: 100px;
	display: none;
	z-index: 9999;
}

/* Animation Loaded */
.lds-dual-ring {
	padding-bottom: 5px;
	padding-top: 5px;
}

.lds-dual-ring:after {
	content: " ";
	display: block;
	width: 90px;
	height: 90px;
	margin: 0;
	border-radius: 50%;
	border: 9px solid #fff;
	border-color: #fff transparent #fff transparent;
	animation: lds-dual-ring 1.2s linear infinite;
}

@keyframes lds-dual-ring {
	0% {
		transform: rotate(0deg);
	}

	100% {
		transform: rotate(360deg);
	}
}

@media screen and (min-width: 280px) and (max-width: 400px) {
	.container {
		width: 100% !important;
	}

	.list-group-item {
		padding: 0 !important;
	}

	.form-control-lg {
		font-size: 1rem !important;
	}

	.formobile {
		display: none !important;
	}

	.cart {
		padding: 0 !important;
		margin: 0 !important;
	}

	form {
		padding-right: 0 !important;
	}

	.logo {
		height: 50px !important;
		width: auto;
	}

	.background h1 {
		font-size: 40px !important;
		padding-right: 0 !important;
	}

	.background h3 {
		text-align: center !important;
	}

	.col-md* {
		padding: 0 !important;
	}

	.col-sm-* {
		padding: 0 !important;
	}

	.col-xs-* {
		padding: 0 !important;
	}
}

@media screen and (min-width: 400px) and (max-width: 600px) {
	.container {
		width: 100% !important;
	}
	.logo {
		height: 70px !important;
		width: auto;
	}
	.coffees {
		padding: 0 !important;
	}
	.background h1 {
		font-size: 40px !important;
		padding-right: 0 !important;
	}
	.background h3 {
		text-align: center !important;
	}
	.cart{
		margin-top: 10px !important;
		margin-bottom: 10px !important;
	}
	.accordion{
		margin-top: 20px !important;
		margin-bottom: 20px !important;
	}
	.col-md* {
		padding: 0 !important;
	}

	.col-sm-* {
		padding: 0 !important;
	}

	.col-xs-* {
		padding: 0 !important;
	}
}

.cart {
	padding-top: 20px;
	padding-bottom: 20px;
	margin-top: 40px;
	margin-bottom: 40px;
}

.qty .count {
	display: inline-block;
	vertical-align: top;
	font-size: 25px;
	font-weight: 700;
	line-height: 30px;
	padding: 0 2px;
	min-width: 35px;
	text-align: center;
}

.qty .plus {
	background-color: #202d3c;
	cursor: pointer;
	display: inline-block;
	vertical-align: top;
	color: white;
	width: 30px;
	height: 30px;
	font: 30px/1 Arial, sans-serif;
	text-align: center;
	border-radius: 50%;
	text-decoration: none !important;
}

.qty .minus {
	background-color: #202d3c;
	cursor: pointer;
	display: inline-block;
	vertical-align: top;
	color: white;
	width: 30px;
	height: 30px;
	font: 30px/1 Arial, sans-serif;
	text-align: center;
	border-radius: 50%;
	background-clip: padding-box;
	text-decoration: none !important;
}

.qty input {
	border: 0;
	width: 2%;
}

.qty div {
	text-align: center;
}

.minus:hover {
	background-color: #bb6b00 !important;
	color: white !important;
}

.plus:hover {
	background-color: #bb6b00 !important;
	color: white !important;
}

.count {
	margin-left: 5px !important;
	margin-right: 5px !important;
}
</style>