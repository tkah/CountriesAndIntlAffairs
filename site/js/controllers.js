(function ( angular ) {
    var app = angular.module('appControllers', []);

    app
        /* Main controller for application */
        .controller('TopCtrl', ['$scope', '$log', '$http', '$window', '$document', 'CountryFactory', '$timeout', '$state',
            function ($scope, $log, $http, $window, $document, CountryFactory, $timeout, $state) {
                $scope.country = {};
                $scope.statTabs = [
                    {
                        tabLabel: 'Immigration',
                        chartType: 'discreteBarChart',
                        xLabel: 'Top 10 Immigrant Countries',
                        yLabel: 'Immigrants (thousands)',
                        xFunc: function(d){return d.origCtry;},
                        yFunc: function(d){return d.ttlAmt/1000;}
                    }, {
                        tabLabel: 'Emigration',
                        chartType: 'discreteBarChart',
                        xLabel: 'Top 10 Emigrant Countries',
                        yLabel: 'Emigrants (thousands)',
                        xFunc: function(d){return d.destCtry;},
                        yFunc: function(d){return d.ttlAmt/1000;}
                    }, {
                        tabLabel: 'Population',
                        chartType: 'lineChart',
                        xLabel: 'Years',
                        yLabel: 'Population (thousands)',
                        xFunc: function(d){return d.year},
                        yFunc: function(d){return d.amount/1000}
                    }, {
                        tabLabel: 'CO2',
                        chartType: 'lineChart',
                        xLabel: 'Years',
                        yLabel: 'CO2 Output (metric tons per capita)',
                        xFunc: function(d){return d.year},
                        yFunc: function(d){return d.amount}
                    }, {
                        tabLabel: 'Life Expectancy',
                        chartType: 'lineChart',
                        xLabel: 'Years',
                        yLabel: 'Life Expectancy (years)',
                        xFunc: function(d){return d.year},
                        yFunc: function(d){return d.amount}
                    }];

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
                            showMaxMin: false
                        },

                        yAxis: {
                            axisLabel: 'GDP (million)',
                            showMaxMin: false,
                            axisLabelDistance: 0
                        }
                    }
                };

                $scope.statOptions = {
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
                        discretebar: {
                            dispatch: {
                                elementClick: function (e) {
                                    console.log("click");
                                    if ($scope.country.selectedStat == 0) {
                                        $scope.country.subStatOrigCountry = e.data.origCtry;
                                        $scope.country.subStatDestCountry = $scope.country.name;
                                        $scope.country.subStatYLabel = "Immigration to " + $scope.country.subStatDestCountry + " from " + $scope.country.subStatOrigCountry;
                                    }
                                    else if ($scope.country.selectedStat == 1) {
                                        $scope.country.subStatOrigCountry = $scope.country.name;
                                        $scope.country.subStatDestCountry = e.data.destCtry;
                                        $scope.country.subStatYLabel = "Emigration from " + $scope.country.subStatOrigCountry + " to " + $scope.country.subStatDestCountry;
                                    }

                                    CountryFactory.getMigrationRange($scope.country.subStatOrigCountry, $scope.country.subStatDestCountry)
                                        .then(function (res) {
                                            $scope.country.selectedSubStat = res.range;

                                            $scope.subStatOptions = {
                                                chart: {
                                                    type: 'lineChart',
                                                    height: 450,
                                                    margin : {
                                                        top: 20,
                                                        right: 20,
                                                        bottom: 50,
                                                        left: 65
                                                    },
                                                    x: function(d){ return d.inYear; },
                                                    y: function(d){ return d.totalAmount/1000; },
                                                    color: d3.scale.category10().range(),
                                                    duration: 300,
                                                    useInteractiveGuideline: true,
                                                    clipVoronoi: false,
                                                    xAxis: {
                                                        axisLabel: 'Years',
                                                        showMaxMin: false
                                                    },

                                                    yAxis: {
                                                        axisLabel: $scope.country.subStatYLabel + '(thousand)',
                                                        showMaxMin: false,
                                                        axisLabelDistance: 0
                                                    }
                                                }
                                            };

                                            $scope.subStatData = [{
                                                key: $scope.country.subStatYLabel, values: $scope.country.selectedSubStat
                                            }];
                                        });
                                }
                            }
                        },
                        xAxis: {
                            axisLabel: 'Top 10 Immigrant Countries'
                        },
                        yAxis: {
                            axisLabel: 'Immigrants (thousands)',
                            axisLabelDistance: -5
                        }
                    }
                };

                $scope.gdpData = [];
                $scope.statData = [];

                $scope.getStatData = function(index) {
                    $scope.country.selectedSubStat= null;
                    $scope.statOptions.chart.type = $scope.statTabs[index].chartType;
                    $scope.statOptions.chart.xAxis.axisLabel = $scope.statTabs[index].xLabel;
                    $scope.statOptions.chart.yAxis.axisLabel = $scope.statTabs[index].yLabel;
                    $scope.statOptions.chart.yAxis.axisLabel = $scope.statTabs[index].yLabel;
                    $scope.statOptions.chart.x = $scope.statTabs[index].xFunc;
                    $scope.statOptions.chart.y = $scope.statTabs[index].yFunc;

                    if (index ==0) {
                        $scope.statData = [{
                            key: $scope.country.name, values: $scope.country.immigrants
                        }];
                    } else if (index == 1) {
                        $scope.statData = [{
                            key: $scope.country.name,
                            values: $scope.country.emigrants
                        }];
                    } else if (index == 2) {
                        $scope.statData = [{
                            key: $scope.country.name,
                            values: $scope.country.population
                        }];
                    } else if (index == 3) {
                        $scope.statData = [{
                            key: $scope.country.name,
                            values: $scope.country.co2
                        }];
                    } else if (index == 4) {
                        $scope.statData = [{
                            key: $scope.country.name,
                            values: $scope.country.expectancy
                        }];
                    }
                };

                $scope.setCountry = function(country) {
                    $scope.country = country;
                    $scope.country.selectedStat = 0;
                    $scope.country.selectedSubStat= null;

                    $scope.toCountryInfo();

                    $timeout(function() {
                        $scope.gdpData = [
                            {
                                key: country.name,
                                values: country.gdp
                            }
                        ];

                        $scope.statData = [
                            {
                                key: country.name,
                                values: country.immigrants
                            }
                        ];
                    }, 2000);
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
                    $scope.selectedCountryTreaty = null;
                    $scope.selectedCountryConflict = null;
                    $scope.conflictCountries = null;
                    $scope.treatyCountries = null;

                    CountryFactory.getCountryByName(name)
                        .then(function (res) {
                            $scope.setCountry(res.country);
                        });
                };

                $scope.showCountryConflictParties = function (conflict) {
                    $scope.selectedCountryConflict = conflict;
                    CountryFactory.getConflictParties(conflict.conflictId)
                        .then(function (res) {
                            $scope.conflictCountries = res.countries;
                        });

                };

                $scope.showTreatyCoparties = function(treaty) {
                    $scope.selectedCountryTreaty = treaty;
                    CountryFactory.getTreatyCountries(treaty.treatyNumber)
                        .then(function (res) {
                            $scope.treatyCountries = res.countries;
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

        .controller('AdminCtrl', ['$scope', 'CountryFactory',
            function ($scope, CountryFactory) {
                $scope.admin = {};
                CountryFactory.getPlainCountryList()
                    .then(function (res) {
                        $scope.admin.countries = res.countries;
                    });

                $scope.getCountryLeaders = function(cId) {
                    CountryFactory.getCountryLeaders(cId)
                        .then(function (res) {
                           $scope.admin.updateLeaders = res.leaders;
                        });
                };

                $scope.updateLeaders = function() {
                    CountryFactory.updateLeaders($scope.admin.updateLeaders);
                };

                $scope.insertLeader = function(leader, country) {
                    console.log(country);
                    CountryFactory.insertLeader(leader, country)
                        .then(function (res) {
                            $scope.newLeader = null;
                        });
                };
            }
        ]);

})( angular );