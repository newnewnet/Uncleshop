angular.module('upcleshopApp', [])
.controller('upcleshopController', ['$scope','bill', function($scope,bill) 
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
			$http({method: 'GET', url: '/bill'}).
		  success(callback).
		  error(function(data, status, headers, config) {
		  });
		}
	};
}]);