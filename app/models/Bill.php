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
			$billDetailData = $billDeatail->where('bill_code','=',$billCode)->select('bill_detail_id','bill_detail_date','bill_detail_status','admin_id')->get();
			$billData['bill_total_price'] = $billData->bill_price+$billData->bill_interest;
			$billData['bill_installments_price'] = ceil((($billData->bill_price+$billData->bill_interest)-$billData->bill_price_dow)/$billData->bill_date_amount);
			$billData['bill_pay_price'] = (($billData->bill_price+$billData->bill_interest)-$billData->bill_price_dow);
			$billData['bill_interest_to_mount'] = ($billData->bill_interest/$billData->bill_date_amount);

			$billData->bill_start_date = strtotime($billData->bill_start_date);
			$billData->bill_start_date = date('d-m-Y',$billData->bill_start_date);

			// for($i=0;$i<count($billDetailData);$i++)
			// {
			// 	if($billDetailData[$i]->admin_id != null)
			// 	{
			// 		$billDetailData[$i]->admin_name = $admin->where('admin_id','=',$billDetailData[$i]->admin_id)->select('admin_name')->first();
			// 	}
			// 	$date = strtotime($billDetailData[$i]->bill_detail_date);
			// 	$date = date('d-m-Y',$date);
			// 	$billDetailData[$i]->bill_detail_date = $date;
			// }
			$monthFull = ['','มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'];
			for($i=0;$i<count($billDetailData);$i++)
			{
				if($billDetailData[$i]->admin_id != null)
				{
					$billDetailData[$i]->admin_name = $admin->where('admin_id','=',$billDetailData[$i]->admin_id)->select('admin_name')->first();
				}
				$date = strtotime($billDetailData[$i]->bill_detail_date);
				$day = date('d',$date);
				$month = (int)date('m',$date);
				$year = date('Y',$date);
				$billDetailData[$i]->bill_detail_date = $day.' '.$monthFull[$month].' '.$year;
			}

				
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


		public function searchBill($key,$status)
		{
			$result = '';

			if($key != '')
			{
				$customers =  new Customers;
				$product = new Product;
				$result =  DB::select(DB::raw("select bill_status,bill.bill_code,customers.customers_name,customers.customers_tel,customers.customers_id_card,customers.customers_sex FROM bill INNER JOIN customers ON bill.customers_id=customers.customers_id WHERE customers.customers_id_card  LIKE '%".$key."%'  or  customers.customers_name  LIKE '%".$key."%'  or  customers.customers_tel  LIKE '%".$key."% ' or  bill.bill_code  LIKE  '%".$key."%'"));
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
					if($data != "[]")
					{
						for($i=0;$i<count($data);$i++)
						{
							$productData = $product->where('bill_code','=',$data[$i]->bill_code)
											->orderBy('product_price', 'desc')
		                  ->select('product_name','product_price','product_amount')
		                  ->first();

	          	$data[$i]->product = $productData;

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
					if($data != "[]")
					{
						for($i=0;$i<count($data);$i++)
						{
							$productData = $product->where('bill_code','=',$data[$i]->bill_code)
											->orderBy('product_price', 'desc')
		                  ->select('product_name','product_price','product_amount')
		                  ->first();

	          	$data[$i]->product = $productData;

						}
					}
					$result = $data;
				}
				else if ($status == 2) 
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
			}

			return $result;
		}


	}