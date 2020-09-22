<?php
session_start();
$email = $_SESSION['email'];
require("../php/db_connect.php");
$sqlLoggedInUser = "SELECT * FROM cc_users WHERE email = ?";
$resultUser = $pdo -> prepare($sqlLoggedInUser);
$resultUser -> execute([$email]);
$user = $resultUser -> fetch();
$firstName = $user['firstName'];
$lastName = $user['lastName'];
?>
<div class="background">
	<nav class="navbar navbar-light container">
		<a class="navbar-brand" href="../home/">
			<img src="../images/chip_coffee_page.png" class="logo" alt="Chip Coffee">
		</a>
		<div class="dropdown">
			<a class="dropdown-toggle" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $firstName; ?> <i class="far fa-user"></i></a>
			<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
				<a class="dropdown-item" href="./">Ο λογαριασμός μου</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="../php/logout.php">Αποσύνδεση</a>
			</div>
		</div>
	</nav>
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
				<img src="//api.adorable.io/avatars/120/trickst3r.png" class="mx-auto img-fluid rounded-circle" alt="avatar" />
				<h4 class="my-4"><?php echo $firstName." ".$lastName; ?></h4>
			</div>
		</div>
		<div class="col-xl-9 col-12 personal-info">
			<h4 class="mb-4">Τα στοιχεία μου</h4>
			<?php
			if (isset($_SESSION['msg'])){
				echo $_SESSION['msg'];
				unset($_SESSION['msg']);
			}
			?>
			<div class="form-group row mb-0">
				<div class="col-xl-5 col-12">
					<label class="col-xl-5 col-form-label form-control-label pl-0">Όνομα</label>
					<input class="form-control" type="text" id="firstName" value="<?php echo $firstName; ?>"/>
					<div class="text-danger">Πρέπει να συμπληρώσεις ένα όνομα</div>
				</div>
				<div class="col-xl-5 col-12">
					<label class="col-xl-5 col-form-label form-control-label pl-0">Επώνυμο</label>
					<input class="form-control" type="text" id="lastName" value="<?php echo $lastName; ?>"/>
					<div class="text-danger">Πρέπει να συμπληρώσεις ένα επίθετο</div>
				</div>
			</div>
			<div class="form-group row mt-4 mb-0">
				<label class="col-xl-5 col-form-label form-control-label pl-3">Email</label>
			</div>
			<div class="form-group row">
				<div class="col-xl-5 mb-0">
					<input class="form-control" type="text" value="<?php echo $_SESSION['email']; ?>" disabled/>
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
					<button type="button" id="changeCreds" class="btn btn-primary btn-lg btn-block" value="save">Αποθήκευση Αλλαγών</button>
				</div>
			</div>
			<hr class="mt-4 mb-4">
			<h4 class="mb-4">Αλλαγή κωδικού</h4>
			<?php
			if (isset($_SESSION['msgForPass'])){
				echo $_SESSION['msgForPass'];
				unset($_SESSION['msgForPass']);
			}
			?>
			<div class="form-group row mt-4 mb-0">
				<label class="col-xl-5 col-12 col-form-label form-control-label pl-3">Τρέχων κωδικός</label>
			</div>
			<div class="form-group row">
				<div class="col-xl-5 col-12">
					<input class="form-control" type="password" id="oldpass"/>
					<div class="text-danger">Πρέπει να συμπληρώσεις τον παλιό κωδικό</div>
				</div>
			</div>
			<div class="form-group row mt-4 mb-0">
				<label class="col-xl-5 col-12 col-form-label form-control-label">Νέος κωδικός</label>
			</div>
			<div class="form-group row">
				<div class="col-xl-5 col-12">
					<input class="form-control" type="password" id="newpass"/>
					<div class="text-danger">Πρέπει να συμπληρώσεις έναν καινούριο κωδικό</div>
				</div>
			</div>
			<div class="form-group row mt-4">
				<div class="col-xl-12 col-12">
					<button type="submit" id="changepass" class="btn btn-primary btn-lg btn-block" value="pass">Αποθήκευση Αλλαγών</button>
				</div>
			</div>
		</div>
	</div>
	<script src="profile.js"></script>
</div>