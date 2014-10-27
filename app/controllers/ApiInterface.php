<?php
	/* 
		/saveCustomers : get
		data = {
				'customers_id' : $array['customers_id'],
				'customers_name' : $array['customers_name'],
				'customers_last_name' :$array['customers_last_name'],				
				'customers_address' : $array['customers_address'],
				'customers_sex' : $array['customers_sex'],
				'customers_tel' : $array['customers_tel'],
		}

		/saveAdmin  : get
		data = {
			'admin_id' : $array['admin_id'],
			'admin_name' :  $array['admin_name'],
			'admin_last_name' : $array['admin_last_name'],
			'admin_user' :  $array['admin_user'],
			'admin_password' : $array['admin_password'],
			'admin_sex' : $array['admin_sex'],
			'admin_tel' :  $array['admin_tel'],
			'admin_address' :  $array['admin_address'],
		}

		/checkCustomersId
		data = {
			'customers_id' : $scope.id
		}


		/checkUser : get
		data = {
			'username' : $scope.username
		} or 
		data = {
			'admin_id' : $scope.adminId
		}




		/deleteAdmin   : get
		data = {
			'admin_id' : $scope.admin_id
		}

		/updateAdmin  : get
		data = {
			'admin_id' : $scope.admin_id,
			'admin_password' : ,,
		}



		/saveBill   : get

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


		/updateCustomers  : get
		data = {
					'customers_id' : $array['customers_id'],
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
			key:สิ่งที่จะค้นหา
		}	
		