<template>
	<v-dialog max-width="550px" click:outside="ClearDialog">
		<template v-slot:activator="{ on, attrs }">
			<v-btn large block color="error" class="my-1 mx-0" v-bind="attrs" v-on="on">
				Cancel<v-icon dark right size="22">mdi-minus-circle</v-icon>
			</v-btn>
		</template>
		<v-form ref="form" @submit.prevent="OrderCancelled(order)" lazy-validation>
			<v-card>
				<v-card-title>
					<span class="text-h5">Reason for cancelling order {{ order.id }}</span>
				</v-card-title>

				<v-card-text>
					<v-col cols="12">
						<v-text-field
							v-model="reason"
							:error-messages="reasonErrors"
							label="Reason"
							@input="$v.reason.$touch()"
							@blur="$v.reason.$touch()"
							required>
						</v-text-field>
					</v-col>
				</v-card-text>

				<v-card-actions>
					<v-spacer></v-spacer>
					<v-btn color="blue darken-1" type="submit">Submit</v-btn>
				</v-card-actions>
			</v-card>
		</v-form>
	</v-dialog>
</template>

<script>
import { required } from 'vuelidate/lib/validators';

export default {
	name: 'OrderCancel',

	data() {
		return {
			reason: this.order.cancelledReason
		}
	},

	props: [
		'order'
	],

	validations: {
		reason: {
			required
		}
	},

	computed: {
		reasonErrors() {
			const errors = [];
			if (!this.$v.reason.$dirty) return errors;
			!this.$v.reason.required && errors.push('A reason is required to cancel order.');
			return errors;
		}
	},

	methods: {
		OrderCancelled: async function (order) {
			this.$v.$touch();

			if (!this.$v.$invalid) {
				order.loaderInCard = true;

				try {
					const response = await fetch('http://' + this.$store.state.base_url + ':3000/m/order/cancel', {
						method: 'POST',
						headers: {
							"Authorization" : this.$cookies.get('cc_b_id'),
							"Content-type" : "application/json; charset=UTF-8"
						},
						body: JSON.stringify({
							'order': order.id,
							'cancel_reason': this.reason
						}),
					});

					if (response.ok) {
						let orderStatus = await response.json();

						if (orderStatus.cancelled) {
							this.$emit('remove_cancelled_order', order.id);

							this.$notify({
								group: 'main',
								type: 'success',
								title: 'Order Status',
								text: 'Order cancelled successfully. Client has been notified'
							});
						}
						else if (orderStatus.error.type === 'NoCancelReason') {
							this.$notify({
								group: 'main',
								type: 'error',
								title: 'Order Status',
								text: orderStatus.error.msg
							});
						}
					}
				} 
				catch (error) {
					this.$notify({
						group: 'main',
						type: 'error',
						title: 'Error',
						text: "There was an error occured"
					});
				}
				finally {
					order.loaderInCard = false;
				}
			}
		},
	},
}
</script>