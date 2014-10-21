angular.module('uncleshopApp')
.controller('uncleshopController', ['$scope','bill','$rootScope', function($scope,bill,$rootScope) 
{

	$scope.customers_sex = 'male';

	$scope.changTab = function(number)
	{
		var text = ['','เพิ่มบิล','ค้นหาบิล','ข้อมูลการจ่ายบิล']
		$scope.tabColor=number;
		$rootScope.loginText=text[number];
	};

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