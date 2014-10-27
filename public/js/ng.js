angular.module('uncleshopApp')
.controller('uncleshopController', ['$scope','bill','$rootScope','manageAdmin','manageCustomer', function($scope,bill,$rootScope,manageAdmin,manageCustomer) 
{
		
	$scope.changTab = function(number)
	{
		var text = ['','เพิ่มบิล','ค้นหาบิล','ข้อมูลการจ่ายบิล']
		$rootScope.tabColor=number;
		$rootScope.loginText=text[number];
	};

	/////เวลาส่งทำงี้นะ

	$scope.seachCustomers = function ()
	{
		var data = {
			'key':$rootScope.search.data
		}
		bill.getCustomers(data,function(data, status, headers, config)
		{
			$rootScope.DataCustomers = data;
		});
	};

	$scope.savaBill = function()
	{
		var data = {
			'customers_id' : $scope.customersId,
			'customers_name' : $scope.customersName,
			'customers_tel' : $scope.customersLastName,
			'customers_address' : $scope.customersAddress,
			'customers_sex' : $scope.customersSex,
			'customers_tel' :$scope.customersTel									
		};

		bill.saveBill(data,function(data, status, headers, config)
		{

		});
	};

	/*----------------------------  bill  ---------------------------------*/
	$scope.nextBill = function() {

	};

	/*---------------------------- bill-->customer  ---------------------------------*/
	$scope.switchDataCustomer = function(){
		$scope.customersDefault();
		if($scope.DataCustomer_toggle){
			$scope.DataCustomer_toggle = !$scope.DataCustomer_toggle;
			$scope.focus('search_focus');
		}
		else{
			$scope.DataCustomer_toggle = !$scope.DataCustomer_toggle;
			$scope.focus('customers_id_focus');
		}
		$rootScope.DataCustomers = null;
		$rootScope.search.data = null;
	};

	$scope.customersDefault = function()
	{
		
		$scope.customersId = null;
		$scope.customersName = null;
		$scope.customersLastName = null;
		$scope.customersTel = null;
		$scope.customersSex = 'male';
		$scope.customersAddress = null;

	};

	/*----------------------------  super  admin---------------------------------*/
	$scope.adminDefault = function()
	{
		$scope.adminLastName = '';
		$scope.adminSex = 'male';
		$scope.adminTel = '';
		$scope.adminName = '';
		$scope.adminAddress = '';
		$scope.adminLastName = '';
		$scope.userError = '';
		$scope.adminId = '';
		$scope.adminUser = '';
		$scope.adminPassword = '';
		$scope.adminError = [];
		$scope.adminIdDisabled = false;
	};

	$scope.switchDataAdmin = function()
	{
		$scope.adminDefault();
		if($scope.adminToggle){
			$scope.adminToggle = !$scope.adminToggle;
			$scope.editFlug = false;
		}
		else{
			$scope.adminToggle = !$scope.adminToggle;
			$scope.focus('admin_id_focus');
			$scope.editFlug = true;
		}
	};

	$scope.getAdmin = function ()
	{
		manageAdmin.getAdmin(function(data, status, headers, config)
		{
			$scope.admins = data;
		});
	};

	$scope.register = function(value)
	{
		
		if($scope.adminId != '' && $scope.adminUser != '' && $scope.adminPassword !='' || $scope.adminError[1] == '')
		{
			data = {
				'admin_id' : $scope.adminId,
				'admin_name' :  $scope.adminName,
				'admin_last_name' : $scope.adminLastName,
				'admin_user' :  $scope.adminUser,
				'admin_password' : $scope.adminPassword,
				'admin_sex' : $scope.adminSex,
				'admin_tel' : $scope.adminTel,
				'admin_address' :  $scope.adminAddress
			};

			if(value == 1)
			{
				manageAdmin.saveAdmin(data,function(data, status, headers, config)
				{
					console.log('saveAdmin');
					console.log(data);

					if(data != 'error'){
						$scope.getAdmin();
						$scope.adminToggle = false;
					}

				});
			}

			else if(value == 2)
			{
				manageAdmin.updateAdmin(data,function(data, status, headers, config)
				{
					$scope.getAdmin();
					$scope.adminToggle = false;
				});
			}

		}
		else
		{
			if($scope.adminId == '')
				$scope.adminError[0] = 'input-error'; //input adminID
			if($scope.adminUser == '')
				$scope.adminError[1] = 'input-error'; //input adminUserName
			if($scope.adminPassword == '')
				$scope.adminError[2] = 'input-error'; //input adminPassword
		}
	};

	$scope.checkAdmin = function(value)
	{
		if(value == 1)
		{
			if($scope.adminId != '')
				$scope.adminError[0] = '';
		}
		else if(value == 2)
		{
			setTimeout(function()
			{
				var data = {
					'username' : $scope.adminUser
				};
				manageAdmin.checkUserName(data,function(data, status, headers, config)
				{
					console.log(data);
					$scope.adminError[1] = '';
					if(data != 0 )
					{
						$scope.adminError[1] = 'input-error';
					}
				});
			}, 500);
		}
		else if(value ==3)
		{
			if($scope.adminPassword != '')
				$scope.adminError[2] = '';
		}

	};

	$scope.editAdmin = function(index)
	{
		$scope.adminToggle = true;
		$scope.editFlug = false;
		$scope.adminIdDisabled = true;
		$scope.adminId = $scope.admins[index].admin_id;
		$scope.adminName =  $scope.admins[index].admin_name;
		$scope.adminLastName =  $scope.admins[index].admin_last_name;
		$scope.adminUser =  $scope.admins[index].admin_user;
		$scope.adminPassword =  $scope.admins[index].admin_password;
		$scope.adminSex = $scope.admins[index].admin_sex;
		$scope.adminTel =  $scope.admins[index].admin_tel;
		$scope.adminAddress =  $scope.admins[index].admin_address;
	};

	$scope.deleteAdmin = function()
	{
		var data = {
			'admin_id' : $scope.adminId
		};
		manageAdmin.deleteAdmin(data,function(data, status, headers, config)
		{
			$scope.getAdmin();
			$scope.adminToggle = false;
		});
	};
	
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
}])

