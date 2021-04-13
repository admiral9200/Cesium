<template>
    <div>
        <div class="sale w-100">
            <div class="container mt-5 mx-auto">
                <div class="row w-100">
                    <div class="col-xl-8 col-lg-6 col-md-8 col-12">
                        <h1 class="card-title text-body">Chipαρε τον καφέ σου!</h1>
                        <h5 class="card-text text-body">Με κάθε εγγραφή για πρώτη φορά έχεις 1+1 καφέ δώρο της επιλογής σου.</h5>
                        <p class="text-body">Κατά το τέλος της παραγγελίας σου χρησιμοποιήσε τον κωδικό NEWCHIPCOFFEE για να ενεργοποιήσεις την προσφορά.</p>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-4 col-12 user-select-none">
                        <img src="/images/sale.png" class="sale-image">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
	name: "Sale"	
}
</script>

<style scoped>
@media screen and (min-width: 400px) and (max-width: 850px){
    .sale{
        border-radius: 0 !important;
        height: 470px !important;
    }
}

@media only screen and (min-width: 280px) and (max-width: 400px){
    .sale{
        border-radius: 0 !important;
        height: 430px !important;
    }
}

.card {
    border: none;
    -color: transparent !important;
}

.sale{
    border: none;
    height: 330px;
    background-color: #dda15e;
    overflow: hidden;
}

.sale-image {
    width: 500px;
}
</style>