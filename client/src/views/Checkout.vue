<template>
	<div>
		<div class="background">
			<Header :userInfo="userInfo"/>
			<div class="container py-3">
				<h1>Ολοκλήρωση Παραγγελίας</h1>
			</div>
		</div>
		<div class="container my-5" id="orderCompletion">
			<div id="false"></div>
			<div class="row d-flex justify-content-center">
				<div class="col-xl-4 col-md-12 col-12 box p-xl-5 p-md-5">
					<h4 class="mb-2">1. Στοιχεία Παραγγελίας</h4>
					<div class="row">
						<div class="col-xl-8 col-12" id="input">
							<label for="doorbell">Όνομα στο κουδούνι *</label>
							<input type="text" class="form-control" id="doorname" required>
							<div class="text-danger">Πρέπει να συμπληρώσεις όνομα στο κουδούνι.</div>
						</div>
						<div class="col-md-4" id="input">
							<label for="floor">Όροφος *</label>
							<input type="number" class="form-control" id="floor" required>
							<div class="text-danger">Πρέπει να συμπληρώσεις τον όροφο.</div>
						</div>
					</div>
					<div class="space">
						<label for="address">Προαιρετικό τηλ. επικοινωνίας</label>
						<input type="number" class="form-control" id="phone">
					</div>
					<div class="form-group">
						<label for="exampleFormControlTextarea1">Σχόλια διεύθυνσης</label>
						<textarea class="form-control" id="comment" rows="3" placeholder="Π.χ. Καλέστε στο τηλέφωνο αντί να χτυπήσετε κουδούνι"></textarea>
					</div>
				</div>
				<div class="col-xl-4 col-md-12 col-12 box p-xl-5 p-md-5">
					<h4 class="mb-2">2. Τρόπος Πληρωμής</h4>
					<div class="form-group">
						<div class="d-block mt-4">
							<div class="list-group form-check">
								<input class="form-check-input" type="radio" name="payment" value="paypal" id="paypal" required/>
								<label class="list-group-item form-check-label" for="paypal">PayPal</label>
								<input class="form-check-input" type="radio" name="payment" value="credit" id="card" required/>
								<label class="list-group-item form-check-label" for="card">Πιστωτική/Χρεωστική Κάρτα</label>
								<div class="text-danger" id="payment">
									Πρέπει να διαλέξεις έναν τρόπο πληρωμής.
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-md-12 col-12 box p-xl-5 p-md-5">
					<h4 class="d-flex justify-content-between align-items-center mb-4">3. Ολοκλήρωση</h4>
					<ul class="list-group mb-1" id="FinalCart"></ul>
					<button class="btn mainbtn text-white btn-lg btn-block my-2" type="button" onclick="sendOrder()">Αποστολή Παραγγελίας</button>
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

export default {
	name: 'Checkout',
  props: ['userInfo'],
	components: { 
		Sale,
		Newsletter,
		Header,
		Footer
	}
}
</script>

<style scoped>

.chk {
  width: 150px;
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

@media screen and (min-width: 280px) and (max-width: 400px){
  .container {
    width: 100% !important;
  }
  .box {
    padding: 20px !important;
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

@media screen and (min-width: 400px) and (max-width: 600px){
  .container {
    width: 100% !important;
  }
  .logo {
    height: 70px !important;
    width: auto;
  }
  .box {
    padding: 20px !important;
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

/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}

.box {
  box-shadow: 0 5px 2px 0 rgba(0, 0, 0, 0.24),
    0 17px 50px 0 rgba(0, 0, 0, 0.048) !important;
  border: 0.5px solid rgba(0, 0, 0, 0.24);
  border-radius: 1%;
}

.list-group-item {
  user-select: none;
}

.list-group input[type="checkbox"] {
  display: none;
}

.list-group input[type="checkbox"] + .list-group-item {
  cursor: pointer;
}

.list-group input[type="checkbox"] + .list-group-item:before {
  content: "\2713";
  color: transparent;
  font-weight: bold;
  margin-right: 1em;
}

.list-group input[type="checkbox"]:checked + .list-group-item {
  background-color: #bb6b00;
  color: #fff;
}

.list-group input[type="checkbox"]:checked + .list-group-item:before {
  color: inherit;
}

.list-group input[type="radio"] {
  display: none;
}

.list-group input[type="radio"] + .list-group-item {
  cursor: pointer;
}

.list-group input[type="radio"] + .list-group-item:before {
  content: "\2022";
  color: transparent;
  font-weight: bold;
  margin-right: 1em;
}

.list-group input[type="radio"]:checked + .list-group-item {
  background-color: #bb6b00;
  color: #fff;
}

.list-group input[type="radio"]:checked + .list-group-item:before {
  color: inherit;
}

</style>