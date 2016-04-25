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
        })

        .filter('dateFilter', function() {
            return function(input)
            {
                var year = parseInt(input.substring(0,4));
                var month = parseInt(input.substring(4,6));
                var day = parseInt(input.substring(6));

                return new Date(year, month, day);

            };
        })

        .filter('percentPopFilter', function() {
            return function(input)
            {

                angular.forEach(items, function(item) {
                    filtered.push(item);
                });
                console.log(input);
                if (!input.percentPop || input.percentPop.indexOf('%') == -1) return input;

                var newInput = {};
                newInput.language = input.language;
                var trimmed = input.percentPop.trim();
                newInput.percentPop = parseInt(percentPop.trim().replace('%', ''));

                return newInput;
            };
        })

        .filter('orderObjectBy', function() {
            return function(items, field, reverse) {
                var filtered = [];
                angular.forEach(items, function(item) {
                    if (item.percentPop && angular.isString(item.percentPop) && item.percentPop.indexOf('%') > -1) {
                        item.percentPop = parseFloat(item.percentPop.trim().replace('%', ''));
                    }
                    filtered.push(item);
                });
                filtered.sort(function (a, b) {
                    return (a[field] > b[field] ? 1 : -1);
                });
                if(reverse) filtered.reverse();
                return filtered;
            };
        });

})( angular );