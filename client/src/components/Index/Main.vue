<template>
	<div class="overflow-hidden main">
		<div class="row h-100 d-flex flex-row">
			<div class="bg h-100 col-xxl-7 col-xl-7 col-lg-12 col-md-12 col-sm-12 col-12 p-0 pb-md-5">
                <router-link class="logo-responsive d-grid content-main-left py-5 my-3" to="/"><img src="/images/chip_coffee_page.png" class="logo" alt="Chip Coffee"></router-link>
                <div class="d-grid align-content-center flex-wrap content-main-left">
                    <h1 class="display-1">Παράγγειλε καφέ σε ένα 1'</h1>
                    <h3 class="text-white">Φθηνά, γρήγορα και ηλεκτρονικά</h3>
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
    font-weight: 300;
}

.bg h2{
    color: white;
    text-align: left;
    font-weight: 300;
}

.content-main-left {
    min-height: 35%;
    padding-left: 34%;
}

.overlayLogo{
    z-index: -100;
    position: fixed;
    top: -300px;
    right: -300px;
}

.logoStyle{
    opacity: 0.3;
    transform: rotate(40deg);
    filter: invert(1);
    width: 1200px;
}
</style>