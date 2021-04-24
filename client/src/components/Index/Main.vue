<template>
	<div class="overflow-hidden main">
		<div class="row h-100 d-flex flex-row m-0 p-0">
			<div class="bg d-flex col-xxl-7 col-xl-7 col-lg-12 col-md-12 col-sm-12 col-12 p-0 pb-md-5">
				<div class="left">
					<router-link class="logo-responsive" to="/"><img src="/images/chip_coffee_page.png" class="logo" alt="Chip Coffee"></router-link>
					<div class="content d-flex flex-column justify-content-center p-xl-0 p-lg-0 p-md-0 pt-5">
						<h1>Παράγγειλε καφέ σε ένα 1'</h1>
						<h2 class="mt-2">Φθηνά, γρήγορα και ηλεκτρονικά</h2>
					</div>
				</div>
			</div>
			<div class="d-flex justify-content-center align-items-center user-select-none col-xxl-5 col-xl-5 col-lg-12 col-md-12 col-sm-12 col-12 p-xl-5 p-lg-5 p-md-5 p-sm-5 p-0">
				<Form/>
				<div class="overlayLogo">
					<img class="logoStyle" src="/images/chip_coffee.png">
				</div>
			</div>
		</div>	
	</div>
</template>

<script>
import Form from './Form';

export default {
	name: "Main",
	components: {
		Form
	}
}
</script>

<style scoped>
@media screen and (min-width: 400px) and (max-width: 850px) {
	.overlayLogo{
        top: -400px !important;
        right: -300px !important;
    }

	.bg{
        border-radius: 0 !important;
    }

	.bg h1{
        font-size: 40px !important;
    }

    .bg h2{
        font-size: 1.3rem !important;
    }

	.logo-responsive{
        display: grid;
        place-items: center;
    }

	.left{
        padding: 20px 20px 20px 20px !important;
    }

    .right{
        height: auto !important;
    }
}

@media screen and (min-width: 860px) and (max-width: 1200px) {
	.overlayLogo{
        top: -400px !important;
        right: -300px !important;
    }

	.logo-responsive{
        display: grid;
        place-items: center;
    }

	.left{
        padding: 50px 50px 50px 18% !important;
    }

	.bg h1{
        font-size: 4rem !important;
    }

    .bg h3{
        font-size: 1.3rem !important;
    }
	
    .bg{
        border-radius: 0 !important;
    }
}

@media only screen and (min-width: 280px) and (max-width: 400px){
	.logo {
        height: 70px !important;
        width: auto;
    }

	.logo-responsive{
        display: grid;
        place-items: center;
    }

	.login-snip{
        border-radius: 0 !important;
    }

	.left{
        width: auto !important;
        padding: 20px 20px 20px 20px !important;
    }

    .content{
        width: auto !important;
    }

    .right{
        height: auto !important;
        width: auto !important;
    }

	.bg{
        border-radius: 0 !important;
    }

    .bg h1{
        font-size: 2.5rem !important;
    }

    .bg h2{
        font-size: 1.2rem !important;
    }
}

.main{
    min-height: 700px;
}

.content{
    height: 80%;
    width: 90%;
}

.bg {
    background-image: url("/images/main_coffee.jpg");
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    border-radius: 0 30px 30px 0;
    border: none;
}

.bg h1{
    max-width: 800px;
    color: white;
    font-size: 5.5rem;
    font-weight: 300;
}

.bg h2{
    color: white;
    text-align: left;
    font-size: 1.5rem;
    font-weight: 300;
}

.left{
    height: 100%;
    padding: 60px 60px 60px 25%;
}

.overlayLogo{
    z-index: -100;
    position: fixed;
    top: -200px;
    right: -200px;
}

.logoStyle{
    opacity: 0.1;
    transform: rotate(40deg);
    filter: invert(1);
    width: 1100px;
}
</style>