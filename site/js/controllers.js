(function ( angular ) {
    var app = angular.module('appControllers', []);

    app
        /* Main controller for application */
        .controller('TopCtrl', ['$scope', '$log', '$http', '$window', 'CountryFactory', 'uiGmapGoogleMapApi',
            function ($scope, $log, $http, $window, CountryFactory, uiGmapGoogleMapApi) {
                /* Where Gmap Centers */
                var lat = 35.983936;
                var long = -36.210938;

                $scope.country = {};

                /* Simple function to determine if window size is that of a mobile device */
                $scope.isMobile = function() {
                    return  $window.innerWidth < 768;
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
                                        var location = {};
                                        location.coords = {};
                                        location.coords.latitude = e.latLng.lat();
                                        location.coords.longitude = e.latLng.lng();
                                        CountryFactory.getCountry(e.latLng)
                                            .then(function (res) {
                                                console.log(res.country);
                                                $scope.country = res.country;
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

                        CountryFactory.getCountry(place[0].geometry.location)
                            .then(function (res) {
                                console.log(res.country);
                                $scope.country = res.country;
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
                                    var location = {};
                                    location.coords = {};
                                    location.coords.latitude = e.latLng.lat();
                                    location.coords.longitude = e.latLng.lng();
                                    CountryFactory.getCountry(e.latLng)
                                        .then(function (res) {
                                            console.log(res.country);
                                            $scope.country = res.country;
                                        });
                                });
                            }
                        },
                        options: {mapTypeId: maps.MapTypeId.HYBRID}
                    };
                });
            }
        ])

        .controller('AdminCtrl', ['$scope', '$log',
            function ($scope, $log) {
            }
        ]);

})( angular );