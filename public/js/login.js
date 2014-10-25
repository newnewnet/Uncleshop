angular.module('uncleshopApp')
.controller('loginController', ['$scope','login','localStorageService','$rootScope', function($scope,login,localStorageService,$rootScope) 
{

	$scope.login = function()
	{
		if($scope.userName != '' && $scope.passWord != '')
		{
			var data = {
				'username':$scope.userName,
				'password':$scope.passWord
			}
			login.loginAdmin(data,function(data, status, headers, config)
			{
				if(data != '')
				{
					$rootScope.pageFlug = true;
					$rootScope.admin = data;
				}
				localStorageService.add('admin_id',data);
				$scope.focus('search_focus');
				$scope.userName = '';
				$scope.passWord = '';
			});
		}
	};

}])
.factory('login', ['$http', function($http) 
{
	return {
		loginAdmin:function(data,callback)
		{
			$http({method: 'POST', url: '/login',data:data})
		  .success(callback)
		  .error(function(data, status, headers, config) {
		  });
		}
	};
}]);