<template>
	<div>
		<Main class="h-100 w-100"/>	
		<Mid/>
		<Tiles/>
		<Sale/>
        <Footer/>
	</div>
</template>

<script>
import Main from '../components/Index/Main';
import Mid from '../components/Index/Mid';
import Tiles from '../components/Index/Tiles';
import Sale from '../components/layout/Sale';
import Footer from '../components/layout/Footer';

export default {
	name: "Index",
	components: {
		Main,
		Mid,
        Tiles,
		Sale,
        Footer
	}
};
</script>

<style>
@media screen and (min-width: 860px) and (max-width: 1200px){
    html, body{
        height: auto !important;
    }
}

@media screen and (min-width: 400px) and (max-width: 850px){
    html, body{
        height: auto !important;
    }

    .col-md*{
        padding: 0 !important;
    }

    .col-sm-*{
        padding: 0 !important;
    }

    .col-xs-*{
        padding: 0 !important;
    }
}

@media only screen and (min-width: 280px) and (max-width: 400px){
    html, body{
        height: auto !important;
    }

    h1{
        font-size: 2.6rem;
    }

    .col-md*{
        padding: 0 !important;
    }

    .col-sm*{
        padding: 0 !important;
    }

    .col-xs*{
        padding: 0 !important;
    }
}

h2, h3{
    font-weight: 300;
}

a {
    color: white;
    text-decoration: none;
}
</style>