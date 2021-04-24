<template>
	<div class="newsletter">
        <div class="container p-lg-5 p-md-4 p-4">
            <div class="h-100 d-flex justify-content-center align-items-center mb-5">
                <hr class="col-xl-4">
                <h4 class="col-xl-4 text-white text-center">Cofy Newsletter</h4>
                <hr class="col-xl-4">
            </div>
            <div class="d-flex justify-content-center align-items-center col p-4">
                <form v-on:submit.prevent="subscribe" class="row w-100 g-3">
                    <div class="col-5 mx-4">
                        <h6 class="text-white text-left">Κάνε εγγραφή τώρα για να λαμβάνεις νέες προσφορές μέσω email.</h6>
                    </div>
                    <div class="col-4 d-grid">
                        <input v-model="email" type="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="col-2 d-grid">
                        <button type="submit" class="btn mainbtn">Εγγραφή</button>
                    </div>
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
</style>