.factory('manageAdmin', ['$http', function($http) 
{
	return {
		saveAdmin:function(data,callback)
		{
			$http({method: 'GET', url: '/saveAdmin',params:data})
		  .success(callback)
		  .error(function(data, status, headers, config) {
		  });
		},
		checkUserName:function(data,callback)
		{
			$http({method: 'GET', url: '/checkUser',params:data})
		  .success(callback)
		  .error(function(data, status, headers, config) {
		  });
		},
		getAdmin:function(callback)
		{
			$http({method: 'GET', url: '/admin'})
		  .success(callback)
		  .error(function(data, status, headers, config) {
		  });
		},
		deleteAdmin:function(data,callback)
		{
			$http({method: 'GET', url: '/deleteAdmin',params:data})
		  .success(callback)
		  .error(function(data, status, headers, config) {
		  });
		},
		updateAdmin:function(data,callback)
		{
			$http({method: 'GET', url: '/updateAdmin',params:data})
		  .success(callback)
		  .error(function(data, status, headers, config) {
		  });
		},
	};
}])

// .factory('manageCustomer', ['$http', function($http) 
// {
// 	return {
// 		saveCustomer:function(data,callback)
// 		{
// 			$http({method: 'GET', url: '/saveAdmin',params:data})
// 		  .success(callback)
// 		  .error(function(data, status, headers, config) {
// 		  });
// 		},
// 		checkUserName:function(data,callback)
// 		{
// 			$http({method: 'GET', url: '/checkUser',params:data})
// 		  .success(callback)
// 		  .error(function(data, status, headers, config) {
// 		  });
// 		},
// 		getAdmin:function(callback)
// 		{
// 			$http({method: 'GET', url: '/admin'})
// 		  .success(callback)
// 		  .error(function(data, status, headers, config) {
// 		  });
// 		},
// 		deleteAdmin:function(data,callback)
// 		{
// 			$http({method: 'GET', url: '/deleteAdmin',params:data})
// 		  .success(callback)
// 		  .error(function(data, status, headers, config) {
// 		  });
// 		},
// 		updateAdmin:function(data,callback)
// 		{
// 			$http({method: 'GET', url: '/updateAdmin',params:data})
// 		  .success(callback)
// 		  .error(function(data, status, headers, config) {
// 		  });
// 		},
// 	};
// }]);