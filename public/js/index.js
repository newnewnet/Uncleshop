angular.module('uncleshopApp',['LocalStorageModule'])
.controller('indexController', ['$scope','localStorageService','$rootScope', function($scope,localStorageService,$rootScope) 
{
	$rootScope.pageFlug = false;
	$scope.popupLogoutFlug = false;
	$rootScope.admin = '';

	if(localStorageService.get('admin_id') != null )
	{
		$rootScope.pageFlug = true;
		$rootScope.admin = localStorageService.get('admin_id');
	}

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