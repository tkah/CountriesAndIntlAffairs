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
                    getAllTreaties: function () {
                        var deferred = $q.defer();

                        $http.get("model/get_treaties.php")
                            .then(function (res) {
                                deferred.resolve({
                                    treaties: res.data
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
                    getCountryLeaders: function (cId) {
                        var deferred = $q.defer();
                        var obj = {cId: cId};

                        // Use conflict id to get data from DB
                        $http.post("model/get_country_leaders.php", obj, {})
                            .then(function (res) {
                                deferred.resolve({
                                    leaders: res.data
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
                    },
                    getMigrationRange: function (origCountry, destCountry) {
                        var deferred = $q.defer();
                        var obj = {origCountry: origCountry, destCountry: destCountry};

                        // Use conflict id to get data from DB
                        $http.post("model/get_migration_range.php", obj, {})
                            .then(function (res) {
                                deferred.resolve({
                                    range: res.data
                                });
                            });

                        /* Return a promise which will force the variable to wait until a response is received from the DB */
                        return deferred.promise;
                    },
                    getPlainCountryList: function () {
                        var deferred = $q.defer();

                        // Use conflict id to get data from DB
                        $http.get("model/get_plain_country_list.php")
                            .then(function (res) {
                                deferred.resolve({
                                    countries: res.data
                                });
                            });

                        /* Return a promise which will force the variable to wait until a response is received from the DB */
                        return deferred.promise;
                    },
                    getTreatyCountries: function (num) {
                        var deferred = $q.defer();
                        var obj = {treatyNum: num};

                        // Use conflict id to get data from DB
                        $http.post("model/get_treaty_countries.php", obj, {})
                            .then(function (res) {
                                deferred.resolve({
                                    countries: res.data
                                });
                            });

                        /* Return a promise which will force the variable to wait until a response is received from the DB */
                        return deferred.promise;
                    },
                    insertLeader: function (leader, country) {
                        var deferred = $q.defer();
                        var obj = {leader: leader, country: country};

                        // Use conflict id to get data from DB
                        $http.post("model/insert_country_leader.php", obj, {})
                            .then(function (res) {
                                deferred.resolve({
                                    status: "success"
                                });
                            });

                        return deferred.promise;
                    },
                    updateLeaders: function (leaders) {
                        var obj = {leaders: leaders};

                        // Use conflict id to get data from DB
                        $http.post("model/update_country_leaders.php", obj, {})
                            .then(function (res) {
                                console.log("success");
                            });
                    }
                }
            }
        ]);

})( angular );