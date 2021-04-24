<template>
	<div class="container-fluid m-0 p-0 text-white">
		<div class="row m-0">
			<div class="col-xxl-8 col-lg-8 col-md-8 col-sm-12 col-12 p-0 cc-left">
				<h1 class="text-left ml-xl-5 ml-lg-5 ml-md-4 ml-0 art-left">Discover the blonde flavor at Chip Coffee</h1>
			</div>
			<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 p-0 cc-right h-100 d-flex justify-content-center align-items-center">
				<h1 class="w-50 art-right">Life, Liberty and the pursuit of perfect roast</h1> 
			</div>
		</div>
	</div>
</template>

<script>
export default {
	name: 'Tiles'
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Bangers&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Righteous&display=swap');

.cc-left{
    background-image: url("/images/cofy1.jpg");
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    min-height: 800px;
    border: none;
    border-radius: 30px 0 0 0;
}

.cc-right{
    background-image: url("/images/cup.jpg");
    background-size: cover;
    background-position: bottom;
    background-repeat: no-repeat;
    min-height: 800px;
    border: none;
    border-radius: 0 30px 0 0;
}

.art-left{
    width: 50%;
    font-family: 'Righteous', sans-serif;
    font-size: 6.5rem;
    font-weight: 500;
    position: relative;
    top: 150px;
    left: 150px;
}

.art-right{
    font-family: 'Bangers', cursive;
    font-size: 4.8rem;
    font-weight: 500;
}

@media screen and (min-width: 400px) and (max-width: 850px){
	.cc-left{
        min-height: 350px;
        border-radius: 0;
    }
    .cc-right{
        min-height: 350px;
        border-radius: 0;
    }
    .art-left{
        font-size: 3.2rem;
        width: 70%;
        top: 50px;
        left: 50px;
    }
    .art-right{
        margin-top: 13%;
        margin-bottom: 13%;
    }
}

@media screen and (min-width: 860px) and (max-width: 1200px){
	.art-left{
        width: 70%;
        font-size: 6rem;
        top: 100px;
        left: 100px;
    }
}

@media only screen and (min-width: 280px) and (max-width: 400px){
	.cc-left{
        min-height: 350px;
        border-radius: 0;
    }
    .cc-right{
		min-height: 350px;
        border-radius: 0;
    }
    .art-left{
        width: 60%;
        font-size: 2.5rem;
        top: 50px;
        left: 50px;
    }
    .art-right{
        margin-top: 13%;
        margin-bottom: 13%;
        font-size: 3rem;
    }
}
</style>