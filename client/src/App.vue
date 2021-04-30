<template>
	<div class="h-100">
		<notifications group="errors" position="top center" width="400px" class="m-2 user-select-none"/>
		<router-view class="h-100"/>
	</div>
</template>

<script>
export default {
	
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

.vue-notification {
	font-size: 0.9rem !important;
}

html, body {
	font-family: "Manrope", sans-serif;
	-webkit-font-smoothing: antialiased;
	height: 100%;
}

.container {
	max-width: 1200px;
}

.error:focus {
	outline: 1px #dc354665 !important;
	box-shadow: 0 0 0 3px #dc354665 !important;
	border-color: #dc3545 !important;
}

.error{
	border: 1px solid #dc3545 !important;
}

.text-danger {
	font-size: 13px;
	color: #dc3545 !important
}

::-moz-selection {
	color: white;
	background: #bb6b00;
}

::selection {
	color: white;
	background: #bb6b00;
}

.pointer-base {
	cursor: pointer;
}

.custom-control-input:checked~.custom-control-label::before {
  border-color:  #bb6b00 !important;
  background-color: #bb6b00 !important;
}

.form-check-input {
	cursor: pointer;
	width: 1.2rem;
	height: 1.2rem;
}

.form-check-input:checked {
	background-color: #bb6b00;
	border-color: #995700;
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
	height: 80px;
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
</style>