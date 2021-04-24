<template>
	<div>
		<div class="background">
			<Header/>
			<div class="jumbotron jumbotron-fluid">
				<div class="container">
					<h1 class="pb-5">Ο λογαριασμός μου</h1>
				</div>
			</div>
		</div>
		<div class="container py-4">
			<div class="row my-2">
				<div class="col-xl-3 col-12 text-center space">
					<div class="sticky-top pt-4 pb-4">
						<img src="/images/trickst3r.png" class="mx-auto img-fluid rounded-circle" alt="avatar"/>
						<h4 class="my-4">{{ Name + ' ' + Surname }}</h4>
					</div>
				</div>
				<div class="col-xl-9 col-12 personal-info">
					<h4 class="mb-4">Τα στοιχεία μου</h4>
					<FormUserInfo/>
					<hr class="mt-4 mb-4">
					<h4 class="mb-4">Αλλαγή κωδικού</h4>
					<FormUserCreds/>
					<hr class="mt-4 mb-4">
					<h4 class="mb-4">Διαγραφή Λογαριασμού</h4>
					<AccountDelete/>
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
import FormUserInfo from '../components/Profile/FormUserInfo';
import FormUserCreds from '../components/Profile/FormUserCreds';
import AccountDelete from '../components/Profile/AccountDelete';
import NProgress from 'nprogress';

export default {
	name: 'Profile',

	components: {
		Sale,
		Header,
		Footer,
		FormUserInfo,
		FormUserCreds,
		AccountDelete
	},

	computed: {
		Name() {
			return this.$store.state.userInfo.name;
		},

		Surname() {
			return this.$store.state.userInfo.surname;
		},

		Email() {
			return this.$store.state.userInfo.email;
		},

		Mobile(){
			return this.$store.state.userInfo.mobile;
		}
	},

	mounted() {
		NProgress.done();
	},
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