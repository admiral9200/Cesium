<template>
	<div class="h-100">
		<notifications group="errors"/>
		<router-view :userInfo="userInfo" class="h-100"/>
	</div>
</template>

<script>
import VueCookies from 'vue-cookies';

export default {
	data() {
		return {
			user: null,
			userInfo: {}
		}
	},

	watch: {
		
	},

	async created() {
		this.user = VueCookies.get('user');
		let token = VueCookies.get('token');

		if (token !== null && this.user !== null) {
			try {
				let res = await fetch('http://localhost:3000/auth/user/' + this.user, {
					method: 'GET',
					headers: {
						"Authorization" : token,
					}
				});

				if (res.ok) {
					let response = await res.json();
					this.userInfo = response;
				}
			} 
			catch (error) {
				this.$notify({
					group: 'errors',
					title: 'Important message',
					text: 'Hello user! This is a notification!'
				});
			}
		}
		else {
			this.userInfo = {};
			this.user = null;
		}
	},
}
</script>

<style>
@media screen and (min-width: 280px) and (max-width: 400px){
	.background{
		background-position: center !important;
	}
}

@media screen and (min-width: 400px) and (max-width: 850px){
	.background{
		background-position: center !important;
	}
}

html, body {
	font-family: "Manrope", sans-serif;
	-webkit-font-smoothing: antialiased;
	height: 100%;
}

.wrong:focus {
  outline: 1px #dc354665 !important;
  box-shadow: 0 0 0 3px #dc354665 !important;
}

.wrong{
  border: 1px solid #dc3545 !important;
}

.text-danger {
  font-size: 13px;
}

::-moz-selection {
  color: white;
  background: #bb6b00;
}

::selection {
  color: white;
  background: #bb6b00;
}

.custom-control-input:checked~.custom-control-label::before {
  border-color:  #bb6b00 !important;
  background-color: #bb6b00 !important;
}

a:hover{
	color: #bb6b00;
	text-decoration: none;
}

.dropdown-item:active {
	color: white;
	background: #995700;
}

.mainbtn {
	color: white;
	background: #bb6b00;
}

.mainbtn:hover{
	color: white;
	background: #995700;
}

.mainbtn:focus{
	outline: none;
	box-shadow: 0 0 0 2px #804800;
}

input:focus{
	border-color: rgb(216, 122, 0) !important;
	outline: none !important;
	box-shadow: 0 0 0 2px #da800ad8 !important;
}

.logo {
	width: auto;
	height: 100px;
}

.navbar {
  padding-top: 20px;
}

#dropdownMenuLink,
#dropdownMenuLink:hover {
	color: white;
	font-size: 20px;
	text-decoration: none;
}

.jumbotron{
	background-color: transparent;
}

.background {
	background-image: url("/images/main_coffee.jpg");
	background-size: cover;
	background-position: right bottom;
	background-repeat: no-repeat;
}

.site-footer a {
    color: white;
    text-decoration: none;
}

.site-footer a:hover{
	color: #bb6b00 !important;
}

::placeholder {
  color: #b3b3b3;
}

.color {
  cursor: pointer;
  color: white;
}
</style>