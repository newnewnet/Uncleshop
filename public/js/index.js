angular.module('uncleshopApp',['LocalStorageModule','directive.format','ui.bootstrap'])
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
		$rootScope.tabColor=1;
		localStorageService.add('admin',null);
		$scope.focusItem('userName_focus');				
	};

	$scope.focusItem = function(value) {
		$rootScope.userName_focus = false;
		$rootScope.search_focus = false;
		$rootScope.customers_id_focus = false;
		$rootScope.admin_id_focus = false;

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
			case "admin_id_focus":
				$rootScope.admin_id_focus = true;
				break;
			case null:
				break;
		}
	};
	
	
	/*-------------------- When Loading Site Finish----------------------*/

	$rootScope.pageFlug = false;
	$rootScope.admin = '';
	$rootScope.loginText = '';
	$rootScope.search = {
		data: ''
	}
	$rootScope.searchBill = {
		data: ''
	}
	$scope.type_dow = 'month';

	$scope.menu_slide = false;
	$scope.currencyVal = 0;
	$scope.popupLogoutFlug = false;
	
	if(localStorageService.get('admin') != null ){
		$rootScope.pageFlug = true;
		$scope.addProduct_Toggle = true;
		$scope.DataCustomer_toggle = false;
		$rootScope.admin = localStorageService.get('admin');
		$scope.focusItem('search_focus');
	}
	else {
		$scope.focusItem('userName_focus');
	}

}])
