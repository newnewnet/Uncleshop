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
		
			$billCode = $this->randomBill();

			$data = json_decode($array['data']);

			$day = 30;
			// $month = date('m');
			// $year   = date('Y');

			if($data->bill_type == 1)
			{
				$day = 15;
				// $day = 15*$data->bill_date_amount;
				// $endDate = time() + ($day *24*60 * 60);
				// $endDate  = date('Y-m-d',$endDate );
			}

			$day = $day * $data->bill_date_amount;
			$endDate = time() + ($day * 24 * 60 * 60);
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

			return $billCode;


		}
		public function getBill($billCode)
		{
			$product = new Product;
			$customer = new Customers;
			$admin = new Admin;

			$billData = $this->where('bill_code','=',$billCode)->first();
			$productData = $product->where('bill_code','=',$billCode)->get();
			$customerData =  $customer->where('customers_id_card','=',$billData->customers_id_card)->first();
			$adminData = $admin->where('admin_id','=',$billData->admin_id)->select('admin_name','admin_last_name')->first();

			$billData['bill_total_price'] = $billData->bill_price+$billData->bill_interest;

			$billData['bill_installments_price'] = ceil((($billData->bill_price+$billData->bill_interest)-$billData->bill_price_dow)/$billData->bill_date_amount);
			$billData['bill_pay_price'] = (($billData->bill_price+$billData->bill_interest)-$billData->bill_price_dow);
			
			$starDate = $billData->bill_start_date;
			$day = 30;

			if($billData->bill_type == 1)
			{
				$day = 15;
			}
			for($i=0 ;$i<$billData->bill_date_amount;$i++)
			{		
				$starDate= strtotime($starDate) + ($day* 24 * 60 * 60);
				$starDate = date('Y-m-d',$starDate);	
				$dateBill[$i] = $starDate;
			}

			$result['bill'] = $billData;
			$result['product'] = $productData;
			$result['customer'] = $customerData;
			$result['admin'] = $adminData;
			$result['dateBill'] = $dateBill;

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

	}