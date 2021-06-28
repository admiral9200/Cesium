const { Client } = require("@googlemaps/google-maps-services-js");

const client = new Client({});

function distanceMatrixMap (userAddress, stores) {
	stores.forEach(store => {
		client.distancematrix({
			params: {
				origins: [ store.location ],
				destinations: [ userAddress ],
				key: process.env.GMAPS_API_KEY,
			}
		})
		.then((res) => {
			if (res.status === 200) {
				if (res.data.rows[0].elements[0].status === 'OK') {
					store.distance = res.data.rows[0].elements[0].distance;
					store.duration = res.data.rows[0].elements[0].duration;
				}
			}
		})
		.catch((error) => {
			console.log(error);
		});
	});
}

module.exports = {
	distanceMatrixMap
};