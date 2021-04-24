<template>
	<div class="newsletter">
        <div class="container p-lg-5 p-md-4 p-4">
            <div class="h-100 d-flex justify-content-center align-items-center mb-5">
                <hr class="col-xl-4">
                <h4 class="col-xl-4 text-white text-center">Cofy Newsletter</h4>
                <hr class="col-xl-4">
            </div>
            <div class="h-100 d-flex justify-content-center align-items-center row p-4">
                <form v-on:submit.prevent="subscribe" class="form-inline w-100">
                    <h6 class="mx-xl-3 mx-lg-3 w-25 text-white text-left col-xl-5 col-12">Κάνε εγγραφή τώρα για να λαμβάνεις νέες προσφορές μέσω email.</h6>
                    <input v-model="email" type="email" class="subEmail form-control mx-xl-3 mx-lg-3 mt-xl-0 mt-lg-0 mt-md-0 mt-3 col-xl-4 col-12" placeholder="Email" required>
                    <button type="submit" class="subButton btn mainbtn index mt-xl-0 mt-lg-0 mt-md-0 mt-2 col-xl-2 col-12">Εγγραφή</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
	name: "Newsletter",

    data() {
        return {
            email: ''
        }
    },

    methods: {
        subscribe: async function () {
            try {
                let response = await fetch('http://localhost:3000/subscribe', {
                    method: 'POST',
					body: JSON.stringify({
						email: this.email
					}),
					headers: {
						"Content-type" : "application/json; charset=UTF-8"
					}
                });

                if (response.ok) {
                    let resolve = await response.json();

                    if (resolve.status) {
                        this.$notify({
                            group: 'errors',
                            type: 'success',
                            title: 'Chip Coffee',
                            text: 'Εγγράφηκες με επιτυχία στο newsletter του Chip Coffee!'
                        });
                    }
                    else if (resolve.error) {
                        this.$notify({
                            group: 'errors',
                            type: 'error',
                            title: 'Error',
                            text: resolve.error
                        });
                    }
                }
            } 
            catch (error) {
                this.$notify({
                    group: 'errors',
                    type: 'error',
                    title: 'Error',
                    text: error
                });
            }
        }  
    },
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