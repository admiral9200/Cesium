<template>
	<div>
		<div class="background">
			<Header/>
			<div class="jumbotron jumbotron-fluid">
				<div class="container">
					<h1>Ο λογαριασμός μου</h1>
				</div>
			</div>
		</div>
		<div class="container py-4">
			<div class="row my-2">
				<div class="col-xl-3 col-12 text-center space">
					<div class="sticky-top pt-4 pb-4">
						<img src="/images/trickst3r.png" class="mx-auto img-fluid rounded-circle" alt="avatar"/>
						<h4 id="fullName" class="my-4"></h4>
					</div>
				</div>
				<div class="col-xl-9 col-12 personal-info">
					<h4 class="mb-4">Τα στοιχεία μου</h4>
					<div id="info"></div>
					<div class="form-group row mb-0">
						<div class="col-xl-5 col-12">
							<label class="col-xl-5 col-form-label form-control-label pl-0">Όνομα</label>
							<input class="form-control" type="text" id="firstName"/>
							<div class="text-danger">Πρέπει να συμπληρώσεις ένα όνομα</div>
						</div>
						<div class="col-xl-5 col-12">
							<label class="col-xl-5 col-form-label form-control-label pl-0" autocomplete="off">Επώνυμο</label>
							<input class="form-control" type="text" id="lastName"/>
							<div class="text-danger">Πρέπει να συμπληρώσεις ένα επίθετο</div>
						</div>
					</div>
					<div class="form-group row mt-4 mb-0">
						<label class="col-xl-5 col-form-label form-control-label pl-3">Email</label>
					</div>
					<div class="form-group row">
						<div class="col-xl-5 mb-0">
							<input class="form-control" type="text" id="email" value="user's email here" disabled/>
						</div>
					</div>
					<!-- <div class="form-group row mt-4 mb-0">
						<label class="col-5 col-form-label form-control-label pl-3">Κινητό</label>
					</div>
					<div class="form-group row">
						<div class="col-5 mb-0">
							<input class="form-control" type="text" value="phone"/>
						</div>
					</div> -->
					<div class="form-group row">
						<div class="col-12 mt-4 text-left">
							<button type="button" onclick="changeCreds()" class="btn mainbtn text-white btn-lg btn-block" value="save">Αποθήκευση Αλλαγών</button>
						</div>
					</div>
					<hr class="mt-4 mb-4">
					<h4 class="mb-4">Αλλαγή κωδικού</h4>
					<div id="infoPass"></div>
					<div class="form-group row mt-4 mb-0">
						<label class="col-xl-5 col-12 col-form-label form-control-label pl-3">Τρέχων κωδικός</label>
					</div>
					<div class="form-group row">
						<div class="col-xl-5 col-12">
							<input class="form-control" type="password" id="oldpass" />
							<div class="text-danger">Πρέπει να συμπληρώσεις τον παλιό κωδικό</div>
						</div>
					</div>
					<div class="form-group row mt-4 mb-0">
						<label class="col-xl-5 col-12 col-form-label form-control-label">Νέος κωδικός</label>
					</div>
					<div class="form-group row">
						<div class="col-xl-5 col-12">
							<input class="form-control" type="password" id="newpass" />
							<div class="text-danger">Πρέπει να συμπληρώσεις έναν καινούριο κωδικό</div>
						</div>
					</div>
					<div class="form-group row mt-4">
						<div class="col-xl-12 col-12">
							<button type="button" onclick="changePass()" class="btn mainbtn text-white btn-lg btn-block" value="pass">Αποθήκευση Αλλαγών</button>
						</div>
					</div>
					<hr class="mt-4 mb-4">
					<h4 class="mb-4">Διαγραφή Λογαριασμού</h4>
					<div id="error"></div>
					<div class="form-group row mt-4">
						<div class="col-xl-12 col-12">
							<button type="button" class="btn text-white btn-lg btn-block btn-danger" data-toggle="modal" data-target="#exampleModalCenter">Οριστική Διαγραφή Λογαριασμού</button>
						</div>
					</div>
					<!-- form delete -->
					<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLongTitle">Οριστική Διαγραφή Λογαριασμού</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									Η διαγραφή του λογαριασμού σου είναι οριστική και θα διαγραφούν όλα τα δεδομένα σου στο Chip Coffee. Είσαι σίγουρος ότι θες να συνεχίσεις;
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Ακύρωση</button>
									<button type="button" class="btn btn-danger" onclick="deleteAccount()">Συνέχεια</button>
								</div>
							</div>
						</div>
					</div>
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
	name: 'Profile',
	components: {
		Sale,
		Newsletter,
		Header,
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
</style>