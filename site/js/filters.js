(function ( angular ) {

    var app = angular.module('appFilters', []);

    app

        .filter('toArray', function() {
            return function(input) {
                var out = [];
                for(i in input){
                    out.push(input[i]);
                }
                return out;
            }
        });

})( angular );