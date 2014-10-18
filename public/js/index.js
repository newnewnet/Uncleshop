angular.module('uncleshopApp',['LocalStorageModule','directive.format'])

.controller('indexController', ['$scope','localStorageService','$rootScope', function($scope,localStorageService,$rootScope) 
{
	$rootScope.pageFlug = false;
	$rootScope.admin = '';

	$rootScope.loginText = 'Uncleshop';
	$scope.menu_slide = false;
	$scope.currencyVal = 0;



	$scope.popupLogoutFlug = false;

	

	if(localStorageService.get('admin_id') != null )
	{
		$rootScope.pageFlug = true;
		$rootScope.admin = localStorageService.get('admin_id');
	}

	$scope.switchMenu = function(){
		if($scope.menu_slide)
			$scope.menu_slide = !$scope.menu_slide;
		else
			$scope.menu_slide = !$scope.menu_slide;
		console.log($rootScope.logo_text);
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
	}
}]);