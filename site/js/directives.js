(function ( angular ) {

    var app = angular.module('appDirectives', []);

    app
        .directive('district', ['$compile', function ($compile) {
            return {
                scope: {
                    hoverDistrict: "=",
                    selectedDistrict: "=",
                    thisHover: "=",
                    distPres: "=",
                    updateReps: "&"
                },
                link: function (scope, element, attrs) {
                    var tip = angular.element(document.querySelector('#tooltip'));

                    var theId = element.attr("id");
                    var start = theId.indexOf("_") + 1;

                    scope.elementId = theId.substr(start);
                    scope.thisHover = scope.selectedDistrict;

                    if (scope.elementId == 0) {
                        scope.dem = scope.distPres[0].Obama2012;
                        scope.rep = scope.distPres[0].Romney2012;
                    } else {
                        scope.dem = scope.distPres[scope.elementId - 1].Obama2012;
                        scope.rep = scope.distPres[scope.elementId - 1].Romney2012;
                    }

                    console.log(scope.dem + " " + scope.rep);

                    scope.districtClick = function () {
                        scope.selectedDistrict = scope.elementId;
                        scope.updateReps({val: scope.selectedDistrict});
                    };
                    scope.districtMouseEnter = function () {
                        scope.hoverDistrict = scope.elementId;
                        scope.thisHover = scope.elementId;
                        tip.css({
                            display: 'block'
                        });
                    };
                    scope.districtMouseLeave = function () {
                        scope.hoverDistrict = scope.selectedDistrict;
                        scope.thisHover = scope.selectedDistrict;
                        tip.css({
                            display: 'none'
                        });
                    };
                    scope.districtMouseMove = function(event) {
                        var left = event.pageX + 20 + "px";
                        var top = event.pageY + "px";
                        tip.css({
                            left:  left,
                            top:   top
                        });
                    };
                    element.attr("ng-click", "districtClick()");
                    element.attr("ng-mouseenter", "districtMouseEnter()");
                    element.attr("ng-mouseleave", "districtMouseLeave()");
                    element.attr("ng-mousemove", "districtMouseMove($event)");
                    element.attr("ng-class", "{'demo-active':thisHover==elementId&&dem>rep,'demo':thisHover!=elementId&&dem>rep,'repub-active':thisHover==elementId&&rep>dem, 'repub':thisHover!=elementId&&rep>dem}");
                    element.removeAttr("district");
                    $compile(element)(scope);
                }
            }
        }]);

})( angular );