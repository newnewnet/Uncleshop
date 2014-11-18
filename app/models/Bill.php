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
					'customers_id_card' => $data->customers_id_card,
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
			$customerData =  $customer->where('customers_id_card','=',$billData->customers_id_card)->first();
			$adminData = $admin->where('admin_id','=',$billData->admin_id)->select('admin_name','admin_last_name')->first();
			$billDetailData = $billDeatail->where('bill_code','=',$billCode)->select('bill_detail_id','bill_detail_date','bill_detail_status')->get();
			$billData['bill_total_price'] = $billData->bill_price+$billData->bill_interest;
			$billData['bill_installments_price'] = ceil((($billData->bill_price+$billData->bill_interest)-$billData->bill_price_dow)/$billData->bill_date_amount);
			$billData['bill_pay_price'] = (($billData->bill_price+$billData->bill_interest)-$billData->bill_price_dow);
			$billData['bill_interest_to_mount'] = ($billData->bill_interest/$billData->bill_date_amount);

			$billData->bill_start_date = strtotime($billData->bill_start_date);
			$billData->bill_start_date = date('d-m-Y',$billData->bill_start_date);

			for($i=0;$i<count($billDetailData);$i++)
			{
				$date = strtotime($billDetailData[$i]->bill_detail_date);
				$date = date('d-m-Y',$date);
				$billDetailData[$i]->bill_detail_date = $date;
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


		public function searchBill($key)
		{
			$result = '';
			if($key != '')
			{
				$customers =  new Customers;
				$product = new Product;
				$result = $customers->join('bill', 'customers.customers_id_card', '=', 'bill.customers_id_card')			
								->orWhere('customers.customers_id_card', 'LIKE', "%".$key."%")
								->orWhere('customers.customers_name', 'LIKE', "%".$key."%")
								->orWhere('customers.customers_tel', 'LIKE', "%".$key."%")
								->orWhere('bill.bill_code', 'LIKE', "%".$key."%")
								->where('bill.bill_status', '=', 0)
								->select('bill.bill_code','customers.customers_name','customers.customers_tel','customers.customers_id_card','customers.customers_sex')
								->get();

				for($i=0;$i<count($result);$i++)
				{
					$productData = $product->where('bill_code','=',$result[$i]->bill_code)
									->orderBy('product_price', 'desc')
                  ->select('product_name','product_price','product_amount')
                  ->first();
          $result[$i]['product'] = $productData;

				}

			}
			return $result;
		}


	}