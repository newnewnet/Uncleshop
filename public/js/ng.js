angular.module('uncleshopApp')
.controller('uncleshopController', ['$scope','$rootScope','manageAdmin','manageCustomers','manageBill', function($scope,$rootScope,manageAdmin,manageCustomers,manageBill) 
{

	$scope.month = ['','มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฏาคม','สิงหาคม','กันยายน','คุลาคม','พฤศจิกายน','ธันวาคม'];
		
	$scope.changTab = function(number)
	{
		var text = ['','เพิ่มบิล','ค้นหาบิล','ข้อมูลการจ่ายบิล', 'ข้อมูลลูกค้า', 'ข้อมูลผู้ขาย']
		$rootScope.tabColor=number;
		$rootScope.loginText=text[number];
		
		if(number == 1){
			$scope.backToBill();
			//$scope.focusItem('search_focus');
		}
		else if(number == 2){
			// $rootScope.searchBill.data = null;
			// $scope.findPayBill_toggle = true;
			// $scope.optionSearchPayBill = 0;
			$scope.backToPayBill();
		}
		else if(number == 4){
			$scope.backToEditCustomer();
			// $scope.getAdmins();
			// $scope.adminToggle = false;
			//$scope.focusItem(null);
		}
		else if(number == 5){
			$scope.getAdmins();
			$scope.adminToggle = false;
			//$scope.focusItem(null);
		}
		else
			$scope.focusItem(null);
	};

$scope.al = function(){
	alert('scroll');
}

	/////เวลาส่งทำงี้นะ
/*----------------------------  Customer  ---------------------------------*/
	$scope.seachCustomers = function (type)
	{
		if(type == 1){
			$scope.page = 1;
			var data = {
				'key':$rootScope.search.data,
				'perpage': 18,
				'page': $scope.page
			}
			// console.log('search.data');
			// console.log($rootScope.search.data);
			manageCustomers.getCustomers(data,function(data, status, headers, config)
			{
				$rootScope.DataCustomers = data.data;	
				console.log(data);			
			},500);
		}

		else{
			alert('scroll');
			var data = {
				'key':$rootScope.search.data,
				'perpage': 15,
				'page': ++$scope.page
			}
			// console.log('scope.page : '+$scope.page);
			manageCustomers.getCustomers(data,function(data, status, headers, config)
			{
				// console.log('data.data.page : '+data.page);

				if($scope.page <= data.page){
					console.log('<= is true');
					for(var i=0; i<data.data.length; i++){
						$rootScope.DataCustomers.push(data.data[i]);
					}
					console.log($rootScope.DataCustomers);
				}
			},500);
		}		
	};

	$scope.backToEditCustomer = function () {
		$rootScope.DataCustomers = [];
		$scope.Search_Customer_toggle = true;
		$scope.Edit_Customer_toggle = false;
		$scope.Add_Customer_toggle = false;
		$scope.customersDefault();
		$scope.search.data = null;
	};

	$scope.editCustomer = function (index){
		$scope.Edit_Customer_toggle = true;
		$scope.Search_Customer_toggle = false;
		$scope.Add_Customer_toggle = false;
		$scope.EditCustomerError = ['1','1','1'];

		$scope.EditCustomersId = $rootScope.DataCustomers[index].customers_id;
		$scope.EditCustomersIdCard = $rootScope.DataCustomers[index].customers_id_card;
		$scope.EditCustomersName = $rootScope.DataCustomers[index].customers_name;
		$scope.EditCustomersTel = $rootScope.DataCustomers[index].customers_tel;
		$scope.EditCustomersAddress = $rootScope.DataCustomers[index].customers_address;
		$scope.EditCustomersSex = $rootScope.DataCustomers[index].customers_sex;
	};

	$scope.keyCheckCustomer = function (){
		if($scope.EditCustomersName == ''){
			$scope.EditCustomerError[0] = 'input-error';
		}
		else{
			$scope.EditCustomerError[0] = '1';
		}

		if($scope.EditCustomersTel.length != 10){
			$scope.EditCustomerError[1] = 'input-error';
		}
		else{
			$scope.EditCustomerError[1] = '1';
		}

		if($scope.EditCustomersAddress == ''){
			$scope.EditCustomerError[2] = 'input-error';
		}
		else{
			$scope.EditCustomerError[2] = '1';
		}
	};

	$scope.updateCustomer = function (){
		var text = '';
		if($scope.EditCustomerError[0].length > 1)
			text += ' ชื่อลูกค้า ';
		if($scope.EditCustomerError[1].length > 1)
			text += ' เบอร์โทรศัพท์ ';
		if($scope.EditCustomerError[2].length > 1)
			text += ' ที่อยู่ ';

		if(text.length > 0){
			swal({
				title: "ไม่สำเร็จ !!",   
				text: "กรุณาตรวจสอบ" + text + 'อีกครั้ง',   
				type: "error",
				timer: 2000
			});
		}

		else if(text.length == 0){
			var data = {
				'customers_id': $scope.EditCustomersId,
				'customers_id_card': $scope.EditCustomersIdCard,
				'customers_name': $scope.EditCustomersName,
				'customers_address': $scope.EditCustomersAddress,
				'customers_sex': $scope.EditCustomersSex,
				'customers_tel': $scope.EditCustomersTel
			};

			manageCustomers.updateCustomers(data,function(data, status, headers, config){
				if(data == 1){
					swal({
						title: "เรียบร้อย !!",   
						text: "แก้ไขข้อมูลเรียบร้อยแล้ว",   
						type: "success",
						timer: 1500
					});
				}
				else{
					swal({
						title: "ไม่สำเร็จ !!",   
						text: "กรุณาลองใหม่อีกครั้ง",  
						type: "error",
						timer: 2000
					});
				}
			});
		}
	};

	$scope.removeCustomer = function(CustomerId) {
		swal({   
			title: "ลบข้อมูลลูกค้า ?",   
			text: "คุณต้องการลบข้อมูลลูกค้าใช่หรือไม่",   
			type: "warning",   
			showCancelButton: true,   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "ใช่, ลบออก !",   
			cancelButtonText: "ยกเลิก",
			closeOnConfirm: false 
		}, function(){
			var data = {
				'customers_id': CustomerId
			};
			manageCustomers.deleteCustomers(data,function(data, status, headers, config)
			{
				if(data == 1){
					swal({
						title: "เรียบร้อย !!",   
						text: "ลบข้อมูลลูกค้าเรียบร้อยแล้ว",   
						type: "success",
						timer: 1500
					});
				}
				else{
					swal({
						title: "ไม่สำเร็จ !!",   
						text: "กรุณาลองใหม่อีกครั้ง",   
						type: "error",
						timer: 2000
					});
				}
			},500);
		});
	};

	$scope.backToBill = function() {
		$scope.DataCustomer_toggle = false;
		$scope.addProduct_toggle = true;
		$scope.billCode = null;
		$scope.setBillDefault();
	};

	$scope.backToPayBill = function() {
		$scope.findPayBill_toggle = true;
		$rootScope.DataBill = null;
		$scope.searchBill.data = null;
		$scope.optionSearchPayBill = 0;
		$scope.customersDes_toggle = false;
		$scope.productDes_toggle = false;
		$scope.priceDes_toggle = false;
	};

	$scope.backToAdmin = function() {
		$scope.adminToggle = false;
		$scope.getAdmins();
	};


	/*----------------------------  bill  ---------------------------------*/
	$scope.addCustomerToBill = function(index) {
		$scope.DataCustomersOfBill = $scope.DataCustomers[index];
		$scope.DataCustomer_toggle = false;
		$scope.addProduct_toggle = true;
	};

	$scope.cutBill = function() {
		var detail_index = null;
		for(var i = 0;i<$scope.DataPayBill.dateBill.length;i++){
			if($scope.DataPayBill.dateBill[i].bill_detail_status == 99){
				detail_index = i;
			}
		}

		var detail_price = $scope.DataPayBill.bill.bill_installments_price*($scope.DataPayBill.bill.bill_date_amount-detail_index);
		detail_price = detail_price - ($scope.DataPayBill.bill.bill_interest_to_mount*($scope.DataPayBill.bill.bill_date_amount-(detail_index+1)));

		var data = {
			'bill_detail_id' : $scope.DataPayBill.dateBill[detail_index].bill_detail_id,
			'bill_detail_price' : detail_price,
			'admin_id' : $rootScope.admin.admin_id,
			'bill_interest' : ($scope.DataPayBill.bill.bill_interest_to_mount*($scope.DataPayBill.bill.bill_date_amount-(detail_index+1))),
			'bill_date_amount' : parseInt(detail_index+1),
			'bill_code' : $scope.DataPayBill.bill.bill_code
		};
		console.log(data);
		swal({   
			title: "ชำระเงินที่เหลือทั้งหมด(ตัดบิล) ?",   
			text: "คุณต้องการชำระเงินประจำวันที่ " + $scope.DataPayBill.dateBill[detail_index].bill_detail_date + " เป็นจำนวนเงิน " + data.bill_detail_price + " บาท (ตัดบิล) ใช่หรือไม่",   
			type: "warning",   
			showCancelButton: true,   
			confirmButtonColor: "#2980B9",   
			confirmButtonText: "ใช่, ชำระเงินเดี๋ยวนี้ !",   
			cancelButtonText: "ยกเลิก",
			closeOnConfirm: false 
		}, function(){
			manageBill.cutBillDetail(data,function(data, status, headers, config){
				if(data == 1){
					swal({
						title: "เรียบร้อย !!",   
						text: "ชำระเงินเรียบร้อยแล้ว",   
						type: "success",
						timer: 1500
					});
					$scope.payBillWithBillCode($scope.DataPayBill.bill.bill_code);
				}
				else{
					swal({
						title: "ไม่สำเร็จ !!",   
						text: "กรุณาลองใหม่อีกครั้ง",   
						type: "error",
						timer: 2000
					});
				}
			},500);
		});
	}

	$scope.payTermOfBill = function(index) {	
		if($scope.DataPayBill.dateBill[index].bill_detail_status == 99){
			swal({   
				title: "ชำระเงิน ?",   
				text: "คุณต้องการชำระเงินประจำวันที่ " + $scope.DataPayBill.dateBill[index].bill_detail_date + " เป็นจำนวนเงิน " + $scope.DataPayBill.bill.bill_installments_price + " บาท ใช่หรือไม่",   
				type: "warning",   
				showCancelButton: true,   
				confirmButtonColor: "#2980B9",   
				confirmButtonText: "ใช่, ชำระเงินเดี๋ยวนี้ !",   
				cancelButtonText: "ยกเลิก",
				closeOnConfirm: false 
			}, function(){
				var data = {
					'bill_detail_id': $scope.DataPayBill.dateBill[index].bill_detail_id,
					'bill_detail_price': $scope.DataPayBill.bill.bill_installments_price,
					'admin_id': $rootScope.admin.admin_id
				};	
				manageBill.updateBillDetail(data,function(data, status, headers, config){			
					if(data == 1){
						swal({
							title: "เรียบร้อย !!",   
							text: "ชำระเงินเรียบร้อยแล้ว",   
							type: "success",
							timer: 1500
						});
						$scope.payBillWithBillCode($scope.DataPayBill.bill.bill_code);
					}
					else{
						swal({
							title: "ไม่สำเร็จ !!",   
							text: "กรุณาลองใหม่อีกครั้ง",   
							type: "error",
							timer: 2000
						});
					}					
				},500);
			});
		}
		else if($scope.DataPayBill.dateBill[index].bill_detail_status == 1 || $scope.DataPayBill.dateBill[index].bill_detail_status == 2){
			if($scope.DataPayBill.dateBill[index].admin_id != null){
				swal({
					title: "คุณ " + $scope.DataPayBill.dateBill[index].admin_name.admin_name + " เป็นผู้รับการชำระเงิน",   
					text: "ประจำวันที่ " + $scope.DataPayBill.dateBill[index].bill_detail_date,   
				});
			}
		}		
	};

	$scope.payBill = function(index) {
		console.log(index);
		console.log($rootScope.DataBill.data[index].bill_code);
		var data = {
			'bill_code': $rootScope.DataBill.data[index].bill_code
		};
		//$scope.billCode = $scope.DataBill[index].bill_code;
		manageBill.getBill(data,function(data, status, headers, config){		
			$scope.DataPayBill = data;			 
			if($scope.DataPayBill.bill.bill_status == 0){
				var length = $scope.DataPayBill.dateBill.length;

				if($scope.DataPayBill.dateBill[0].bill_detail_status == 0){
					$scope.DataPayBill.dateBill[0].bill_detail_status = 99;
				}
				else {
					for(var i=0; i<length-1; i++){ // -1 or don't
						if($scope.DataPayBill.dateBill[i].bill_detail_status == 1 && $scope.DataPayBill.dateBill[i+1].bill_detail_status != 1){
							$scope.DataPayBill.dateBill[i+1].bill_detail_status = 99; // 99 คือ รอจ่ายเงิน
						}				

					}
				}				

				if($scope.DataPayBill.dateBill[length-1].bill_detail_status == 99 || $scope.DataPayBill.dateBill[length-1].bill_detail_status == 1){
					$scope.cutBill_toggle = false;
					console.log('status = '+$scope.DataPayBill.dateBill[length-1].bill_detail_status);
					console.log('yes');
				}
				else
					$scope.cutBill_toggle = true;
			}

			console.log($scope.DataPayBill);
		},500);
		$scope.findPayBill_toggle = false;
	};

	$scope.payBillWithBillCode = function(billCode) {
		var data = {
			'bill_code': billCode
		};
		manageBill.getBill(data,function(data, status, headers, config){			
			$scope.DataPayBill = data;
			if($scope.DataPayBill.bill.bill_status == 0){
				var length = $scope.DataPayBill.dateBill.length;
				if($scope.DataPayBill.dateBill[0].bill_detail_status == 0){
					$scope.DataPayBill.dateBill[0].bill_detail_status = 99;
					console.log('yes');
				}
				else {
					for(var i=0; i<length-1; i++){ // -1 or don't
						if($scope.DataPayBill.dateBill[i].bill_detail_status == 1 && $scope.DataPayBill.dateBill[i+1].bill_detail_status != 1){
							$scope.DataPayBill.dateBill[i+1].bill_detail_status = 99; // 99 คือ รอจ่ายเงิน
						}				
					}
				}					

				if($scope.DataPayBill.dateBill[length-1].bill_detail_status == 99 || $scope.DataPayBill.dateBill[length-1].bill_detail_status == 1){
					$scope.cutBill_toggle = false;
					console.log('status = '+$scope.DataPayBill.dateBill[length-1].bill_detail_status);
					console.log('yes');
				}
				else
					$scope.cutBill_toggle = true;
			}
			
			$scope.findPayBill_toggle = false;	

			console.log($scope.DataPayBill);
		},500);
	};

	$scope.calBill = function(value) {

		if(value == 'priceDow')
			$scope.priceDowError = ' ';
		if(value == 'timeOfPayment')
			$scope.timeOfPaymentError = ' ';

		var priceOfAllProduct = 0;
		$scope.billData = [];
		for(var i = 0; i<$scope.productData.length; i++){
			priceOfAllProduct +=  $scope.productData[i].productPrice * $scope.productData[i].productAmount;
		}

		var interest;
		manageAdmin.getInterestValue(function(data, status, headers, config)
		{
			if($scope.type_dow == 'month')
				interest = data.admin_interest_month;
			else
				interest = data.admin_interest_week;

			if($scope.timeOfPayment == null)
				$scope.timeOfPayment = 0;
			if($scope.priceDow == null)
				$scope.priceDow = 0;
			if($scope.timeOfPayment == null)
				$scope.timeOfPayment = 1;

				$scope.billData = {
					'priceOfAllProduct': priceOfAllProduct,//ราคาสินค้าทั้งหมด
					'interestValue':  interest*$scope.timeOfPayment,//ดอกเบี้ย
					'priceDow': $scope.priceDow, //เงินดาว
					'timeOfPayment': $scope.timeOfPayment, //เวลาในการผ่อน
					'priceWithoutDow': $scope.priceWithoutDow = (priceOfAllProduct+(interest*$scope.timeOfPayment)) - $scope.priceDow,//ราคารวมดอกเบี้ยและหักเงินดาวน์
					'priceTermOfPayment': $scope.priceWithoutDow / $scope.timeOfPayment //ราคาต่องวด
				};
		},500);
	};

	/*---------------------------- Bill-->Customers  ---------------------------------*/
	$scope.switchDataCustomer = function(){
		$scope.customersDefault();
		$scope.DataCustomer_toggle = true;
		if($scope.addProduct_toggle){
			$scope.DataCustomer_search_toggle = true;
		}
		else{
			if($scope.DataCustomer_search_toggle){
				$scope.DataCustomer_search_toggle = !$scope.DataCustomer_search_toggle;
				$scope.focusItem('search_focus');
			}
			else{
				$scope.DataCustomer_search_toggle = !$scope.DataCustomer_search_toggle;
				$scope.focusItem('customers_id_focus');
			}
		}
		$rootScope.DataCustomers = [];
		$rootScope.search.data = null;
		$scope.addProduct_toggle = false;
	};

	$scope.customersDefault = function()
	{		
		$scope.customersIdCard = '';
		$scope.customersName = '';
		$scope.customersTel = '';
		$scope.customersSex = 'male';
		$scope.customersAddress = '';
		$scope.customersError = [];
		$scope.customerSubmit = true;
	};

	$scope.addCustomers = function() {
		if($scope.customersIdCard != '' && $scope.customersIdCard.length == 13)
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
				'customers_id_card' : $scope.customersIdCard,
				'customers_name' :  $scope.customersName,
				'customers_address' :  $scope.customersAddress,
				'customers_sex' : $scope.customersSex,
				'customers_tel' : $scope.customersTel
			};
			$scope.DataCustomersOfBill = data;
			
			manageCustomers.checkCustomersIdCard(data,function(data, status, headers, config)
				{
					if(data == 'customers-same'){
						swal({
							title: "ไม่สำเร็จ !!",   
							text: "เลขบัตรประชาชนนี้มีอยู่ในระบบแล้ว",   
							type: "error",
							timer: 2000
						});
					}
					else{
						manageCustomers.addCustomers($scope.DataCustomersOfBill,function(data, status, headers, config) {
							if(data != 'error'){
								swal({
									title: "เรียบร้อย !!",   
									text: "เพิ่มข้อมูลลูกค้าแล้ว",   
									type: "success",
									timer: 1500
								});
								$scope.customersDefault();
								$scope.addProduct_toggle = true;
								$scope.DataCustomer_toggle = false;
							}
							else
								swal({
									title: "ไม่สำเร็จ !!",   
									text: "กรุณาตรวจสอบข้อมูลอีกครั้ง",   
									type: "error",
									timer: 2000
								});
						});
					}
			}, 500);
		}
		else{
			swal({
				title: "ไม่สำเร็จ !!",   
				text: "กรุณาตรวจสอบข้อมูลอีกครั้ง",   
				type: "error",
				timer: 2000
			});
		}
	};

	$scope.checkCustomersIdCard = function() {
		setTimeout(function()
		{
			var data = {
				'customers_id_card' : $scope.customersIdCard
			};
			manageCustomers.checkCustomersIdCard(data,function(data, status, headers, config)
			{
				if(data == 'customers-same'){
					$scope.customersError[0] = 'input-error';
				}
				else 
					$scope.customersError[0] = '';
			});
		}, 500);
	};

	/*---------------------------- Bill-->Customers  ---------------------------------*/
	$scope.searchBillForPay = function() {
		var data = {
			'key': $rootScope.searchBill.data,
			'status': $scope.optionSearchPayBill
		}
		// console.log();
		console.log('status: ' + $scope.optionSearchPayBill);
		manageBill.searchBill(data,function(data, status, headers, config)
		{
			// console.log(data);
			// console.log('option' + $scope.optionSearchPayBill);
			$rootScope.DataBill = data;
			// console.log(data);
			console.log($rootScope.DataBill);
		}, 500);
	};

	/*----------------------------  super  admin---------------------------------*/
	$scope.adminDefault = function()
	{
		$scope.adminSex = 'male';
		$scope.adminTel = '';
		$scope.adminName = '';
		$scope.adminAddress = '';
		$scope.userError = '';
		$scope.adminIdCard = '';
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
			console.log($scope.adminToggle);
			console.log(data);
		},500);
	};

	$scope.register = function(value)
	{
		// console.log("11111");
		$scope.checkAdminPassword();
		// if($scope.adminIdCard.length == 13)
		if($scope.adminIdCard != '' && $scope.adminIdCard.length == 13 && $scope.adminUserName != '' && $scope.adminPassword !='')
		{
			if(value == 1){
				data = {
					'admin_id_card' : $scope.adminIdCard,
					'admin_name' :  $scope.adminName,
					'admin_user' :  $scope.adminUserName,
					'admin_password' : $scope.adminPassword,
					'admin_sex' : $scope.adminSex,
					'admin_tel' : $scope.adminTel,
					'admin_address' :  $scope.adminAddress
				};
			}
			if(value == 2){
				data = {
					'admin_id' : $scope.adminId,
					'admin_id_card' : $scope.adminIdCard,
					'admin_name' :  $scope.adminName,
					'admin_user' :  $scope.adminUserName,
					'admin_password' : $scope.adminPassword,
					'admin_sex' : $scope.adminSex,
					'admin_tel' : $scope.adminTel,
					'admin_address' :  $scope.adminAddress
				};
			}
			
			if(value == 1 && $scope.adminSubmitError == true)
			{
				manageAdmin.saveAdmin(data,function(data, status, headers, config)
				{
					if(data != 'error'){
						swal({
							title: "เรียบร้อย !!",   
							text: "เพิ่มข้อมูลผู้ขายแล้ว",   
							type: "success",
							timer: 1500
						});
						$scope.getAdmins(); //get all admin after saved new admin
						$scope.adminToggle = false;
					}
					else{
						swal({
							title: "ไม่สำเร็จ !!",   
							text: "กรุณาลองใหม่อีกครั้ง",   
							type: "error",
							timer: 2000
						});
					}
				},500);
			}

			else if(value == 2)
			{
				manageAdmin.updateAdmin(data,function(data, status, headers, config)
				{
					if(data == '1'){ //update success = 1
						swal({
							title: "เรียบร้อย !!",   
							text: "แก้ไขข้อมูลเรียบร้อยแล้ว",   
							type: "success",
							timer: 1500
						});
						$scope.adminToggle = false;
						$scope.getAdmins();
					}
					else{
						swal({
							title: "ไม่สำเร็จ !!",   
							text: "กรุณาลองใหม่อีกครั้ง",   
							type: "error",
							timer: 2000
						});
					}
				},500);
			}
		}
		else
		{
			if($scope.adminIdCard == '')
				$scope.adminError[0] = 'input-error'; //input adminID
			if($scope.adminUserName == '')
				$scope.adminError[1] = 'input-error'; //input adminUserName
			if($scope.adminPassword == '')
				$scope.adminError[2] = 'input-error'; //input adminPassword
			if($scope.adminIdCard.length != 13)
				$scope.adminError[0] = 'input-error'; //input adminID
		}
	};

	$scope.checkAdminId = function(){
		setTimeout(function()
		{
			var data = {
				'admin_id_card': $scope.adminIdCard
			};
			manageAdmin.checkAdmin(data,function(data, status, headers, config)
			{
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
	};

	$scope.editAdmin = function(index)
	{
		$scope.adminToggle = true;
		$scope.editFlug = false;
		$scope.adminIdDisabled = true;
		$scope.adminId = $scope.admins[index].admin_id;
		$scope.adminIdCard = $scope.admins[index].admin_id_card;
		$scope.adminName =  $scope.admins[index].admin_name;
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
		swal({   
			title: "ต้องการลบ ?",   
			text: "ข้อมูลสำคัญของผู้ขายจะถูกลบ",   
			type: "warning",   
			showCancelButton: true,   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "ใช่, ลบออก !",
			cancelButtonText: "ยกเลิก",
			closeOnConfirm: false 
		}, function(){   
			manageAdmin.deleteAdmin(data,function(data, status, headers, config)
			{
				$scope.getAdmins();
				$scope.adminToggle = false;
				console.log(data);
				if(data == '1'){ //delete success = 1
					swal({
						title: "เรียบร้อย !!",   
						text: "ข้อมูลผู้ขายถูกลบแล้ว",   
						type: "success",
						timer: 1500
					});
				}
				else{
					swal({
						title: "ไม่สำเร็จ !!",   
						text: "กรุณาลองใหม่อีกครั้ง",   
						type: "error",
						timer: 2000
					});
				}
			});
		});
	};
	/*when init*/
	$scope.init = function() {
		$scope.changTab(4);
		//$scope.getAdmins();
		$scope.adminDefault();
		$scope.customersDefault();
		$scope.productDefault();
		$scope.EditCustomerError = ['1','1','1'];
	};

	/*----------------------------  prodcut---------------------------------*/
	$scope.setBillDefault = function() {
		$scope.productDefault();
		$scope.billData = [];
		$scope.DataCustomersOfBill = null;
		$scope.priceDow = null;
	}
	$scope.productDefault = function()
	{
		$scope.productData = [];
		$scope.productData[0]={
			'productName':'',
			'productPrice':'',
			'productAmount':''
		};
		$scope.countProduct = $scope.productData.length;
	};

	$scope.positiveProduct = function() {
		$scope.productData.push({
			'productName':'',
			'productPrice':'',
			'productAmount':'',
		});
		$scope.countProduct = $scope.productData.length;
	};
	$scope.minusProduct = function(index) {
		$scope.productData.splice(index,1);
		$scope.countProduct = $scope.productData.length;
	};
 	$scope.checkProductError = function(index,nameError)
 	{
 		if(nameError == 'productNameError')
		{
			if($scope.productData[index].productNameError != '')
				$scope.productData[index].productNameError = '';
		}
		else if(nameError == 'productPriceError')
		{
			if($scope.productData[index].productPriceError != '')
				$scope.productData[index].productPriceError = '';
		}
		else if(nameError == 'productAmountError')
		{
			if($scope.productData[index].productAmountError != '')
				$scope.productData[index].productAmountError = '';
		}

		$scope.calBill();
 	}
	$scope.createBill  = function()
	{
		var count = true;
		angular.forEach($scope.productData, function(products) {
		
			if(products.productName == '')
			{
				count = false;
				products.productNameError = 'input-error';
			}
			if( products.productPrice == '' )
			{
				count = false;
				products.productPriceError = 'input-error';
			}
			if(products.productAmount == '')
			{
				count = false;
				products.productAmountError = 'input-error';
			}
			if($scope.priceDow == null || $scope.priceDow.length == 0){
				$scope.priceDowError = 'input-error';
				count = false;
			}
			if($scope.timeOfPayment == null || $scope.timeOfPayment.length == 0){
				$scope.timeOfPaymentError = 'input-error';
				count = false;
			}

			if(count == false){
				swal({
					title: "ไม่สำเร็จ !!",   
					text: "กรุณาตรวจสอบข้อมูลอีกครั้ง",   
					type: "error",
					timer: 2000
				});
			}

		});
		if($scope.DataCustomersOfBill == null && count != false){
			count = false;
			swal({
				title: "ไม่สำเร็จ !!",   
				text: "กรุณาเพิ่มข้อมูลลูกค้าก่อน",   
				type: "error",
				timer: 2000
			});
		}
		if(count)
		{
			var billType = 0;
			if($scope.type_dow == 'week')
			{
				billType = 1;
			}
			var data = {
				'bill_price' : $scope.billData.priceOfAllProduct, // ราคาสินค้าทั้งหมด
				'bill_date_amount' : $scope.timeOfPayment, // จำนวนงวด
				'bill_interest' : $scope.billData.interestValue, 
				'bill_type' : billType, //ชนิการผ่อน
				'bill_price_dow' : $scope.priceDow, //ราคาเงินดาวน์
				'customers_id_card' : $scope.DataCustomersOfBill.customers_id_card,
				'admin_id':$rootScope.admin.admin_id ,
				'customers_id' : $scope.customersIdCard,
				'product' : $scope.productData
			};
			data = {
				data:JSON.stringify(data)
			};
			manageBill.createBill(data,function(data, status, headers, config)
			{
				if(data != '')
				{	
					swal({
						title: "เรียบร้อย !!",   
						text: "เพิ่มบิลเรียบร้อยแล้ว",   
						type: "success",
						timer: 1500
					});
					$scope.billCode = data;
				}
			})
		}
	};

}])

.factory('manageBill', ['$http', function($http) 
{
	return {
		createBill:function(data,callback)
		{
			$http({method: 'POST', url: '/saveBill',params:data})
			.success(callback)
			.error(function(data, status, headers, config) {
		  });
		},
		searchBill:function(data,callback)
		{
			$http({method: 'GET', url: '/bill',params:data})
			.success(callback)
			.error(function(data, status, headers, config) {
		  });
		},
		getBill:function(data,callback)
		{
			$http({method: 'GET', url: '/getBill',params:data})
			.success(callback)
			.error(function(data, status, headers, config) {
		  });
		},
		updateBillDetail:function(data,callback)
		{
			$http({method: 'POST', url: '/updateBillDetail',params:data})
			.success(callback)
			.error(function(data, status, headers, config) {
		  });
		},
		cutBillDetail:function(data,callback)
		{
			$http({method: 'POST', url: '/cutBillDetail',params:data})
			.success(callback)
			.error(function(data, status, headers, config) {
		  });
		}
	};
}])
.factory('manageAdmin', ['$http', function($http) 
{
	return {
		getInterestValue:function(callback)
		{
			$http({method: 'GET', url: '/interest'})
		  .success(callback)
		  .error(function(data, status, headers, config) {
		  });
		},
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
		}
	};
}])

.factory('manageCustomers', ['$http', function($http) 
{
	return {
		addCustomers:function(data,callback)
		{
			$http({method: 'POST', url: '/saveCustomers',params:data})
		  .success(callback)
		  .error(function(data, status, headers, config) {
		  });
		},
		checkCustomersIdCard:function(data,callback)
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