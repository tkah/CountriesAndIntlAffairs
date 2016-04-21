(function ( angular ) {
    var app = angular.module('appControllers', []);

    app
        /* Main controller for application */
        .controller('TopCtrl', ['$scope', '$log', '$http', '$window', '$document', 'CountryFactory', '$timeout',
            function ($scope, $log, $http, $window, $document, CountryFactory, $timeout) {
                $scope.country = {};
                $scope.gdpOptions = {
                    chart: {
                        type: 'lineChart',
                        height: 450,
                        margin : {
                            top: 20,
                            right: 20,
                            bottom: 50,
                            left: 65
                        },
                        x: function(d){ return d.year; },
                        y: function(d){ return d.amount/1000000; },

                        color: d3.scale.category10().range(),
                        duration: 300,
                        useInteractiveGuideline: true,
                        clipVoronoi: false,

                        xAxis: {
                            axisLabel: 'Years',
                            showMaxMin: false,
                            staggerLabels: true
                        },

                        yAxis: {
                            axisLabel: 'GDP (million)',
                            showMaxMin: false,
                            axisLabelDistance: 0
                        }
                    }
                };

                $scope.immigrantOptions = {
                    chart: {
                        type: 'discreteBarChart',
                        height: 450,
                        margin : {
                            top: 20,
                            right: 20,
                            bottom: 50,
                            left: 55
                        },
                        x: function(d){return d.origCtry;},
                        y: function(d){return d.ttlAmt/1000;},
                        showValues: true,
                        duration: 500,
                        xAxis: {
                            axisLabel: 'Top 10 Immigrant Countries'
                        },
                        yAxis: {
                            axisLabel: 'Immigrants (thousands)',
                            axisLabelDistance: -10
                        }
                    }
                };

                $scope.gdpData = [];
                $scope.immigrantData = [];

                $scope.setCountry = function(country) {
                    $scope.country = country;
                    $scope.gdpData = [
                        {
                            key: $scope.country.name,
                            values: $scope.country.gdp
                        }
                    ];

                    $scope.immigrantData = [
                        {
                            key: $scope.country.name,
                            values: $scope.country.immigrants
                        }
                    ];

                    $scope.toCountryInfo();
                };

                /* Simple function to determine if window size is that of a mobile device */
                $scope.isMobile = function() {
                    return $window.innerWidth < 768;
                };

                $scope.order = function(predicate) {
                    $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                    $scope.predicate = predicate;
                };

                $scope.toCountryInfo = function() {
                    var countryInfo = angular.element(document.getElementById('country-info'));
                    $document.duScrollToElement(countryInfo, 0, 800);
                    $scope.fetching = false;
                };

                $scope.getCountryInfo = function(name) {
                    CountryFactory.getCountryByName(name)
                        .then(function (res) {
                            $scope.setCountry(res.country);
                        });
                };
            }
        ])

        .controller('MapCtrl', ['$scope', 'CountryFactory', 'uiGmapGoogleMapApi',
            function ($scope, CountryFactory, uiGmapGoogleMapApi) {
                /* Where Gmap Centers */
                var lat = 35.983936;
                var long = -36.210938;

                $scope.getMapCenter = function () {
                    CountryFactory.getCountryByCoords($scope.map.center)
                        .then(function (res) {
                            $scope.setCountry(res.country);
                        });
                };

                /* Configure Gmap search box */
                var events = {
                    places_changed: function (searchBox) {
                        var place = searchBox.getPlaces();
                        if (!place || place == 'undefined' || place.length == 0) {
                            console.log('no place data :(');
                            return;
                        }

                        $scope.map = {
                            "center": {
                                "latitude": place[0].geometry.location.lat(),
                                "longitude": place[0].geometry.location.lng()
                            },
                            "zoom": 3,
                            events: {
                                click: function (mapModel, eventName, originalEventArgs) {
                                    $scope.$apply(function () {
                                        var e = originalEventArgs[0];
                                        var coords = {};
                                        coords.latitude = e.latLng.lat();
                                        coords.longitude = e.latLng.lng();
                                        CountryFactory.getCountryByCoords(coords)
                                            .then(function (res) {
                                                $scope.setCountry(res.country);
                                            });
                                    });
                                }
                            }
                        };

                        $scope.marker = {
                            id: 0,
                            coords: {
                                latitude: place[0].geometry.location.lat(),
                                longitude: place[0].geometry.location.lng()
                            }
                        };

                        CountryFactory.getCountryByCoords($scope.marker.coords)
                            .then(function (res) {
                                $scope.setCountry(res.country);
                            });
                    }
                };

                $scope.searchbox = { template:'partials/templates/searchbox.tpl.html', events:events };

                /* Set up google map once the service loads */
                uiGmapGoogleMapApi.then(function(maps) {
                    $scope.map = {
                        center: { latitude: lat, longitude: long },
                        zoom: 3,
                        events: {
                            click: function (mapModel, eventName, originalEventArgs) {
                                $scope.$apply(function () {
                                    var e = originalEventArgs[0];
                                    var coords = {};
                                    coords.latitude = e.latLng.lat();
                                    coords.longitude = e.latLng.lng();
                                    CountryFactory.getCountryByCoords(coords)
                                        .then(function (res) {
                                            $scope.setCountry(res.country);
                                        });
                                });
                            }
                        },
                        options: {mapTypeId: maps.MapTypeId.HYBRID}
                    };
                });
            }
        ])

        .controller('SearchCtrl', ['$scope', '$log',
            function ($scope, $log) {
            }
        ])

        .controller('SearchCountriesCtrl', ['$scope', 'countries',
            function ($scope, countries){
                $scope.countries = countries.countries;
            }
        ])

        .controller('SearchConflictsCtrl', ['$scope', 'conflicts', 'CountryFactory',
            function ($scope, conflicts, CountryFactory) {
                $scope.conflicts = conflicts.conflicts;

                $scope.showConflictParties = function (conflict) {
                    $scope.selectedConflict = conflict;
                    CountryFactory.getConflictParties(conflict.conflictId)
                        .then(function (res) {
                            $scope.countries = res.countries;
                        });

                };
            }
        ])

        .controller('SearchLanguagesCtrl', ['$scope', 'languages', 'CountryFactory',
            function ($scope, languages, CountryFactory){
                $scope.languages = languages.languages;

                $scope.showLanguageCountries = function(cId) {
                    CountryFactory.getLanguageCountries(cId)
                        .then(function (res) {
                            $scope.countries = res.countries;
                        });
                };
            }
        ])

        .controller('SearchTreatiesCtrl', ['$scope', 'treaties', 'CountryFactory',
            function ($scope, treaties, CountryFactory){
                $scope.treaties = treaties.treaties;

                $scope.showTreatyCountries = function(treaty) {
                    $scope.selectedTreaty = treaty;
                    CountryFactory.getTreatyCountries(treaty.treatyNumber)
                        .then(function (res) {
                            $scope.countries = res.countries;
                        });
                };
            }
        ])

        .controller('AdminCtrl', ['$scope', '$log',
            function ($scope, $log) {
            }
        ]);

})( angular );