(function ( angular ) {

    var app = angular.module('appFactories', []);

    app
        .factory('CountryFactory', ['$http', '$q',
            function ($http, $q) {
                return {
                    getAllConflicts: function () {
                        var deferred = $q.defer();

                        $http.get("model/get_conflicts.php")
                            .then(function (res) {
                                deferred.resolve({
                                    conflicts: res.data
                                });
                            });

                        /* Return a promise which will force the variable to wait until a response is received from the DB */
                        return deferred.promise;
                    },
                    getAllCountries: function () {
                        var deferred = $q.defer();

                        // Use country name to get data from DB
                        $http.get("model/get_allcountry_list.php")
                            .then(function (res) {
                                deferred.resolve({
                                    countries: res.data
                                });
                            });

                        /* Return a promise which will force the variable to wait until a response is received from the DB */
                        return deferred.promise;
                    },
                    getAllLanguages: function () {
                        var deferred = $q.defer();

                        $http.get("model/get_languages.php")
                            .then(function (res) {
                                deferred.resolve({
                                    languages: res.data
                                });
                            });

                        /* Return a promise which will force the variable to wait until a response is received from the DB */
                        return deferred.promise;
                    },
                    getCountryByCoords: function (coords) {
                        var deferred = $q.defer();

                        // First get country name from Google API using lat/long
                        $http.get("https://maps.googleapis.com/maps/api/geocode/json?latlng=" + coords.latitude + "," + coords.longitude + "&key=AIzaSyD2PfLiCqpDE49yiT-FmAllJ77I-P1TQF0")
                            .success(function (res) {
                                var countryIndex = res.results.length - 1;
                                var obj = {name: res.results[countryIndex].formatted_address};


                                // Use country name to get data from DB
                                $http.post("model/get_country.php", obj, {})
                                    .then(function (res) {
                                        deferred.resolve({
                                            country: res.data
                                        });
                                    });
                            });

                        /* Return a promise which will force the variable to wait until a response is received from the DB */
                        return deferred.promise;
                    },
                    getCountryByName: function (name) {
                        var deferred = $q.defer();
                        var obj = {name: name};

                        // Use country name to get data from DB
                        $http.post("model/get_country.php", obj, {})
                            .then(function (res) {
                                deferred.resolve({
                                    country: res.data
                                });
                            });

                        /* Return a promise which will force the variable to wait until a response is received from the DB */
                        return deferred.promise;
                    },
                    getConflictParties: function (cId) {
                        var deferred = $q.defer();
                        var obj = {cId: cId};

                        // Use conflict id to get data from DB
                        $http.post("model/get_conflict_parties.php", obj, {})
                            .then(function (res) {
                                deferred.resolve({
                                    countries: res.data
                                });
                            });

                        /* Return a promise which will force the variable to wait until a response is received from the DB */
                        return deferred.promise;
                    },
                    getLanguageCountries: function (lang) {
                        var deferred = $q.defer();
                        var obj = {language: lang};

                        // Use conflict id to get data from DB
                        $http.post("model/get_language_countries.php", obj, {})
                            .then(function (res) {
                                deferred.resolve({
                                    countries: res.data
                                });
                            });

                        /* Return a promise which will force the variable to wait until a response is received from the DB */
                        return deferred.promise;
                    }
                }
            }
        ]);

})( angular );