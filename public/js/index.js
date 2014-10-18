angular.module('uncleshopApp',['LocalStorageModule'])

.controller('indexController', ['$scope','localStorageService','$rootScope', function($scope,localStorageService,$rootScope) 
{
	$rootScope.pageFlug = false;
	$scope.popupLogoutFlug = false;
	$rootScope.admin = '';
	$scope.menu_slide = false;

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