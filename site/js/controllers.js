(function ( angular ) {
    var app = angular.module('appControllers', []);

    app
        .controller('TopCtrl', ['$scope', '$log', '$http', '$window', 'CountryFactory',
            function ($scope, $log, $http, $window, CountryFactory) {
                var lat = 37.2838;
                var long = -94.6693;

                $scope.country = {};

                $scope.map = {
                    center: { latitude: lat, longitude: long },
                    zoom: 4,
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
                            "zoom": 13,
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

                $scope.isMobile = function() {
                    return  $window.innerWidth < 768;
                };


            }
        ])

        .controller('AdminCtrl', ['$scope', '$log',
            function ($scope, $log) {
            }
        ]);

})( angular );