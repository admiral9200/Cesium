const { pricesSum } = require('../services/sort');
const { Client } = require("@googlemaps/google-maps-services-js");

const client = new Client({});

const distanceMatrixMap = (user, userAddress, stores, locations, res) => {
	client.distancematrix({
		params: {
			origins: [ locations ],
			destinations: [ userAddress ],
			key: process.env.GMAPS_API_KEY,
		}
	})
	.then(async (resApi) => {
		if (resApi.status === 200) {
			if (resApi.data.status === 'OK') {

				let storesDistanceMatrix = [];

				resApi.data.rows.forEach((row, index) => {
					if (row.elements[0].distance.value < 5000) {
						storesDistanceMatrix.push({
							_id: stores[index]._id,
							location: stores[index].location,
							name: stores[index].name,
							logo: stores[index].logo,
							distance: row.elements[0].distance,
							duration: row.elements[0].duration,
							menu: stores[index].menu
						});
					}
				});

				if (storesDistanceMatrix.length > 0) {
					try {
						let storesAfterCartCheck = await pricesSum(user, storesDistanceMatrix);

						if (storesAfterCartCheck.length > 0) {
							storesAfterCartCheck.sort((a, b) => a.duration.value - b.duration.value);
							// TODO core sort algorithm 
							/* 
							* For each store we have and avg time for order prepare x the quantity of orders at this moment
							*/
		
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