const { pricesSum } = require('../services/sort');
const { Client } = require("@googlemaps/google-maps-services-js");
const { duration_min } = require('../libs/functions');

const client = new Client({});

const distanceMatrixMap = (user, userAddress, stores, storesLocations, res) => {
	client.distancematrix({
		params: {
			origins: [ storesLocations ],
			destinations: [ userAddress ],
			key: process.env.GMAPS_API_KEY,
		}
	})
	.then(async (resDistanceMatrix) => {
		if (resDistanceMatrix.status === 200) {
			if (resDistanceMatrix.data.status === 'OK') {

				let storesDistanceMatrix = [];

				resDistanceMatrix.data.rows.forEach((row, index) => {
					if (row.elements[0].distance.value < 5000) {
						storesDistanceMatrix.push({
							_id: stores[index]._id,
							location: stores[index].location,
							name: stores[index].name,
							logo: stores[index].logo,
							distance: row.elements[0].distance,
							duration: row.elements[0].duration,
							active_orders: stores[index].active_orders,
  							avg_order_preparation: stores[index].avg_order_preparation,
							menu: stores[index].menu
						});
					}
				});

				if (storesDistanceMatrix.length > 0) {
					try {
						let storesAfterCartCheck = await pricesSum(user, storesDistanceMatrix);

						if (storesAfterCartCheck.length > 0) {
							// * storesAfterCartCheck.sort((a, b) => a.duration.value - b.duration.value);

							/* 
							* For each store we have and avg time for order prepare x the quantity of orders at this moment
							* active_ord * avg_min_time_prep * gmaps_duration_time
							* then sort them
							*/

							storesAfterCartCheck.forEach(store => {
								if (store.order_time === undefined) {
									store.order_time = duration_min((store.avg_order_preparation * store.active_orders) + Math.floor(store.duration.value / 60));
								}
							});

							storesAfterCartCheck.sort((a, b) => a.order_time - b.order_time);

							// TODO sort by distance too and calc the closest
							
							res.send({
								'stores': storesAfterCartCheck 
							});
						}
						else {
							res.send({
								'noStoresFound': true,
								'msg': 'Δε βρέθηκαν καταστήματα με τις επιλογές καφέ :('
							});
						}
					} 
					catch (error) {
						console.log(error);
						res.send({ 
							'error': 'An unexpected error occured'
						});
					}
				}
				else {
					res.send({
						'noStoresFound': true,
						'msg': 'Δε βρέθηκαν καταστήματα με την διεύθυνση αυτή :('
					});
				}
			}
		}
	})
	.catch((error) => {
		console.log(error);
		res.send({
			'error': error
		});
	});
};

module.exports = {
	distanceMatrixMap
};