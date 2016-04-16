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
            });
    }])
})( angular );