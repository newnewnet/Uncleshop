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

			$day = 0;
			$month = date('m');
			$year   = date('Y');

			if($data->bill_type == 1)
			{
				$day = 15*$data->bill_date_amount;
				$endDate = time() + ($day *24*60 * 60);
				$endDate  = date('Y-m-d',$endDate );
			}
			else 
			{
				for($i=0 ;$i<$data->bill_date_amount;$i++)
				{
						if($month == 12)
						{
							$month = 1;
						}
						else if($i != 0)
						{
							$month+=1;
						}
			
						$day+=$this->daysInMonth($month,$year);
						$expireDate = time() + ($day *24*60 * 60);
						$year = date('Y',$expireDate);					
				}
				$endDate = time() + ($day *24*60 * 60);
				$endDate  = date('Y-m-d',$endDate );
			}
	
			// $this->insert([
			// 		'bill_code' => $billCode ,
			// 		'bill_create_time' => date('Y-m-d H:i:s'),
			// 		'customers_id' => $data->customers_id,
			// 		'admin_id' => $data->admin_id
			// ]);


			$this->insert([
					'bill_id' => $billCode ,
					'bill_start_date' => date('Y-m-d'),
					'bill_end_date' => $endDate,
					'bill_total_price' => $data->bill_total_price,
					'bill_date_amount' => $data->bill_date_amount,
					'bill_status' => 0,
					'bill_price' => $data->bill_price,
					'bill_type' => $data->bill_type,
					'bill_price_dow' => $data->bill_price_dow,
					'customers_id' => $data->customers_id,
					'bill_create_time' => date('Y-m-d H:i:s'),
					'admin_id' => $data->admin_id
			]);]

			for($i=0;$i<count($data->product);$i++)
			{

				$product->insert([
						'product_name' => $data->product[$i]->productName,
						'product_amount' => $data->product[$i]->productAmount,
						'product_price' => $data->product[$i]->productPrice,
						'bill_code' => $billCode
				]);
			}

			$result = $this->getBill($billCode);
			return $result;


		}
		public function getBill($billCode)
		{
			$product = new Product;
			$billData = $this->where('bill_code','=',$billCode)->first();
			$productData = $product->where('bill_code','=',$billCode)->get();
			$result['bill'] = $billData;
			$result['product'] = $productData;

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