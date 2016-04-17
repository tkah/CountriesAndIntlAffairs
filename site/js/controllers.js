(function ( angular ) {
    var app = angular.module('appControllers', []);

    app
        /* Main controller for application */
        .controller('TopCtrl', ['$scope', '$log', '$http', '$window', '$document', 'CountryFactory',
            function ($scope, $log, $http, $window, $document, CountryFactory) {
                $scope.country = {};

                $scope.setCountry = function(country) {
                    $scope.country = country;
                    $scope.toCountryInfo();
                };

                /* Simple function to determine if window size is that of a mobile device */
                $scope.isMobile = function() {
                    return $window.innerWidth < 768;
                };

                $scope.toCountryInfo = function() {
                    var countryInfo = angular.element(document.getElementById('country-info'));
                    $document.duScrollToElement(countryInfo, 0, 800);
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

        .controller('AdminCtrl', ['$scope', '$log',
            function ($scope, $log) {
            }
        ]);

})( angular );