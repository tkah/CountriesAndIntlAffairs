(function ( angular ) {
    var app = angular.module('app', [
        'appControllers',
        'appFilters',
        'appDirectives',
        'appFactories',
        'ngMaterial',
        'uiGmapgoogle-maps',
        'picardy.fontawesome',
        'nvd3',
        'duScroll',
        'ui.router'
    ]);

    app.config(['uiGmapGoogleMapApiProvider', '$stateProvider', '$urlRouterProvider', function (uiGmapGoogleMapApiProvider, $stateProvider, $urlRouterProvider) {
        uiGmapGoogleMapApiProvider.configure({
            key: 'AIzaSyD2PfLiCqpDE49yiT-FmAllJ77I-P1TQF0',
            v: '3.22',
            libraries: 'places'
        });

        // For any unmatched url, redirect to /state1
        $urlRouterProvider.otherwise("/map");
        //
        // Now set up the states
        $stateProvider
            .state('map', {
                url: "/map",
                templateUrl: "partials/map.html",
                controller: "MapCtrl"
            })
            .state('search', {
                url: "/search",
                templateUrl: "partials/search.html",
                controller: "SearchCtrl"
            })
            .state('search.conflicts', {
                url: "/conflicts",
                templateUrl: "partials/search.conflicts.html",
                controller: "SearchSubCtrl"
            })
            .state('search.countries', {
                url: "/countries",
                templateUrl: "partials/search.countries.html",
                controller: function($scope, countries){
                    $scope.predicate = '';
                    $scope.countries = countries.countries;
                    $scope.order = function(predicate) {
                        $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
                        $scope.predicate = predicate;
                    };
                },
                resolve: {
                    countries: ['CountryFactory',
                        function(CountryFactory) {
                            return CountryFactory.getAllCountries();
                        }]
                },
            })
            .state('search.languages', {
                url: "/languages",
                templateUrl: "partials/search.languages.html",
                controller: "SearchSubCtrl"
            })
            .state('search.treaties', {
                url: "/treaties",
                templateUrl: "partials/search.treaties.html",
                controller: "SearchSubCtrl"
            });
    }])
})( angular );