<?php
	/* 

	-----------------------		Admin	----------------------------------------------
		/interest : get


		/saveAdmin  : get
		data = {
			'admin_id_card' : $array['admin_id_card'],
			'admin_name' :  $array['admin_name'],
			'admin_last_name' : $array['admin_last_name'],
			'admin_user' :  $array['admin_user'],
			'admin_password' : $array['admin_password'],
			'admin_sex' : $array['admin_sex'],
			'admin_tel' :  $array['admin_tel'],
			'admin_address' :  $array['admin_address'],
		}

		/checkUser : get
		data = {
			'username' : $scope.username
		} or 
		data = {
			'admin_id_card' : $scope.adminId_card
		}

		/deleteAdmin   : get
		data = {
			'admin_id' : $scope.admin_id
		}

		/updateAdmin  : get
		data = {
			'admin_id' : $array['admin_id'])
			'admin_id_card'  :$array['admin_id_card'],
			'admin_name' :$array['admin_name'],
			'admin_last_name'  :$array['admin_last_name'],
			'admin_user'  : $array['admin_user'],
			'admin_password'  :$array['admin_password'],
			'admin_sex' : $array['admin_sex'],
			'admin_tel' : $array['admin_tel'],
			'admin_address' : $array['admin_address']
		}

-----------------------		Bill	----------------------------------------------

		/saveBill   : post

		data = {
			customers : {
				'customers_id' : $array['customers_id'],
			},
			bill : {
					'bill_total_price' : $array['bill_total_price'],
					'bill_date_amount' :  $array['bill_date_amount'],
					'bill_price' => : ['bill_price'],
					'bill_type' => : ['bill_type'],
					'bill_price_dow' :  $array['bill_price_dow'],
					'customers_id' : $array['customers_id'],
					'admin_id': $array['admin_id'],
			},
			product : {[
					'product_name' : $product->product_name,
					'product_amount' : $product->product_amount,
					'product_price': $product->product_price,
			]}
		}

-----------------------		Customer	----------------------------------------------

		/updateCustomers  : get
		data = {
					'customers_id' : $array['customers_id'],
					'customers_id_card' => $array['customers_id_card'],
					'customers_name' : $array['customers_name'],
					'customers_last_name' :$array['customers_last_name'],				
					'customers_address' : $array['customers_address'],
					'customers_sex' : $array['customers_sex'],
					'customers_tel' : $array['customers_tel'],
		}

		/deleteCustomers  : get
		data = {
			'customers_id' : $array['customers_id']
		}

		/customers  : get
		data = {
			key:สิ่งที่จะค้นหา,
			perpage:จำนวนข้อมูลแต่ละหน้า,
			page:หน้าที่เท่าไร
		}	
		
		/saveCustomers : get
		data = {
				'customers_id_card' : $array['customers_id_card'],
				'customers_name' : $array['customers_name'],
				'customers_last_name' :$array['customers_last_name'],				
				'customers_address' : $array['customers_address'],
				'customers_sex' : $array['customers_sex'],
				'customers_tel' : $array['customers_tel'],
		}

		/checkCustomersId
		data = {
			'customers_id_card' : $scope.id_card
		}


		------------------- apo หน้า จ่าย งวด----------------------
		
		/** mean searchBill
		/bill  :   get 
		data = {
			key:สิ่งที่จะค้นหา,
			perpage:จำนวนข้อมูลแต่ละหน้า,
			page:หน้าที่เท่าไร
		}
		
		/** mean get all data from Bill
		/getBill  :  get 
		data = {
			bill_code :bill_code
		}
		
		/** mean 
		/updateBillDetail   :  post 		
		data = {
			'bill_detail_id' : $array['bill_detail_id']
			'bill_detail_price' : $array['bill_detail_price']
			'admin_id' : $array['admin_id']
			'bill_total' => $array['bill_total']
		}

		/cutBillDetail   : post
		data = {
			'bill_detail_id' : $array['bill_detail_id']
			'bill_detail_price' : $array['bill_detail_price']
			'admin_id' : $array['admin_id']
			'bill_interest' : $array['bill_interest']
			'bill_date_amount' : $array['bill_date_amount']
			'bill_price' : $array['bill_price']
			'bill_code' : $array['bill_code']
			'bill_total' => $array['bill_total']
		}


		/payOnlyInterest : post
		data = {
			'bill_detail_id' : $array['bill_detail_id']
			'bill_detail_price' : $array['bill_detail_price']
			'admin_id' : $array['admin_id']
			'bill_code' : $array['bill_code']
			'bill_total' => $array['bill_total']
		}

		/timeLineBill
		คลิกครั้งมาเมนู ประวิติบิล ไม่ต้องส่งอะไรมา 
		พอกดเลือกวันให้ส่งว่า
		data = {
			date : '2014-12-24'
		}
		แบบนี้นะ

	
=======
		}
>>>>>>> bill
