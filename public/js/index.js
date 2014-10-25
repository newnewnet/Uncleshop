angular.module('uncleshopApp',['LocalStorageModule','directive.format'])
.controller('indexController', ['$scope','localStorageService','$rootScope', function($scope,localStorageService,$rootScope) 
{
	$scope.switchMenu = function(){
		if($scope.menu_slide)
			$scope.menu_slide = !$scope.menu_slide;
		else
			$scope.menu_slide = !$scope.menu_slide;
	};

	$scope.switchDataCustomer = function(){
		if($scope.DataCustomer_toggle){
			$scope.DataCustomer_toggle = !$scope.DataCustomer_toggle;
			$scope.focus('search_focus');
		}
		else{
			$scope.DataCustomer_toggle = !$scope.DataCustomer_toggle;
			$scope.focus('customers_id_focus');
		}
		console.log($scope.DataCustomer_toggle);
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
		$rootScope.search_focus = false;
		$rootScope.customers_id_focus = false;

		switch(value){
			case "userName_focus":
				$rootScope.userName_focus = true;
				break;
			case "search_focus":
				$rootScope.search_focus = true;
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
	$scope.DataCustomer_slide = false;
	$scope.currencyVal = 0;
	$scope.popupLogoutFlug = false;

	if(localStorageService.get('admin_id') != null ){
		$rootScope.pageFlug = true;
		$rootScope.admin = localStorageService.get('admin_id');
		$scope.focus('search_focus');
	}
	else {
		$scope.focus('userName_focus');
	}

}]);