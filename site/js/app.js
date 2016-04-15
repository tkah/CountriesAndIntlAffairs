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
        'duScroll'
    ]);

    app.config(['uiGmapGoogleMapApiProvider', function (uiGmapGoogleMapApiProvider) {
        uiGmapGoogleMapApiProvider.configure({
            key: 'AIzaSyD2PfLiCqpDE49yiT-FmAllJ77I-P1TQF0',
            v: '3.22',
            libraries: 'places'
        });
    }])
})( angular );