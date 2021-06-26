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
	font-family: "Manrope", sans-serif !important;
	-webkit-font-smoothing: antialiased;
	height: 100%;
}

body.modal-open {
  overflow: hidden;
}

a {
    color: white;
    text-decoration: none !important;
}

a:hover {
	color: #995700 !important;
}

.background h1 {
	color: white;
	padding: 10% 0 0 0;
	text-align: left;
	font-size: 65px;
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

.container {
	max-width: 1200px !important;
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
	font-size: 13px !important;
	color: #dc3545 !important
}

::-moz-selection {
	color: white;
	background: #bb6b00;
}

::selection {
	color: white !important;
	background: #bb6b00 !important;
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
	background-color: #bb6b00 !important;
	border-color: #995700 !important;
}

a:hover{
	color: #bb6b00 !important;
	text-decoration: none !important;
}

.dropdown-item:active {
	color: white !important;
	background: #995700 !important;
}

.mainbtn {
	color: white !important;
	background: #bb6b00 !important;
}

.mainbtn:hover{
	color: white !important;
	background: #995700 !important;
}

.mainbtn:focus{
	outline: none !important;
	box-shadow: 0 0 0 2px #804800 !important;
}

.mainbtn:focus-visible{
	outline: none !important;
}

.form-select:focus {
	border-color: rgb(216, 122, 0) !important;
	outline: none !important;
	box-shadow: 0 0 0 2px #da800ad8 !important;
}

.form-control:focus {
	border-color: rgb(216, 122, 0) !important;
	outline: none !important;
	box-shadow: 0 0 0 2px #da800ad8 !important;
}

input:focus{
	border-color: rgb(216, 122, 0) !important;
	outline: none !important;
	box-shadow: 0 0 0 2px #da800ad8 !important;
}

.logo {
	width: auto;
	height: 76px;
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

.modal-content {
	font-size: 16px;
}

.modal-body {
	max-height: 520px !important;
	overflow-y: scroll;
	overflow-x: hidden;
}
</style>