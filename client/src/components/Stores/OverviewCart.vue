<template>
	<div class="my-3">
		<b-button-group>
			<b-button button variant="none" class="mainbtn" to="/order">
				<b-icon icon="arrow-left"></b-icon>
				Πίσω στο μενού
			</b-button>
			<b-button button variant="none" class="mainbtn" v-b-toggle.CartView>
				<b-icon icon="cart-fill"></b-icon>
				Το καλάθι σου
			</b-button>
		</b-button-group>
		<b-sidebar id="CartView" title="Το καλάθι σου" shadow backdrop lazy>
			
		</b-sidebar>
	</div>
</template>

<script>
export default {
	
}
</script>