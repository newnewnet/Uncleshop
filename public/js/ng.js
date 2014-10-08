angular.module('uncleshopApp', [])
.controller('uncleshopController', ['$scope','bill', function($scope,bill) 
{
	bill.getBill(function(data, status, headers, config)
	{
		console.log(data);
	});
}])
.factory('bill', ['$http', function($http) 
{
	return {
		getBill:function(callback)
		{
			$http({method: 'GET', url: '/cutomers'}).
		  success(callback).
		  error(function(data, status, headers, config) {
		  });
		}
	};
}]);