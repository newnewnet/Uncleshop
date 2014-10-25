angular.module('uncleshopApp')
.controller('uncleshopController', ['$scope','bill','$rootScope', function($scope,bill,$rootScope) 
{

	$scope.customers_sex = 'male';

	$scope.changTab = function(number)
	{
		var text = ['','เพิ่มบิล','ค้นหาบิล','ข้อมูลการจ่ายบิล']
		$scope.tabColor=number;
		$rootScope.loginText=text[number];
		console.log($rootScope.loginText);
	};

	/////เวลาส่งทำงี้นะ

	$scope.seachCustomers = function ()
	{
		var data = {
			'key':$scope.search
		}
		bill.getCustomers(data,function(data, status, headers, config)
		{
			console.log(data);
		});
	};

	$scope.savaBill = function()
	{
		var data = {
			'customers_id' : $scope.customers_id,
			'customers_name' : $scope.customers_name,
			'customers_address' : $scope.customers_address,
			'customers_sex' : $scope.customers_sex,
			'customers_tel' :$scope.customers_tel
		};

		bill.saveBill(data,function(data, status, headers, config)
		{

		});
	}

}])
.factory('bill', ['$http', function($http) 
{
	return {
		saveBill:function(data,callback)
		{
			$http({method: 'GET', url: '/saveBill',params:data})
			.success(callback)
			.error(function(data, status, headers, config) {
		  });
		},
		getCustomers:function(data,callback)
		{
			$http({method: 'GET', url: '/customers',params:data})
			.success(callback)
			.error(function(data, status, headers, config) {
		  });
		}
	};
}]);