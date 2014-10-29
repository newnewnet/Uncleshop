angular.module('uncleshopApp')
.controller('uncleshopController', ['$scope','$rootScope','manageAdmin','manageCustomers', function($scope,$rootScope,manageAdmin,manageCustomers) 
{
		
	$scope.changTab = function(number)
	{
		var text = ['','เพิ่มบิล','ค้นหาบิล','ข้อมูลการจ่ายบิล', 'ข้อมูลลูกค้า', 'ข้อมูลผู้ขาย']
		$rootScope.tabColor=number;
		$rootScope.loginText=text[number];

		switch(number){
			case 1: 
				$scope.DataCustomer_toggle = false;
				$scope.focusItem('search_focus');
				break;
			case 2:
				break;
			case 5:
				$scope.adminToggle = false;
				break;
		}

	};

	/////เวลาส่งทำงี้นะ

	$scope.seachCustomers = function ()
	{
		var data = {
			'key':$rootScope.search.data
		}
		manageCustomers.getCustomers(data,function(data, status, headers, config)
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

	/*---------------------------- Bill-->Customers  ---------------------------------*/
	$scope.switchDataCustomer = function(){
		$scope.customersDefault();
		if($scope.DataCustomer_toggle){
			$scope.DataCustomer_toggle = !$scope.DataCustomer_toggle;
			$scope.focusItem('search_focus');
		}
		else{
			$scope.DataCustomer_toggle = !$scope.DataCustomer_toggle;
			$scope.focusItem('customers_id_focus');
		}
		$rootScope.DataCustomers = null;
		$rootScope.search.data = null;
	};

	$scope.customersDefault = function()
	{		
		$scope.customersId = '';
		$scope.customersName = '';
		$scope.customersLastName = '';
		$scope.customersTel = '';
		$scope.customersSex = 'male';
		$scope.customersAddress = '';
		$scope.customersError = [];
		$scope.customerSubmit = true;
	};

	$scope.addCustomers = function() {
		if($scope.customersId != '' && $scope.customersId.length == 13)
			$scope.customerSubmit = true;
		else{
			$scope.customersError[0] = 'input-error';
			$scope.customerSubmit = false;
		}

		if($scope.customersName != '')
			$scope.customerSubmit = true;
		else{
			$scope.customersError[1] = 'input-error';
			$scope.customerSubmit = false;
		}

		if($scope.customersLastName != '')
			$scope.customerSubmit = true;
		else{
			$scope.customersError[2] = 'input-error';
			$scope.customerSubmit = false;
		}

		if($scope.customersTel != '' && $scope.customersTel.length == 10)
			$scope.customerSubmit = true;
		else{
			$scope.customersError[3] = 'input-error';
			$scope.customerSubmit = false;
		}

		if($scope.customersAddress != '')
			$scope.customerSubmit = true;
		else{
			$scope.customersError[4] = 'input-error';
			$scope.customerSubmit = false;
		}

		if($scope.customerSubmit == true)	{
			data = {
				'customers_id' : $scope.customersId,
				'customers_name' :  $scope.customersName,
				'customers_last_name' : $scope.customersLastName,
				'customers_address' :  $scope.customersAddress,
				'customers_sex' : $scope.customersSex,
				'customers_tel' : $scope.customersTel
			};
			manageCustomers.addCustomers(data,function(data, status, headers, config) {
				if(data != 'error')
					swal({
						title: "เรียบร้อย !!",   
						text: "เพิ่มข้อมูลลูกค้าแล้ว",   
						type: "success",
						timer: 1500
					});
					$scope.customersDefault();
			});
		}
	};

	$scope.checkCustomersId = function(value) {
		setTimeout(function()
			{
				var data = {
					'customers_id' : $scope.customersId
				};
				manageCustomers.checkCustomersId(data,function(data, status, headers, config)
				{
					if(data == 'customers-same'){
						$scope.customersError[0] = 'input-error';
					}
					else 
						$scope.customersError[0] = '';
				});
			}, 500);
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
		$scope.adminUserName = '';
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
			$scope.focusItem(null);
		}
		else{
			$scope.adminToggle = !$scope.adminToggle;
			$scope.focusItem('admin_id_focus');
			$scope.editFlug = true;
		}
	};

	$scope.getAdmins = function ()
	{
		manageAdmin.getAdmin(function(data, status, headers, config)
		{
			$scope.admins = data;
		});
	};

	$scope.register = function(value)
	{
		$scope.checkAdminPassword();
		if($scope.adminId.length == 13)
			console.log('13 : '+$scope.adminId.length);
		if($scope.adminId != '' && $scope.adminId.length == 13 && $scope.adminUserName != '' && $scope.adminPassword !='')
		{
			data = {
				'admin_id' : $scope.adminId,
				'admin_name' :  $scope.adminName,
				'admin_last_name' : $scope.adminLastName,
				'admin_user' :  $scope.adminUserName,
				'admin_password' : $scope.adminPassword,
				'admin_sex' : $scope.adminSex,
				'admin_tel' : $scope.adminTel,
				'admin_address' :  $scope.adminAddress
			};
			
			if(value == 1 && $scope.adminSubmitError == true)
			{
				manageAdmin.saveAdmin(data,function(data, status, headers, config)
				{
					if(data != 'error'){
						$scope.getAdmins(); //get all admin after saved new admin
						$scope.adminToggle = false;
					}
				});
			}

			else if(value == 2)
			{
				manageAdmin.updateAdmin(data,function(data, status, headers, config)
				{
					swal({
						title: "เรียบร้อย !!",   
						text: "แก้ไขข้อมูลเรียบร้อยแล้ว",   
						type: "success",
						timer: 1500
					});
					$scope.adminToggle = false;
					$scope.getAdmins();
				});
			}

		}
		else
		{
			if($scope.adminId == '')
				$scope.adminError[0] = 'input-error'; //input adminID
			if($scope.adminUserName == '')
				$scope.adminError[1] = 'input-error'; //input adminUserName
			if($scope.adminPassword == '')
				$scope.adminError[2] = 'input-error'; //input adminPassword
			if($scope.adminId.length != 13)
				$scope.adminError[0] = 'input-error'; //input adminID
		}
	};

	$scope.checkAdminId = function(){
		setTimeout(function()
		{
			var data = {
				'admin_id': $scope.adminId
			};
			manageAdmin.checkAdmin(data,function(data, status, headers, config)
			{
				console.log(data);
				if(data == 'adminId-same'){
					$scope.adminError[0] = 'input-error';
					$scope.adminSubmitError = false;
				}
				else{
					$scope.adminError[0] = '';
					$scope.adminSubmitError = true;
				}
			});
		}, 500);
	}

	$scope.checkAdminUserName = function(){
		setTimeout(function()
		{
			var data = {
				'username' : $scope.adminUserName
			};
			manageAdmin.checkAdmin(data,function(data, status, headers, config){
				if(data == 'userName-same' ){
					$scope.adminSubmitError = false;
					$scope.adminError[1] = 'input-error';
				}
				else{
					$scope.adminError[1] = '';
					$scope.adminSubmitError = true;
				}
			});
		}, 500);
	}

	$scope.checkAdminPassword = function()
	{
		if($scope.adminPassword != ''){
			$scope.adminError[2] = '';
			$scope.adminSubmitError = true;
		}
		else{
			$scope.adminError[2] = 'input-error';
			$scope.adminSubmitError = false;
		}
		console.log('adminPassword');
	};

	$scope.editAdmin = function(index)
	{
		$scope.adminToggle = true;
		$scope.editFlug = false;
		$scope.adminIdDisabled = true;
		$scope.adminId = $scope.admins[index].admin_id;
		$scope.adminName =  $scope.admins[index].admin_name;
		$scope.adminLastName =  $scope.admins[index].admin_last_name;
		$scope.adminUserName =  $scope.admins[index].admin_user;
		$scope.adminPassword =  $scope.admins[index].admin_password;
		$scope.adminSex = $scope.admins[index].admin_sex;
		$scope.adminTel =  $scope.admins[index].admin_tel;
		$scope.adminAddress =  $scope.admins[index].admin_address;
	};

	$scope.removeAdmin = function()
	{
		var data = {
			'admin_id' : $scope.adminId
		};
		manageAdmin.deleteAdmin(data,function(data, status, headers, config)
		{
			swal({
				title: "เรียบร้อย !!",   
				text: "เพิ่มข้อมูลลูกค้าแล้ว",   
				type: "success",
				timer: 1500
			});
			/*------------*/
			swal({   
				title: "Are you sure?",   
				text: "You will not be able to recover this imaginary file!",   
				type: "warning",   
				showCancelButton: true,   
				confirmButtonColor: "#DD6B55",   
				confirmButtonText: "Yes, delete it!",   
				closeOnConfirm: false 
			}, function(){   
				swal("Deleted!", "Your imaginary file has been deleted.", "success"); 
				$scope.getAdmins();
				$scope.adminToggle = false;
			});
		});
	};
	
}])

// .factory('bill', ['$http', function($http) 
// {
// 	return {
// 		saveBill:function(data,callback)
// 		{
// 			$http({method: 'GET', url: '/saveBill',params:data})
// 			.success(callback)
// 			.error(function(data, status, headers, config) {
// 		  });
// 		},
// 		getCustomers:function(data,callback)
// 		{
// 			$http({method: 'GET', url: '/customers',params:data})
// 			.success(callback)
// 			.error(function(data, status, headers, config) {
// 		  });
// 		}
// 	};
// }])

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
		checkAdmin:function(data,callback)
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

.factory('manageCustomers', ['$http', function($http) 
{
	return {
		addCustomers:function(data,callback)
		{
			$http({method: 'GET', url: '/saveCustomers',params:data})
		  .success(callback)
		  .error(function(data, status, headers, config) {
		  });
		},
		checkCustomersId:function(data,callback)
		{
			$http({method: 'GET', url: '/checkCustomersId',params:data})
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
		},
		deleteCustomers:function(data,callback)
		{
			$http({method: 'GET', url: '/deleteCustomers',params:data})
		  .success(callback)
		  .error(function(data, status, headers, config) {
		  });
		},
		updateCustomers:function(data,callback)
		{
			$http({method: 'GET', url: '/updateCustomers',params:data})
		  .success(callback)
		  .error(function(data, status, headers, config) {
		  });
		},
	};
}]);