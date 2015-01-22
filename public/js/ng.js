angular.module('uncleshopApp')
.controller('uncleshopController', ['$scope','$rootScope','$locale','$timeout','manageAdmin','manageCustomers','manageBill', function($scope,$rootScope,$locale,$timeout,manageAdmin,manageCustomers,manageBill) 
{
	/*----------------------------------------------------------------*/

	var locales = {
		fr: {
	      "DATETIME_FORMATS": {
	        "AMPMS": [
	          "AM",
	          "PM"
	        ],
	        "DAY": [
	          "dimanche",
	          "lundi",
	          "mardi",
	          "mercredi",
	          "jeudi",
	          "vendredi",
	          "samedi"
	        ],
	        "MONTH": [
	          "มกราคม",
	          "กุมภาพันธ์",
	          "มีนาคม",
	          "เมษายน",
	          "พฤษภาคม",
	          "มิถุนายน",
	          "กรกฏาคม",
	          "สิงหาคม",
	          "กันยายน",
	          "ตุลาคม",
	          "พฤศจิกายน",
	          "ธันวาคม"
	        ],
	        "SHORTDAY": [
	          "อาทิตย์",
	          "จันทรื",
	          "อังคาร",
	          "พุธ",
	          "พฤหัสบดี",
	          "ศุกร์",
	          "เสาร์"
	        ],
	        "SHORTMONTH": [
	          "janv.",
	          "f\u00e9vr.",
	          "mars",
	          "avr.",
	          "mai",
	          "juin",
	          "juil.",
	          "ao\u00fbt",
	          "sept.",
	          "oct.",
	          "nov.",
	          "d\u00e9c."
	        ],
	        "fullDate": "EEEE d MMMM y",
	        "longDate": "d MMMM y",
	        "medium": "d MMM y HH:mm:ss",
	        "mediumDate": "d MMM y",
	        "mediumTime": "HH:mm:ss",
	        "short": "dd/MM/yy HH:mm",
	        "shortDate": "dd/MM/yy",
	        "shortTime": "HH:mm"
	      },
	      "NUMBER_FORMATS": {
	        "CURRENCY_SYM": "\u20ac",
	        "DECIMAL_SEP": ",",
	        "GROUP_SEP": "\u00a0",
	        "PATTERNS": [
	          {
	            "gSize": 3,
	            "lgSize": 3,
	            "macFrac": 0,
	            "maxFrac": 3,
	            "minFrac": 0,
	            "minInt": 1,
	            "negPre": "-",
	            "negSuf": "",
	            "posPre": "",
	            "posSuf": ""
	          },
	          {
	            "gSize": 3,
	            "lgSize": 3,
	            "macFrac": 0,
	            "maxFrac": 2,
	            "minFrac": 2,
	            "minInt": 1,
	            "negPre": "(",
	            "negSuf": "\u00a0\u00a4)",
	            "posPre": "",
	            "posSuf": "\u00a0\u00a4"
	          }
	        ]
	      },
	      "id": "fr-fr",
	      "pluralCat": function (n) {
	        if (n >= 0 && n <= 2 && n != 2) {
	          return PLURAL_CATEGORY.ONE;
	        }
	        return PLURAL_CATEGORY.OTHER;
	      }
	    }
	};
	angular.copy(locales['fr'], $locale);
	$scope.open = function () {
	    $timeout(function () {
	      $scope.opened = true;
	    });
	  };


	$scope.al = function () {
		console.log('alert');
	};

  	$scope.today = function() {
   		$scope.dt = new Date();
  	};

  	$scope.clear = function () {
	    $scope.dt = null;
  	};

  	// Disable weekend selection
  	$scope.disabled = function(date, mode) {
	    return null;
	    //return ( mode === 'day' && ( date.getDay() === 0 || date.getDay() === 6 ) );
  	};

  	$scope.toggleMin = function() {
	    $scope.minDate = $scope.minDate ? null : new Date();
  	};

  	$scope.open = function($event) {
	    $event.preventDefault();
	    $event.stopPropagation();

	    $scope.opened = true;
  	};

  	$scope.dateOptions = {
	    formatYear: 'yy',
	    startingDay: 1
  	};

  	$scope.format = 'yyyy-MM-dd';

	/*-----------------------------------------------*/

	$scope.month = ['','มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฏาคม','สิงหาคม','กันยายน','คุลาคม','พฤศจิกายน','ธันวาคม'];
		
	$rootScope.changTab = function(number)
	{
		var text = ['','เพิ่มบิล','ค้นหาบิล','ประวัติบิล', 'ข้อมูลลูกค้า', 'ข้อมูลผู้ขาย']
		$rootScope.tabColor=number;
		$rootScope.loginText=text[number];
		$scope.noResultCustomers = false;
		$scope.noResultBill = false;
		$scope.loadingCustomers = false;

		if(number == 1){
			$scope.backToBill();
			$scope.tabColor = 1;
			//$scope.focusItem('search_focus');
		}
		else if(number == 2){			
			$scope.backToPayBill();
			$scope.tabColor = 2;
		}
		else if(number == 3){
			$scope.dt = new Date();
			$scope.optionSearchHistory = 'bill_detail_pay_date';
			$scope.historyBill(1);
			$scope.tabColor = 3;
		}
		else if(number == 4){
			$scope.backToEditCustomer();
			$scope.tabColor = 4;
			// $scope.getAdmins();
			// $scope.adminToggle = false;
			//$scope.focusItem(null);
		}
		else if(number == 5){
			$scope.getAdmins();
			$scope.adminToggle = false;
			$scope.tabColor = 5;
			//$scope.focusItem(null);
		}
		else
			$scope.focusItem(null);
	};

	
	/////เวลาส่งทำงี้นะ
/*----------------------------  Customer  ---------------------------------*/
	$scope.getOneCustomers = function (value){
		var data = {
			'key': value,
			'perpage': 1,
			'page': 1
		}
		manageCustomers.getCustomers(data,function(data, status, headers, config)
		{
			$scope.DataCustomers = data.data;		
			$scope.addCustomerToBill(0);	
		},500);
	};

	$scope.seachCustomers = function (type)
	{
		$scope.loadingCustomers = true;
		$scope.noResultCustomers = false;
		if(type == 1){
			$scope.page = 1;
			var data = {
				'key':$rootScope.search.data,
				'perpage': 25,
				'page': $scope.page
			}
			manageCustomers.getCustomers(data,function(data, status, headers, config)
			{
				if(data == '' || data.page == 0){
					$scope.noResultCustomers = true;
					$scope.DataCustomers = [];
				}
				else{
					$scope.DataCustomers = data.data;
				}
				
				$scope.loadingCustomers = false;				
					
			},500);
		}

		else{
			var data = {
				'key':$rootScope.search.data,
				'perpage': 25,
				'page': ++$scope.page
			}
			manageCustomers.getCustomers(data,function(data, status, headers, config)
			{			
				if($scope.page <= data.page){
					for(var i=0; i<data.data.length; i++){
						$scope.DataCustomers.push(data.data[i]);
					}					
				}
				$scope.loadingCustomers = false;
			},500);
		}		
	};

	$scope.backToEditCustomer = function () {
		$scope.DataCustomers = [];
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
		$scope.EditCustomerError = ['1','1','1','1'];

		$scope.EditCustomersId = $scope.DataCustomers[index].customers_id;
		$scope.EditCustomersIdCard = $scope.DataCustomers[index].customers_id_card;
		$scope.EditCustomersName = $scope.DataCustomers[index].customers_name;
		$scope.EditCustomersTel = $scope.DataCustomers[index].customers_tel;
		$scope.EditCustomersAddress = $scope.DataCustomers[index].customers_address;
		$scope.EditCustomersSex = $scope.DataCustomers[index].customers_sex;
	};

	$scope.keyCheckEditCustomer = function (){
		if($scope.EditCustomersIdCard.length != 13){
			$scope.EditCustomerError[0] = 'input-error';
		}
		else{
			$scope.EditCustomerError[0] = '1';
		}

		if($scope.EditCustomersName == ''){
			$scope.EditCustomerError[1] = 'input-error';
		}
		else{
			$scope.EditCustomerError[1] = '1';
		}

		if($scope.EditCustomersTel.length != 10){
			$scope.EditCustomerError[2] = 'input-error';
		}
		else{
			$scope.EditCustomerError[2] = '1';
		}

		if($scope.EditCustomersAddress == ''){
			$scope.EditCustomerError[3] = 'input-error';
		}
		else{
			$scope.EditCustomerError[3] = '1';
		}
	};

	$scope.checkCustomerId = function(){
		if($scope.EditCustomersIdCard.length != 13){
			$scope.EditCustomerError[0] = 'input-error';
		}

		else{
			var data = {
				'customers_id_card' : $scope.EditCustomersIdCard
			};
			manageCustomers.checkCustomersIdCard(data,function(data, status, headers, config)
			{
				if(data == 'customers-same'){
					$scope.EditCustomerError[0] = 'input-error';
				}
				else{
					$scope.EditCustomerError[0] = '1';
				}
			});
		}		
	}

	$scope.keyCheckCustomer = function (){
		// if($scope.customersIdCard == ''){
		// 	$scope.customersError[0] = 'input-error';
		// }
		// else{
		// 	$scope.customersError[0] = '1';
		// }

		if($scope.customersName == ''){
			$scope.customersError[1] = 'input-error';
		}
		else{
			$scope.customersError[1] = '1';
		}

		if($scope.customersTel == ''){
			$scope.customersError[2] = 'input-error';
		}
		else{
			$scope.customersError[2] = '1';
		}

		if($scope.customersAddress == ''){
			$scope.customersError[3] = 'input-error';
		}
		else{
			$scope.customersError[3] = '1';
		}
	};

	$scope.updateCustomer = function (){
		var text = '';
		if($scope.EditCustomerError[0].length > 1)
			text += ' รหัสบัตรประชาชน ';			

		if($scope.EditCustomerError[1].length > 1)
			text += ' ชื่อลูกค้า ';
			
		if($scope.EditCustomerError[2].length > 1)
			text += ' เบอร์โทรศัพท์ ';
			
		if($scope.EditCustomerError[3].length > 1)
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
			swal({   
				title: "แก้ไขข้อมูลลูกค้า ?",   
				text: "คุณต้องการแก้ไขข้อมูลลูกค้าใช่หรือไม่",   
				type: "warning",   
				showCancelButton: true,   
				confirmButtonColor: "#DD6B55",   
				confirmButtonText: "ใช่, แก้ไข !",   
				cancelButtonText: "ยกเลิก",
				closeOnConfirm: false 
			}, function(){
				swal({
				   title: "",   
				   text: "",   
				   imageUrl: "img/hourglass.gif",
				   closeOnConfirm: false,
			       confirmButtonText: "รอซักครู่"
				});
				if($scope.customersError[0] == 'input-error'){
					swal({
						title: "ไม่สำเร็จ !!",   
						text: "เลขบัตรประชาชนนี้มีอยู่ในระบบแล้ว",   
						type: "error",
						timer: 2000
					});
				}
				else{
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
			swal({
			   title: "",   
			   text: "",   
			   imageUrl: "img/hourglass.gif",
			   closeOnConfirm: false,
			   confirmButtonText: "รอซักครู่"
			});
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
					$scope.backToEditCustomer();
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
		$scope.disabledInput = false;
		$scope.setBillDefault();

		// $scope.customersIdCard = null;
		// $scope.customersName = null;
		// $scope.customersTel = null;
		// $scope.customersAddress = null;
	};

	$scope.backToEditBill = function() {
		$scope.editBill($scope.billCode); 
		$scope.edited=false; 
		$scope.tabColor=2.1;
		$scope.DataCustomer_toggle = false;
		$scope.addProduct_toggle = true;

		$scope.priceDowError = '';
		$scope.interestError = '';
		$scope.timeOfPaymentError = '';
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
		$scope.dataEditBill = [];
		$scope.dataEditBill.customer = $scope.DataCustomers[index];
		$scope.DataCustomer_toggle = false;
		$scope.addProduct_toggle = true;
	};

	$scope.historyBill = function(value) { // วันนี้ลูกค้าคนใดต้องมาจ่ายบ้าง ?

		$scope.loadingBill = true;
		$scope.noResultBill = false;

		if(value == 1 && $scope.dt != undefined){
			var y = $scope.dt.getFullYear();
			var m = $scope.dt.getMonth();
				m += 1;
			var d = $scope.dt.getDate();
			if(m <= 9)
				m = '0'+m;
			if(d <= 9)
				d = '0'+d;

			$scope.histPage = 1;

			var data = {
				date: y + '-' + m + '-' + d,
				// data: '2015-01-07',
				perpage: 25,
				page: $scope.histPage,
				column: $scope.optionSearchHistory
			};
			manageBill.timeLineBill(data,function(data, status, headers, config){
				if(data == '' || data.page == 0){
					$scope.noResultBill = true;
					$scope.timeline = [];
				}

				$scope.loadingBill = false;
				$scope.timeline = data;
			},500);
		}	

		else if(value == 2){
			var y = $scope.dt.getFullYear();
			var m = $scope.dt.getMonth();
				m += 1;
			var d = $scope.dt.getDate();
			if(m <= 9)
				m = '0'+m;
			if(d <= 9)
				d = '0'+d;

			var data = {
				data: y + '-' + m + '-' + d,
				// data: '2015-01-07',
				perpage: 25,
				page: ++$scope.histPage,
				column: $scope.optionSearchHistory
			};
			manageBill.timeLineBill(data,function(data, status, headers, config){
				if($scope.histPage <= data.page){
					for(var i=0; i<data.data.length; i++){
						$scope.timeline.data.push(data.data[i]);
					}
				}
				$scope.loadingBill = false;				
			},500);
		}

	};

	$scope.removeBill = function(index) {		
		var data = {
			'bill_code' : index
		};

		swal({   
			title: "ลบข้อมูลทั้งหมดของบิลนี้ ?",   
			text: "ลบข้อมูลบิลของคุณ " + $scope.DataPayBill.customer.customers_name + " ใช่หรือไม่ ?",   
			type: "warning",   
			showCancelButton: true,   
			confirmButtonColor: "#2980B9",   
			confirmButtonText: "ใช่, ลบเดี๋ยวนี้ !",   
			cancelButtonText: "ยกเลิก",
			closeOnConfirm: false 
		}, function(){
			swal({
			   title: "",   
			   text: "",   
			   imageUrl: "img/hourglass.gif",
			   closeOnConfirm: false,
			   confirmButtonText: "รอซักครู่"
			});
			manageBill.deleteBill(data,function(data, status, headers, config){
				if(data == 1){
					swal({
						title: "เรียบร้อย !!",   
						text: "ลบข้อมูลบิลเรียบร้อยแล้ว",   
						type: "success",
						timer: 1500
					});
					$scope.backToPayBill();					
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

	$scope.onlyInterest = function() { // จ่ายเฉพาะดอกเบี้ย
		var detail_index = null;
		for(var i = 0;i<$scope.DataPayBill.dateBill.length;i++){
			if($scope.DataPayBill.dateBill[i].bill_detail_status == 99 || $scope.DataPayBill.dateBill[i].bill_detail_status == 3){
				detail_index = i;
			}
		}
		var data = {
			'bill_detail_id' : $scope.DataPayBill.dateBill[detail_index].bill_detail_id,
			'bill_detail_price' : $scope.DataPayBill.bill.bill_interest_to_mount,
			'admin_id' : $rootScope.admin.admin_id,
			'bill_code' : $scope.DataPayBill.bill.bill_code
		};

		swal({   
			title: "ชำระเงินเฉพาะดอกเบี้ย ?",   
			text: "คุณต้องการชำระเงินดอกเบี้ยประจำวันที่ " + $scope.DataPayBill.dateBill[detail_index].bill_detail_date + " เป็นจำนวนเงิน " + data.bill_detail_price + " บาท ใช่หรือไม่",   
			type: "warning",   
			showCancelButton: true,   
			confirmButtonColor: "#2980B9",   
			confirmButtonText: "ใช่, ชำระเงินเดี๋ยวนี้ !",   
			cancelButtonText: "ยกเลิก",
			closeOnConfirm: false 
		}, function(){
			swal({
			   title: "",   
			   text: "",   
			   imageUrl: "img/hourglass.gif",
			   closeOnConfirm: false,
			   confirmButtonText: "รอซักครู่"
			});

			manageBill.payOnlyInterest(data,function(data, status, headers, config){
				if(data == 1){
					swal({
						title: "เรียบร้อย !!",   
						text: "ชำระเงินเฉพาะดอกเบี้ยเรียบร้อยแล้ว",   
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

	$scope.cutBill = function() { //ตัดบิล
		var detail_index = 0;
		var detail_term = 0;
		for(var i = 0;i<$scope.DataPayBill.dateBill.length;i++){
			if($scope.DataPayBill.dateBill[i].bill_detail_status == 99){
				detail_index = i;
			}
			if($scope.DataPayBill.dateBill[i].bill_detail_status == 0){
				detail_term++;
			}
		}
		detail_term++;
		var detail_price = $scope.DataPayBill.bill.bill_installments_price*detail_term;
		detail_price = detail_price - ($scope.DataPayBill.bill.bill_interest * (detail_term-1));

		var data = {
			'bill_detail_id' : $scope.DataPayBill.dateBill[detail_index].bill_detail_id,
			'bill_detail_price' : detail_price,
			'admin_id' : $rootScope.admin.admin_id,
			'bill_code' : $scope.DataPayBill.bill.bill_code
		};

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
			swal({
			   title: "",   
			   text: "",   
			   imageUrl: "img/hourglass.gif",
			   closeOnConfirm: false,
			   confirmButtonText: "รอซักครู่"
			});

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
				swal({
				   title: "",   
				   text: "",   
				   imageUrl: "img/hourglass.gif",
				   closeOnConfirm: false,
			   	   confirmButtonText: "รอซักครู่"
				});
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
		else if($scope.DataPayBill.dateBill[index].bill_detail_status != 0 || $scope.DataPayBill.dateBill[index].bill_detail_status != 99){
			if($scope.DataPayBill.dateBill[index].admin_id != null){
				var type = '';
				if($scope.DataPayBill.dateBill[index].bill_detail_status == 1)
					type = ' (แบบปกติ)';
				else if($scope.DataPayBill.dateBill[index].bill_detail_status == 3)
					type = ' (แบบเฉพาะดอกเบี้ย)';
				else if($scope.DataPayBill.dateBill[index].bill_detail_status == 2)
					type = ' (แบบตัดบิล)';

				swal({
					title: "คุณ " + $scope.DataPayBill.dateBill[index].admin_name.admin_name + " เป็นผู้รับการชำระเงิน"+type,   
					text: "ประจำวันที่ " + $scope.DataPayBill.dateBill[index].bill_detail_date + " เป็นจำนวนเงิน "+ $scope.DataPayBill.dateBill[index].bill_detail_price,   
				});
			}
		}		
	};

	$scope.switchToPayBillTab = function(value) {
		$scope.changTab(2);
		$scope.backToPayBill();
		$scope.payBill(value);
	};

	$scope.payBill = function(value) {
		var data = {
			'bill_code': value
		};
		$scope.billCode = value;
		manageBill.getBill(data,function(data, status, headers, config){
			$scope.DataPayBill = data;				 
			if($scope.DataPayBill.bill.bill_status == 0){
				var length = $scope.DataPayBill.dateBill.length;

				for(var i=0; i<length; i++){ // -1 or don't
					if($scope.DataPayBill.dateBill[i].bill_detail_status == 0){
						$scope.DataPayBill.dateBill[i].bill_detail_status = 99; // 99 คือ รอจ่ายเงิน
						i = length;
					}				
				}				

				if($scope.DataPayBill.dateBill[length-1].bill_detail_status != 0){
					$scope.cutBill_toggle = false;
				}
				else
					$scope.cutBill_toggle = true;
			}
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
				}
				else {
					for(var i=0; i<length; i++){ // -1 or don't
						if($scope.DataPayBill.dateBill[i].bill_detail_status == 0){
							$scope.DataPayBill.dateBill[i].bill_detail_status = 99; // 99 คือ รอจ่ายเงิน
							i = length;
						}				

					}
				}				

				if($scope.DataPayBill.dateBill[length-1].bill_detail_status != 0){
					$scope.cutBill_toggle = false;
				}
				else
					$scope.cutBill_toggle = true;
			}
			
			$scope.findPayBill_toggle = false;
		},500);
	};

	$scope.calBill = function(value) {

		if(value == 'priceDow')
			$scope.priceDowError = ' ';
		if(value == 'timeOfPayment')
			$scope.timeOfPaymentError = ' ';
		if(value == 'interest')
			$scope.interestError = ' ';

		var priceOfAllProduct = 0;
		$scope.billData = [];

		for(var i = 0; i<$scope.productData.length; i++){
			priceOfAllProduct +=  $scope.productData[i].productPrice * $scope.productData[i].productAmount;
		}
		
			if($scope.priceDow == null)
				$scope.priceDow = 0;
			if($scope.timeOfPayment == null)
				$scope.timeOfPayment = 1;
			if($scope.interest == null)
				$scope.interest = 0;

				$scope.billData = {
					'priceOfAllProduct': priceOfAllProduct,//ราคาสินค้าทั้งหมด
					'interestValue':  $scope.interest*$scope.timeOfPayment,//ดอกเบี้ย
					'priceDow': $scope.priceDow, //เงินดาว
					'timeOfPayment': $scope.timeOfPayment, //เวลาในการผ่อน
					'priceWithoutDow': $scope.priceWithoutDow = (priceOfAllProduct+($scope.interest*$scope.timeOfPayment)) - $scope.priceDow,//ราคารวมดอกเบี้ยและหักเงินดาวน์
					'priceTermOfPayment': $scope.priceWithoutDow / $scope.timeOfPayment //ราคาต่องวด
				};


	};

	$scope.editBill = function(billCode) {
		var data = {
			'bill_code': billCode
		};
		manageBill.getBill(data,function(data, status, headers, config){
			$scope.dataEditBill = data;
			$scope.productData = [];
			// $scope.DataCustomersOfBill = data.customer; //customers
			for(var i=0; i<data.product.length; i++){ //product
				$scope.productData.push({
					'productName':data.product[i].product_name,
					'productPrice':parseInt(data.product[i].product_price),
					'productAmount':data.product[i].product_amount
				});
			}
			for(var i=0; i<$scope.productData.length; i++){ //product2
				$scope.productData[i].product_price = parseInt($scope.productData[i].productPrice);
			}

			$scope.dataEditBill.bill.bill_price_dow = parseInt($scope.dataEditBill.bill.bill_price_dow);
			$scope.dataEditBill.bill.bill_interest = parseInt($scope.dataEditBill.bill.bill_interest);
			
			$scope.priceDow = data.bill.bill_price_dow;
			$scope.interest = data.bill.bill_interest;
			$scope.timeOfPayment = data.bill.bill_date_amount;
			$scope.type_dow = data.bill.bill_type;
			$scope.calBill();
		},500);
	};

	$scope.editBillFinish = function(billCode) {
		var count = true;
		angular.forEach($scope.productData, function(products) {
			if(products.product_name == '')
			{
				count = false;
				products.productNameError = 'input-error';
			}
			if( products.product_price == '' )
			{
				count = false;
				products.productPriceError = 'input-error';
			}
			if(products.product_amount == '')
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
			if($scope.interest == null || $scope.interest.length == 0){
				$scope.interestError = 'input-error';
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
		
		if($scope.dataEditBill == null && count != false){
			count = false;
			swal({
				title: "ไม่สำเร็จ !!",   
				text: "กรุณาเพิ่มข้อมูลลูกค้าก่อน",   
				type: "error",
				timer: 2000
			});
		}

		var payed_count = 0;
		for(var i=0; i<$scope.dataEditBill.dateBill.length; i++){
			if($scope.dataEditBill.dateBill[i].bill_detail_status != 0){
				payed_count++;
			}
		}
		if($scope.timeOfPayment <= payed_count){
			count = false;
			swal({
				title: "ไม่สำเร็จ !!",   
				text: "บิลนี้ชำระไปแล้ว " + payed_count + " ครั้ง จึงไม่สามารถแก้ไขจำนวนเวลา ให้ต่ำกว่าหรือเท่ากับได้",   
				type: "error",
				timer: 10000
			});
		}			

		if(count != false){
			var products = [];
			for(var i=0; i<$scope.productData.length; i++){
				products.push({
					product_name: $scope.productData[i].product_name, 
					product_price: $scope.productData[i].product_price, 
					product_amount: $scope.productData[i].product_amount
				});
			}
			var product = [];
			for(var i=0; i<products.length; i++){
				product.push(products[i]);
			}
			
			swal({   
				title: "แก้ไขข้อมูลบิล ?",   
				text: "คุณต้องการแก้ไขข้อมูลบิลใช่หรือไม่",   
				type: "warning",   
				showCancelButton: true,   
				confirmButtonColor: "#DD6B55",   
				confirmButtonText: "ใช่, แก้ไข !",   
				cancelButtonText: "ยกเลิก",
				closeOnConfirm: false 
			}, function(){
				swal({
				   title: "",   
				   text: "",   
				   imageUrl: "img/hourglass.gif",
				   closeOnConfirm: false,
				   confirmButtonText: "รอซักครู่"

				});
				var data = {
					'bill_code': billCode,
					'bill_price' : $scope.billData.priceOfAllProduct, // ราคาสินค้าทั้งหมด
					'bill_date_amount' : $scope.timeOfPayment, // จำนวนงวด
					'bill_interest' : $scope.interest,
					'bill_type' : $scope.type_dow, //ชนิการผ่อน
					'bill_price_dow' : $scope.priceDow, //ราคาเงินดาวน์
					'admin_id' : $rootScope.admin.admin_id,
					'customers_id' : $scope.dataEditBill.customer.customers_id,
					'product' : $scope.productData
				};		

				data = {
					data:JSON.stringify(data)
				};

				manageBill.updateBill(data,function(data, status, headers, config){
					if(data == 1){
						swal({
							title: "เรียบร้อย !!",   
							text: "แก้ไขข้อมูลบิลเรียบร้อยแล้ว",   
							type: "success",
							timer: 1500
						});
						$scope.switchToPayBillTab(billCode);
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
		$scope.DataCustomers = [];
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

	$scope.addCustomers = function(value) {		
		if($scope.customersIdCard.length == 13 && $scope.customersName != '' && $scope.customersTel.length == 10 && $scope.customersAddress != '')	{
			data = {
				'customers_id_card' : $scope.customersIdCard
			};
			
			manageCustomers.checkCustomersIdCard(data,function(data, status, headers, config)
				{
					if(data == 'customers-same'){
						swal({
							title: "ไม่สำเร็จ !!",   
							text: "เลขบัตรประชาชนนี้มีอยู่ในระบบแล้ว",   
							type: "error",
							timer: 2000
						});
						$scope.customersError[0] = 'input-error';
					}
					else{

						data = {
							'customers_id_card' : $scope.customersIdCard,
							'customers_name' :  $scope.customersName,
							'customers_address' :  $scope.customersAddress,
							'customers_sex' : $scope.customersSex,
							'customers_tel' : $scope.customersTel
						};

						manageCustomers.addCustomers(data,function(data, status, headers, config) {
							if(data != 'error'){
								swal({
									title: "เรียบร้อย !!",   
									text: "เพิ่มข้อมูลลูกค้าแล้ว",   
									type: "success",
									timer: 1500
								});
								if(value == 1){
									$scope.getOneCustomers($scope.customersIdCard);									
								}
								else
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
			var text = '';
			if($scope.customersIdCard.length != 13){
				$scope.customersError[0] = 'input-error';
				text += ' รหัสบัตรประชาชน ';
			}
			else
				$scope.customersError[0] = '';

			if($scope.customersName == ''){
				$scope.customersError[1] = 'input-error';
				text += ' ชื่อลูกค้า ';
			}
			else
				$scope.customersError[1] = '';

			if($scope.customersTel.length != 10){
				$scope.customersError[2] = 'input-error';
				text += ' เบอร์โทรศัพท์ ';
			}
			else
				$scope.customersError[2] = '';

			if($scope.customersAddress == ''){
				$scope.customersError[3] = 'input-error';
				text += ' ที่อยู่ ';
			}
			else
				$scope.customersError[3] = '';

			if(text.length > 0){
				swal({
					title: "ไม่สำเร็จ !!",   
					text: "กรุณาตรวจสอบ" + text + 'อีกครั้ง',   
					type: "error",
					timer: 2000
				});
			}
		}
	};

	$scope.check_CustomersIdCard = function() {
		if($scope.customersIdCard.length == 13){
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
			},500);
		}
		else {
			$scope.customersError[0] = '';
		}
	};

	/*---------------------------- Bill-->Customers  ---------------------------------*/
	$scope.searchBillForPay = function(value) {
		$scope.loadingBill = true;
		$scope.noResultBill = false;

		if(value == 1){
			$scope.pageSearchBillForpay = 1;
			var data = {
				'key': $rootScope.searchBill.data,
				'status': $scope.optionSearchPayBill,
				'perpage': 25,
				'page': $scope.pageSearchBillForpay
			}
			manageBill.searchBill(data,function(data, status, headers, config)
			{
				if(data == '' || data.page == 0){
					$scope.noResultBill = true;
				}

				$rootScope.DataBill = data.data;
				$scope.loadingBill = false;
			}, 500);
		}

		else {
			var data = {
				'key': $rootScope.searchBill.data,
				'status': $scope.optionSearchPayBill,
				'perpage': 25,
				'page': ++$scope.pageSearchBillForpay
			}
			manageBill.searchBill(data,function(data, status, headers, config)
			{
				if($scope.pageSearchBillForpay <= data.page){
					for(var i=0; i<data.data.length; i++){
						$rootScope.DataBill.push(data.data[i]);
					}
				}
				$scope.loadingBill = false;
			}, 500);
		}		
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
		$scope.adminError = ['','','','',''];
		manageAdmin.getAdmin(function(data, status, headers, config)
		{
			$scope.admins = data;
		},500);

	};

	$scope.register = function(value)
	{
		$scope.checkAdminPassword();
		// if($scope.adminIdCard.length == 13)
		if($scope.adminIdCard != '' && $scope.adminIdCard.length == 13 && $scope.adminTel.length == 10 && $scope.adminUserName != '' && $scope.adminPassword !='')
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
				swal({
				   title: "",   
				   text: "",   
				   imageUrl: "img/hourglass.gif",
				   closeOnConfirm: false,
				   confirmButtonText: "รอซักครู่"
				});
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
				swal({   
					title: "แก้ไขข้อมูลผู้ขาย ?",   
					text: "คุณต้องการแก้ไขข้อมูลผู้ขายใช่หรือไม่",   
					type: "warning",   
					showCancelButton: true,   
					confirmButtonColor: "#DD6B55",   
					confirmButtonText: "ใช่, แก้ไข !",   
					cancelButtonText: "ยกเลิก",
					closeOnConfirm: false 
				}, function(){
					swal({
					   title: "",   
					   text: "",   
					   imageUrl: "img/hourglass.gif",
					   closeOnConfirm: false,
				       confirmButtonText: "รอซักครู่"
					});
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
				});
			}
		}
		else
		{
			var text = '';
			if($scope.adminIdCard.length != 13){
				$scope.adminError[0] = 'input-error';
				text += ' รหัสบัตรประชาชน ';
			}
			if($scope.adminUserName == ''){
				$scope.adminError[1] = 'input-error';
				text += ' Username ';
			}
			if($scope.adminPassword == ''){
				$scope.adminError[2] = 'input-error';
				text += ' Password ';
			}
			if($scope.adminName == ''){
				$scope.adminError[3] = 'input-error';
				text += ' ชื่อ ';
			}
			if($scope.adminTel == ''){
				$scope.adminError[4] = 'input-error';
				text += ' เบอร์โทรศัพท์ ';
			}
			if($scope.adminAddress == ''){
				$scope.adminError[5] = 'input-error';
				text += ' ที่อยู่ ';
			}

			if(text.length > 0){
				swal({
					title: "ไม่สำเร็จ !!",   
					text: "กรุณาตรวจสอบ" + text + 'อีกครั้ง',   
					type: "error",
					timer: 2000
				});
			}
		}
	};

	$scope.keyCheckAdmin = function(){
		if($scope.adminName == '')
			$scope.adminError[3] = 'input-error';
		else
			$scope.adminError[3] = '';

		if($scope.adminTel == '')
			$scope.adminError[4] = 'input-error';
		else
			$scope.adminError[4] = '';

		if($scope.adminAddress == '')
			$scope.adminError[5] = 'input-error';
		else
			$scope.adminError[5] = '';
	};

	$scope.checkAdminId = function(){
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
			swal({
			   title: "",   
			   text: "",   
			   imageUrl: "img/hourglass.gif",
			   closeOnConfirm: false,
			   confirmButtonText: "รอซักครู่"
			});

			manageAdmin.deleteAdmin(data,function(data, status, headers, config)
			{				
				if(data == '1'){ //delete success = 1
					swal({
						title: "เรียบร้อย !!",   
						text: "ข้อมูลผู้ขายถูกลบแล้ว",   
						type: "success",
						timer: 1500
					});
					$scope.getAdmins();
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
			});
		});
	};

	/*when init*/
	$scope.init = function() {
		$scope.changTab(1);
		$scope.today();
		$scope.adminDefault();
		$scope.customersDefault();
		$scope.productDefault();
		$scope.EditCustomerError = ['1','1','1','1'];
		// $rootScope.isLoading = true;
	};

	/*----------------------------  prodcut---------------------------------*/
	$scope.setBillDefault = function() {
		$scope.productDefault();
		$scope.billData = [];
		$scope.DataCustomersOfBill = null;
		$scope.priceDow = null;
		$scope.interest = null;
		$scope.timeOfPayment = null;
		$scope.dataEditBill = null;
		$scope.type_dow = 0;

		$scope.priceDowError = '';
		$scope.interestError = '';
		$scope.timeOfPaymentError = '';
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
			'productAmount':''
		});
		$scope.countProduct = $scope.productData.length;
	};
	$scope.minusProduct = function(index) {
		$scope.productData.splice(index,1);
		$scope.calBill();
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
		
			if(products.productName  == '')
			{
				count = false;
				products.productNameError = 'input-error';
			}
			if( products.productPrice  == '' )
			{
				count = false;
				products.productPriceError = 'input-error';
			}
			if(products.productAmount  == '')
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
			if($scope.interest == null || $scope.interest.length == 0){
				$scope.interestError = 'input-error';
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
		if($scope.billData.priceTermOfPayment <= 0){ //ถ้าราคาผ่อนส่งติดลบ
			count = false;
			swal({
				title: "ไม่สำเร็จ !!",   
				text: "ราคาผ่อนชำระไม่สามารถติดลบหรือเท่ากับ 0 ได้",   
				type: "error",
				timer: 2000
			});
		}
		if(count)
		{			
			swal({
			   title: "",   
			   text: "",   
			   imageUrl: "img/hourglass.gif",
			   closeOnConfirm: false ,
			   confirmButtonText: "รอซักครู่"
			});

			var data = {
				'bill_price' : $scope.billData.priceOfAllProduct, // ราคาสินค้าทั้งหมด
				'bill_date_amount' : $scope.timeOfPayment, // จำนวนงวด
				// 'bill_interest' : $scope.billData.interestValue, 
				'bill_interest' : $scope.interest,
				'bill_type' : $scope.type_dow, //ชนิการผ่อน
				'bill_price_dow' : $scope.priceDow, //ราคาเงินดาวน์
				'customers_id_card' : $scope.DataCustomersOfBill.customers_id_card,
				'bill_installments_price' : $scope.billData.priceTermOfPayment,
				'bill_pay_price' : $scope.billData.priceWithoutDow,
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
					$scope.disabledInput = true;
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
		deleteBill:function(data,callback)
		{
			$http({method: 'GET', url: '/deleteBill',params:data})
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
		updateBill:function(data,callback)
		{
			$http({method: 'POST', url: '/updateBill',params:data})
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
		},
		payOnlyInterest:function(data,callback)
		{
			$http({method: 'POST', url: '/payOnlyInterest',params:data})
			.success(callback)
			.error(function(data, status, headers, config) {
		  });
		},
		timeLineBill:function(data,callback)
		{
			$http({method: 'GET', url: '/timeLineBill',params:data})
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