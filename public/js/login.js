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
				else{
					swal({   
						title: "ไม่ถูกต้อง !",   
						text: "ตรวจสอบ Username และ Passwrod อีกครั้ง",   
						timer: 1500,
						type: 'error'
					});
				}
				$rootScope.admin = data;
				localStorageService.add('admin',data);
				$scope.focusItem('search_focus');
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