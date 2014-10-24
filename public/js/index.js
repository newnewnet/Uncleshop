angular.module('uncleshopApp',['LocalStorageModule','directive.format'])
.controller('indexController', ['$scope','localStorageService','$rootScope', function($scope,localStorageService,$rootScope) 
{
	$scope.switchMenu = function(){
		if($scope.menu_slide)
			$scope.menu_slide = !$scope.menu_slide;
		else
			$scope.menu_slide = !$scope.menu_slide;
	};

	$scope.popupLogout = function()
	{
		$scope.popupLogoutFlug = !$scope.popupLogoutFlug ;
	};

	$scope.logout = function()
	{
		$rootScope.pageFlug = false;
		$scope.popupLogoutFlug = false;
		localStorageService.add('admin_id',null);
		$scope.focus('userName_focus');
	};

	$scope.focus = function(value) {
		$rootScope.userName_focus = false;
		$rootScope.customers_id_focus = false;

		switch(value){
			case "userName_focus":
				$rootScope.userName_focus = true;
				break;
			case "customers_id_focus":
				$rootScope.customers_id_focus = true;
				break;
		}
	};

	/*----------------------------------------------------------------*/

	$rootScope.pageFlug = false;
	$rootScope.admin = '';
	$rootScope.loginText = '';
	$scope.menu_slide = false;
	$scope.currencyVal = 0;
	$scope.popupLogoutFlug = false;

	if(localStorageService.get('admin_id') != null ){
		$rootScope.pageFlug = true;
		$rootScope.admin = localStorageService.get('admin_id');
		$scope.focus('customers_id_focus');
	}
	else {
		$scope.focus('userName_focus');
	}

}]);