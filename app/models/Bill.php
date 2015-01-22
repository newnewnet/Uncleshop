<?php 
	class Bill extends Eloquent
	{
		protected $table = 'bill';
		protected $guarded = array();
		public $timestamps = false;
		protected $primaryKey = 'bill_code';

		public function insertBill($array)
		{
			$product = new Product;
			$billDeatail = new BillDetail;
			$customers = new Customers;
		
			$billCode = $this->randomBill();

			$data = json_decode($array['data']);

			$startDate = date('Y-m-d');
			$day = 30;
		
			if($data->bill_type == 1)
			{
				$day = 15;
			}

			$day1 = $day * $data->bill_date_amount;
			$endDate = time() + ($day1 * 24 * 60 * 60);
			$endDate  = date('Y-m-d',$endDate );

			$customersId = $customers->where('customers_id_card','=',$data->customers_id_card)
									->select('customers_id')->first();

			$this->insert([
					'bill_code' => $billCode ,
					'bill_start_date' => date('Y-m-d'),
					'bill_end_date' => $endDate,
					'bill_interest' => $data->bill_interest,
					'bill_date_amount' => $data->bill_date_amount,
					'bill_status' => 0,
					'bill_price' => $data->bill_price,
					'bill_type' => $data->bill_type,
					'bill_price_dow' => $data->bill_price_dow,
					'customers_id' => $customersId->customers_id,
					'bill_create_time' => date('Y-m-d H:i:s'),
					'bill_total' => $data->bill_price_dow,
					'bill_installments_price' => $data->bill_installments_price,
					'bill_pay_price' => $data->bill_pay_price,
					'admin_id' => $data->admin_id
			]);

			for($i=0;$i<count($data->product);$i++)
			{

				$product->insert([
						'product_name' => $data->product[$i]->productName,
						'product_amount' => $data->product[$i]->productAmount,
						'product_price' => $data->product[$i]->productPrice,
						'bill_code' => $billCode
				]);
			}

			for($i=0 ;$i<$data->bill_date_amount;$i++)
			{		
				$startDate= strtotime($startDate) + ($day* 24 * 60 * 60);
				$startDate = date('Y-m-d',$startDate);	
				$billDeatail->insert([
						'bill_detail_date' => $startDate,
						'bill_detail_status' => 0,
						'bill_code' => $billCode
				]);
			}

			return $billCode;


		}
		public function getBill($billCode)
		{
			$product = new Product;
			$customer = new Customers;
			$admin = new Admin;
			$billDeatail = new BillDetail;

			$billData = $this->where('bill_code','=',$billCode)->first();
			$productData = $product->where('bill_code','=',$billCode)->get();
			$customerData =  $customer->where('customers_id','=',$billData->customers_id)->first();
			$adminData = $admin->where('admin_id','=',$billData->admin_id)->select('admin_name')->first();
			$billDetailData = $billDeatail->where('bill_code','=',$billCode)->select('bill_detail_id','bill_detail_date','bill_detail_status','admin_id','bill_detail_price')->get();

			$billData->bill_start_date = strtotime($billData->bill_start_date);
			$billData->bill_start_date = date('d-m-Y',$billData->bill_start_date);

			$billData->bill_start_date = $this->dateToFormatThai($billData->bill_start_date);
			
			for($i=0;$i<count($billDetailData);$i++)
			{
				if($billDetailData[$i]->admin_id != null)
				{
					$billDetailData[$i]->admin_name = $admin->where('admin_id','=',$billDetailData[$i]->admin_id)->select('admin_name')->first();
				}
			
				$billDetailData[$i]->bill_detail_date = $this->dateToFormatThai($billDetailData[$i]->bill_detail_date);
			}

		
			$billData['bill_total_price'] = $billData->bill_price+($billData->bill_interest*$billData->bill_date_amount);
			// $billData['bill_installments_price'] = ceil((($billData->bill_price+($billData->bill_interest*$billData->bill_date_amount))-$billData->bill_price_dow)/$billData->bill_date_amount);
			// $billData['bill_pay_price'] = (($billData->bill_price+($billData->bill_interest*$billData->bill_date_amount))-$billData->bill_price_dow);
			$billData['bill_interest_to_mount'] = (($billData->bill_interest*$billData->bill_date_amount)/$billData->bill_date_amount);
			$count = 0;
			
	
			$result['bill'] = $billData;
			$result['product'] = $productData;
			$result['customer'] = $customerData;
			$result['admin'] = $adminData;
			$result['dateBill'] = $billDetailData;

			return $result;
		}
		private function daysInMonth($month, $year)
		{
			return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
		}
		private function dateToFormatThai($date)
		{
				$monthFull = ['','มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'];
				$date = strtotime($date);
				$day = date('d',$date);
				$month = (int)date('m',$date);
				$year = date('Y',$date);
				return $day.' '.$monthFull[$month].' '.$year;
		}
		private function randomBill()
		{
			$month = date('m');
			$year = date('y');
			$billCode = '';
			$characters = '0123456789';
    	$randomString = '';
    	for ($i = 0; $i < 7; $i++) {
        	$randomString .= $characters[rand(0, strlen($characters) - 1)];
    	}

    	$billCode = "B".$month.$year.$randomString;

 			$duplicate=true;

			while($duplicate==true)
			{

				$result_random = $this->where('bill_code','=',$billCode)->get();

				if($result_random == '[]')
				{
					$duplicate=false;
				}
				else
				{
					$characters = '0123456789';
				  	$randomString = '';
				  	for ($i = 0; $i < 7; $i++) {
			        	$randomString .= $characters[rand(0, strlen($characters) - 1)];
			    	}
			    	$billCode = "B".$month.$year.$randomString;
				}
			}

			return $billCode;

		}


		public function searchBill($param,$key,$status)
		{
			$result = '';

			$customers =  new Customers;
			$product = new Product;
			if(!empty($key))
			{
				$result = $this->join('customers', 'customers.customers_id', '=', 'bill.customers_id')			
									->orWhere('customers.customers_id_card', 'LIKE', "%".$key."%")
									->orWhere('customers.customers_name', 'LIKE', "%".$key."%")							
									->orWhere('customers.customers_tel', 'LIKE', "%".$key."%")
									->orWhere('bill.bill_code', 'LIKE', "%".$key."%")
									->select('bill.bill_status','bill.bill_code','customers.customers_name','customers.customers_tel','customers.customers_id_card','customers.customers_sex');
				// $result =  DB::select(DB::raw("select bill_status,bill.bill_code,customers.customers_name,customers.customers_tel,customers.customers_id_card,customers.customers_sex FROM bill INNER JOIN customers ON bill.customers_id=customers.customers_id WHERE customers.customers_id_card  LIKE '%".$key."%'  or  customers.customers_name  LIKE '%".$key."%'  or  customers.customers_tel  LIKE '%".$key."% ' or  bill.bill_code  LIKE  '%".$key."%'"));
				$perPage = $param['perpage'];
				$skip = ($param['page'] - 1) * $perPage;
				$page = ceil($result->count() / $perPage);

				$result = $result->skip($skip)->take($perPage)->get();

				if($status == 0)
				{
					$index = 0;
					$data = array();
					for($i=0;$i<count($result);$i++)
					{
						if($result[$i]->bill_status == 0)
						{
							$data[$index] = $result[$i];
							$index++;
						}

					}
					$result = $data;
				}
				else if ($status == 1) 
				{
					$index = 0;
					$data = array();
					for($i=0;$i<count($result);$i++)
					{
						if($result[$i]->bill_status > 0 )
						{
							$data[$index] = $result[$i];
							$index++;
						}

					}
					
					$result = $data;
				}

				if($result != "[]")
				{
					for($i=0;$i<count($result);$i++)
					{
						$productData = $product->where('bill_code','=',$result[$i]->bill_code)
										->orderBy('product_price', 'desc')
	                  ->select('product_name','product_price','product_amount')
	                  ->first();

	        	$result[$i]->product = $productData;

					}
				}

				return [
					'page' => $page,
					'data' => $result
				];
			}

			
		}
		public function deleteBill($billCode)
		{
			$result = $this->where('bill_code', '=', $billCode)->delete();
			
			DB::table('bill_detail')->where('bill_code', '=', $billCode)->delete();
			DB::table('product')->where('bill_code', '=', $billCode)->delete();
			
			return $result;
		}
		public function updateBill($array)
		{
			
			$product = new Product;
			$billDeatail = new BillDetail;
			$customers = new Customers;
			
			$data = json_decode($array['data']);
			$billData = $this->where('bill_code', '=', $data->bill_code)->first();
			$billDatailStatus = DB::table('bill_detail')
									->where('bill_code', '=', $data->bill_code)
									->where('bill_detail_status', '>', 0)
									->get();
			$countbillDatailStatus = count($billDatailStatus);

			$count = DB::table('bill_detail')
									->where('bill_code', '=', $data->bill_code)
									->where('bill_detail_status', '=', 1)
									->count();

		
			$totalBillDetail = 0;
			for($i=0;$i<count($billDatailStatus);$i++)
			{
				if($billDatailStatus[$i]->bill_detail_price != null &&  $billDatailStatus[$i]->bill_detail_status == 1)
				{
					$totalBillDetail+=$billDatailStatus[$i]->bill_detail_price;
					
				}
				else if($billDatailStatus[$i]->bill_detail_price == null)
				{
					$count++;
				}

			}

			$bill_pay_price = (($data->bill_price+($data->bill_interest*$data->bill_date_amount))-$data->bill_price_dow);
			$bill_pay_price1 = (($data->bill_price+($data->bill_interest*$data->bill_date_amount))-$data->bill_price_dow)-$totalBillDetail;

			$bill_installments_price = ($bill_pay_price1/($data->bill_date_amount-$count));

				

			DB::table('bill_detail')->where('bill_code', '=', $data->bill_code)->delete();
			DB::table('product')->where('bill_code', '=', $data->bill_code)->delete();
			$startDate = $billData->bill_start_date;
			$day = 30;

			if($data->bill_type == 1)
			{
				$day = 15;
			}
			$day1 = $day * ($data->bill_date_amount+$billData->bill_pay_only_lnterest_amount);
			$endDate = strtotime($startDate) + ($day1 * 24 * 60 * 60);
			$endDate  = date('Y-m-d',$endDate );
			$result = $this->where('bill_code','=',$data->bill_code)
						->update(array(
					'bill_start_date' => $billData->bill_start_date,
					'bill_end_date' => $endDate,
					'bill_interest' => $data->bill_interest,
					'bill_date_amount' => $data->bill_date_amount,
					'bill_price' => $data->bill_price,
					'bill_type' => $data->bill_type,
					'bill_price_dow' => $data->bill_price_dow,
					'customers_id' => $data->customers_id,
					'bill_pay_price' => $bill_pay_price,
					'bill_installments_price' => $bill_installments_price,
					// 'bill_total' => $bill_total,
					'admin_id' => $data->admin_id
				));
			for($i=0;$i<count($data->product);$i++)
			{
				$product->insert([
						'product_name' => $data->product[$i]->productName,
						'product_amount' => $data->product[$i]->productAmount,
						'product_price' => $data->product[$i]->productPrice,
						'bill_code' => $data->bill_code
				]);
			}
			for($i=0 ;$i<($data->bill_date_amount+$billData->bill_pay_only_lnterest_amount);$i++)
			{
				$startDate= strtotime($startDate) + ($day* 24 * 60 * 60);
				$startDate = date('Y-m-d',$startDate);	
				if($countbillDatailStatus > 0 )
				{
					$billDeatail->insert([
						'bill_detail_date' => $startDate,
						'bill_detail_status' => $billDatailStatus[$i]->bill_detail_status,
						'bill_detail_price' => $billDatailStatus[$i]->bill_detail_price,
						'admin_id' => $billDatailStatus[$i]->admin_id,
						'bill_detail_time' => $billDatailStatus[$i]->bill_detail_time,
						'bill_detail_pay_date' => $billDatailStatus[$i]->bill_detail_pay_date,
						'bill_code' => $data->bill_code
					]);
					
					$countbillDatailStatus--;
				}
				else 
				{
						$billDeatail->insert([
							'bill_detail_date' => $startDate,
							'bill_detail_status' => 0,
							'bill_code' => $data->bill_code
						]);
				}
				
			}
			return $result;

		}

		// public function insertBill()
		// {
		// 	$product = new Product;
		// 	$billDeatail = new BillDetail;
		// 	$customers = new Customers;

		// 	for($i= 0 ; $i<10000;$i++)
		// 	{
		// 		$bill_date_amount = 2;
		// 		$bill_type = 0;

		// 		$billCode = $this->randomBill();

		// 		// $data = json_decode($array['data']);

		// 		$startDate = date('Y-m-d');
		// 		$day = 30;
			
		// 		if($bill_type == 1)
		// 		{
		// 			$day = 15;
		// 		}

		// 		$day1 = $day * $bill_date_amount;
		// 		$endDate = time() + ($day1 * 24 * 60 * 60);
		// 		$endDate  = date('Y-m-d',$endDate );

		// 		$customersId = $customers->where('customers_id_card','=',25)
		// 								->select('customers_id')->first();

		// 		$this->insert([
		// 				'bill_code' => $billCode ,
		// 				'bill_start_date' => date('Y-m-d'),
		// 				'bill_end_date' => $endDate,
		// 				'bill_interest' => 200,
		// 				'bill_date_amount' => $bill_date_amount,
		// 				'bill_status' => 0,
		// 				'bill_price' => 35000,
		// 				'bill_type' => $bill_type,
		// 				'bill_price_dow' => 5000,
		// 				'customers_id' => 25,
		// 				'bill_create_time' => date('Y-m-d H:i:s'),
		// 				'bill_total' => 5000,
		// 				'admin_id' => 1
		// 		]);

		// 		for($i=0;$i<2;$i++)
		// 		{

		// 			$product->insert([
		// 					'product_name' => "TV",
		// 					'product_amount' => 1,
		// 					'product_price' => 15000,
		// 					'bill_code' => $billCode
		// 			]);
		// 		}

		// 		for($i=0 ;$i<$bill_date_amount;$i++)
		// 		{		
		// 			$startDate= strtotime($startDate) + ($day* 24 * 60 * 60);
		// 			$startDate = date('Y-m-d',$startDate);	
		// 			$billDeatail->insert([
		// 					'bill_detail_date' => $startDate,
		// 					'bill_detail_status' => 0,
		// 					'bill_code' => $billCode
		// 			]);
		// 		}
		// 	}

		// 	// return $billCode;
		// }

	}