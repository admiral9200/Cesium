<template>
	<div class="newsletter">
        <div class="container p-lg-5 p-md-4 p-4">
            <div class="h-100 d-flex justify-content-center align-items-center mb-5">
                <hr class="col-xl-4">
                <h4 class="col-xl-4 text-white text-center">Chip Coffee Newsletter</h4>
                <hr class="col-xl-4">
            </div>
            <div class="h-100 d-flex justify-content-center align-items-center row p-4">
                <h6 class="mx-xl-0 mx-lg-0 mx-5 w-25 text-white text-left col-xl-5 col-12">Κάνε εγγραφή τώρα για να λαμβάνεις νέες προσφορές μέσω email.</h6>
                <input type="email" class="subEmail form-control mx-3 mt-xl-0 mt-lg-0 mt-md-0 mt-3 col-xl-4 col-12" id="emailNewsletter" placeholder="Email" required>
                <button type="click" class="subButton btn mainbtn index mt-xl-0 mt-lg-0 mt-md-0 mt-2 col-xl-2 col-12" id="subscribe">Εγγραφή</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
	name: "Newsletter"
}
</script>

<style scoped>
@media screen and (min-width: 280px) and (max-width: 400px) {
	.newsletter hr{
		display: none;
	}
	.newsletter{
		margin: 0 !important;
		border-radius: 0 !important;
	}
}

@media screen and (min-width: 400px) and (max-width: 850px) {
	.newsletter{
        margin: 0 !important;
        border-radius: 0 !important;
    }

    .newsletter hr{
        display: none;
    }
}

@media screen and (min-width: 860px) and (max-width: 1200px) {
	.newsletter hr{
        display: none;
    }
    .newsletter{
        margin: 0 !important;
        border-radius: 0 !important;
    }
}

.newsletter{
	min-height: 350px;
	background-color: #690500;
	padding: 2%;
}

.newsletter hr{
	height: 1px;
	width: 30%;
	background-color: white;
}

.subEmail{
	width: 40% !important;	
}

.subEmail:focus{
	outline: none !important;
	border-color: #bb6b00 !important;
	box-shadow: 0 0 0 2px #bb6b00 !important;
}

.subButton{
	color: white !important;
	background-color: #BB6B00 !important;
}

.subButton:focus{
	background-color: #BB6B00 !important;
}
</style>