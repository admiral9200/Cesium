<template>
	<div>
		<div class="background">
			<Header/>
			<div class="container py-3">
				<h1>Καλωσήρθες, {{ username }}</h1>
			</div>
		</div>
		<div class="container">
			<div class="row mx-auto my-3 justify-content-center">
				<AddressSelector class="col-xxl-5 col-xl-5 col-md-5 col-12 my-xl-0 mb-3"/>
			</div>
			<h2 class="mb-2 mt-5">Οι διευθύνσεις μου</h2>
			<Addresses/>
			<h2 class="mb-3 mt-5">Οι παραγγελίες μου</h2>
			<div class="row">
				<div class="col-12">
					<ul class="list-group list-group-flush" id="orders">
						<li class="list-group-item mt-4 mb-4 formobile">
							<div class="row">
								<div class="col-xl-3 col-lg-3">
									<h6>Κωδ. Παραγγελίας</h6>
								</div>
								<div class="col-xl-3 col-lg-3">
									<h6>Ημερομηνία</h6>
								</div>
								<div class="col-xl-3 col-lg-3">
									<h6>Περιεχόμενα</h6>
								</div>
								<div class="col-xl-1 col-lg-1">
									<h6>Κόστος</h6>
								</div>
							</div>
						</li>
						<Orders/>
					</ul>
				</div>
			</div>
		</div>
		<Sale/>
		<Footer/>
	</div>
</template>

<script>
import Sale from '../components/layout/Sale';
import Header from '../components/layout/Header';
import Footer from '../components/layout/Footer';
import Addresses from '../components/Home/Addresses';
import AddressSelector from '../components/Home/AddressSelector.vue';
import Orders from '../components/Home/Orders';

export default {
	name: 'Home',

	components: {
		Addresses,
		AddressSelector,
		Orders,
		Sale,
		Header,
		Footer
	},

	computed: {
		username() {
			return this.$store.state.userInfo.name;
		},

		UserHasAddress() {
			return this.$store.state.userAddresses;
		}
	}
}
</script>

<style scoped>
.hr {
	height: 2px;
	margin: 60px 0 30px 0;
	background: rgba(255, 255, 255, 0.2);
}

.disableBtn{
  cursor: not-allowed;
}

.disableOrderAgainBtn:hover{
  color: #bb6b00;
}

.blurred{
  position: fixed;
  width: 100%;
  height: 100%;
  display: none;
  backdrop-filter: blur(8px);
  background-color: rgba(97, 97, 97, 0.603);
  z-index:1100;
}

.loader{
  position: fixed;
  top: 50%;
  left: 50%;
  margin-top: -50px;
  margin-left: -50px;
  width: 100px;
  height: 100px;
  display: none;
  z-index:1200;
}

/* small animation */
.lds-dual-ring-sm {
  padding-bottom: 5px;
  padding-top: 5px;
}
.lds-dual-ring-sm:after {
  content: " ";
  display: block;
  width: 40px;
  height: 40px;
  margin: 0;
  border-radius: 50%;
  border: 6px solid #fff;
  border-color: #fff transparent #fff transparent;
  animation: lds-dual-ring 1.2s linear infinite;
}
@keyframes lds-dual-ring-sm {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

.lds-dual-ring-sm-bl {
  padding-bottom: 5px;
  padding-top: 5px;
}
.lds-dual-ring-sm-bl:after {
  content: " ";
  display: block;
  width: 40px;
  height: 40px;
  margin: 0;
  border-radius: 50%;
  border: 6px solid #000;
  border-color: #000 transparent #000 transparent;
  animation: lds-dual-ring 1.2s linear infinite;
}
@keyframes lds-dual-ring-sm-bl {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

@media screen and (min-width: 280px) and (max-width: 400px){
    .container {
        width: 100% !important;
    }
    form{
      padding: 0;
    }
    .list-group-item{
      padding: 0.75rem 0.2rem !important;
    }
    .form-control-lg{
        font-size: 1rem !important;
    }
    .formobile{
        display: none !important;
    }
    .cost{
        margin-top: 15px;
    }
    .logo {
        height: 50px !important;
        width: auto;
    }
}

@media screen and (min-width: 400px) and (max-width: 850px){
  .container {
    width: 100% !important;
  }
  form{
    padding: 0;
  }
  .formobile{
    display: none !important;
  }
  .logo {
    height: 70px !important;
    width: auto;
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
</style>