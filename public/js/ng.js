angular.module('uncleshopApp')
.controller('uncleshopController', ['$scope','bill','$rootScope', function($scope,bill,$rootScope) 
{

	$scope.sex = 'male';

	$scope.changTab = function(number)
	{
		var text = ['','เพิ่มบิล','ตรวจสอบบิล','ข้อมูลการจ่ายบิล']
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