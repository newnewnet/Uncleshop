angular.module('uncleshopApp')
.controller('uncleshopController', ['$scope','bill','$rootScope', function($scope,bill,$rootScope) 
{

	$scope.changTab = function(number)
	{
		var text = ['','เพิ่มบิล','ตรวจสอบบิล','ข้อมูลการจ่ายบิล']
		$scope.tabColor=number;
		$rootScope.loginText=text[number];
	};



	// $scope.WarpTab = false;
	// $scope.WarpTabSlide = function(){
	// 	$scope.WarpTab = !$scope.WarpTab;
	// 	if($scope.WarpTab)
	// 	{
	// 		$scope.WarpTab = 'slide';
	// 	}
	// 	else{
	// 		$scope.WarpTab = '';
	// 	}
	// 	console.log($scope.WarpTab);
	// };

	// $scope.WarpTab = 'warp-tab-hide';
	// $scope.WarpTabSlide = function(){
	// 	if($scope.WarpTab == 'warp-tab-hide')
	// 		$scope.WarpTab = 'warp-tab-show';
	// 	else
	// 		$scope.WarpTab = 'warp-tab-hide';
	// 	$scope.$apply();
	// 	console.log($scope.WarpTab);
	// };
	// bill.getBill(function(data, status, headers, config)
	// {
	// 	console.log(data);
	// });
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