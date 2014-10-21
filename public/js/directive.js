angular.module('directive.format',[])
.directive('format', ['$filter', function ($filter) {
    return {
        require: '?ngModel',
        link: function (scope, elem, attrs, ctrl) {
            if (!ctrl) return;
            ctrl.$parsers.unshift(function (viewValue) {
                var plainNumber = viewValue.replace(/[^\d|\-+|\.+]/g, '');
                elem.val((plainNumber));
                return plainNumber;
            });
        }
    };
}])
.directive('focusMe', function($timeout, $parse) { //focusMe when give variable of focusMe that element will be focus
  return {
    //scope: true,   // optionally create a child scope
    link: function(scope, element, attrs) {
      var model = $parse(attrs.focusMe);
      scope.$watch(model, function(value) {
        if(value === true) { 
          $timeout(function() {
            element[0].focus(); 
          });
        }
      });
    }
  };
})
.directive('ngEnter', function(){ //ngEnter when Enter the element can action
    return function (scope, element, attrs){
        element.bind("keydown", function(event){
            if(event.which === 13) {
                scope.$apply(function(){
                    scope.$eval(attrs.ngEnter);
                });

                event.preventDefault();
            }
        })
    };
});