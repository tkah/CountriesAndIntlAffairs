(function ( angular ) {

    var app = angular.module('appFactories', []);

    app
        .factory('CountryFactory', ['$http', '$q',
            function ($http, $q) {
                return {
                    getCountry: function (coords) {
                        var deferred = $q.defer();

                        // First get country name from Google API using lat/long
                        $http.get("https://maps.googleapis.com/maps/api/geocode/json?latlng=" + coords.lat() + "," + coords.lng() + "&key=AIzaSyD2PfLiCqpDE49yiT-FmAllJ77I-P1TQF0")
                            .success(function (res) {
                                var countryIndex = res.results.length - 1;
                                var obj = {name: res.results[countryIndex].formatted_address};

                                console.log(obj);

                                // Use country name to get data from DB
                                $http.post("model/get_country.php", obj, {})
                                    .then(function (res) {
                                        deferred.resolve({
                                            country: res.data[0]
                                        });
                                    });
                            });

                        /* Return a promise which will force the variable to wait until a response is received from the DB */
                        return deferred.promise;
                    }
                }
            }
        ]);

})( angular );