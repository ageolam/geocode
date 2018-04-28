require('dotenv').config();
const apiKey         = process.env.GEOCODE_API;
var googleMapsClient = require('@google/maps').createClient({
    key: apiKey
});

googleMapsClient.geocode({
    address: 'Bavaria'
}, function(err, response) {
    if (!err) {
        console.log(response.json.results);
        console.log(response.json.results.length);
        var resultsLength = response.json.results.length;

        if (resultsLength === 1) {
            console.log('Equals with one');
            console.log(response.json.results[0].geometry.location);
        } else {

            if (resultsLength > 1) {
                var results = response.json.results;
                results.forEach(function(el) {
                    console.log(el.geometry.location);
                });
            } else {
                console.log('Error');
            }
        }

    }
});