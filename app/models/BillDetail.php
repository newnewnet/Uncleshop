<?php 
	class BillDetail extends Eloquent
	{
		protected $table = 'bill_detail';
		protected $guarded = array();
		public $timestamps = false;
		protected $primaryKey = 'bill_detail_id';

		public function updateBillDetail($array)
		{
			if(isset($array))
			{			
				$result = $this->where('bill_detail_id','=',$array['bill_detail_id'])
						->update(array(
								'bill_detail_status' => 1,
								'bill_detail_price' => $array['bill_detail_price'],
								'bill_detail_time' => date("H:i:s"),
								'bill_detail_pay_date'	=>	date('Y-m-d'),
								'admin_id' => $array['admin_id'],
							));


				$billDetailData =  $this->where('bill_detail_id','=',$array['bill_detail_id'])->first();

				$billData =  DB::table('bill')->where('bill_code','=',$billDetailData->bill_code)->select('bill_total')->first();

				$billData->bill_total+=$array['bill_detail_price'];

				DB::table('bill')->where('bill_code','=',$billDetailData->bill_code)
												->update(array(
																'bill_total' => $billData->bill_total,
															));

				$count = DB::table('bill')->where('bill_code','=',$billDetailData->bill_code)
										->where('bill_end_date','=',$billDetailData->bill_detail_date)
										->count();

				if($count > 0)
				{
					DB::table('bill')->where('bill_code','=',$billDetailData->bill_code)
								->update(array(
											'bill_status' => 1
								));
				}
				return $result;
			}
		}
		public function cutBillDetail($array)
		{
			if(isset($array))
			{
				$this->where('bill_detail_id','=',$array['bill_detail_id'])
						->update(array(
								'bill_detail_status' => 2,
								'bill_detail_price' => $array['bill_detail_price'],
								'bill_detail_time' => date("H:i:s"),
								'bill_detail_pay_date'	=>	date('Y-m-d'),
								'admin_id' => $array['admin_id'],
							));

				$billData =  DB::table('bill')->where('bill_code','=',$array['bill_code'])->select('bill_total')->first();

				$billData->bill_total+=$array['bill_detail_price'];


				$billDetailData =  $this->where('bill_code','=',$array['bill_code'])
										->where('bill_detail_status','=',0)
										->update(array(
											'bill_detail_status' => 2
										));

				$result = DB::table('bill')->where('bill_code','=',$array['bill_code'])
								->update(array(
											'bill_status' => 2,
											'bill_interest' => $array['bill_interest'],
											'bill_date_amount' => $array['bill_date_amount'],
											'bill_total' => $billData->bill_total
											// 'bill_price' => $array['bill_price']
								));

				return $result;

			}
		}
		public function timeLineBill($date,$param,$column)
		{
			$result = '';
			$oparater = '>';
			if($column == 'bill_detail_date')
			{
				$oparater = '=';
			}

			if($date == '')
			{
		 		$result = $this ->join('admin', 'bill_detail.admin_id', '=', 'admin.admin_id')
		 						->join('bill', 'bill_detail.bill_code', '=', 'bill.bill_code')
		 						->join('customers', 'bill.customers_id', '=', 'customers.customers_id')
		 						->where('bill_detail_status','>',0)->orderBy('bill_detail_date','DESC')
		 						->select('admin.admin_id','admin.admin_name','bill_detail.bill_detail_date','bill_detail.bill_detail_id','bill_detail.bill_code','bill_detail.bill_detail_status','customers.customers_name','bill_detail_time','bill_detail_pay_date');


		 	}
		 	else
		 	{
		 		$result = $this ->join('admin', 'bill_detail.admin_id', '=', 'admin.admin_id')
								->join('bill', 'bill_detail.bill_code', '=', 'bill.bill_code')
								->join('customers', 'bill.customers_id', '=', 'customers.customers_id')
								->where($column,'=',$date)->where('bill_detail_status',$oparater,0)
								->select('admin.admin_id','admin.admin_name','bill_detail.bill_detail_date','bill_detail.bill_detail_id','bill_detail.bill_code','bill_detail.bill_detail_status','customers.customers_name','bill_detail_time','bill_detail_pay_date');
		 	
		 	}

		 	$perPage = $param['perpage'];
			$skip = ($param['page'] - 1) * $perPage;
			$page = ceil($result->count() / $perPage);
			$result = $result->skip($skip)->take($perPage)->get();

		 	if($result != '[]')
		 	{
			 	$monthFull = ['','มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'];
				for($i=0;$i<count($result);$i++)
				{
					$date = strtotime($result[$i]->bill_detail_date);
					$day = date('d',$date);
					$month = (int)date('m',$date);
					$year = date('Y',$date);
					$result[$i]->bill_detail_date = $day.' '.$monthFull[$month].' '.$year;
				}
			}

		 	return [
					'page' => $page,
					'data' => $result
				];
		}
		public function payOnlyInterest($array)
		{
			if(!empty($array))
			{
				$bill = new Bill;
				$this->where('bill_detail_id','=',$array['bill_detail_id'])
							->update(array(
								'bill_detail_status' => 3,
								'bill_detail_price' => $array['bill_detail_price'],
								'bill_detail_pay_date'	=>	date('Y-m-d'),
								'bill_detail_time' => date("H:i:s"),
								'admin_id' => $array['admin_id'],
							));

				$billData =  DB::table('bill')->where('bill_code','=',$array['bill_code'])->select('bill_total')->first();

				$billData->bill_total+=$array['bill_detail_price'];

				$dataBill = $bill->where('bill_code','=',$array['bill_code'])->select('bill_end_date','bill_type','bill_pay_only_lnterest_amount')->first();

				$day = 30;
				if($dataBill->bill_type == 1)
				{
					$day = 15;
				}
				$date = strtotime($dataBill->bill_end_date) + ($day * 24 * 60 * 60);
				$date = date('Y-m-d',$date);	

				$result = $bill->where('bill_code','=',$array['bill_code'])
							->update(array(
								'bill_end_date' => $date,
								'bill_pay_only_lnterest_amount' => ++$dataBill->bill_pay_only_lnterest_amoint,
								'bill_total' => $billData->bill_total
							));

				$this->insert([
						'bill_detail_date' => $date,
						'bill_detail_status' => 0,
						'bill_code' => $array['bill_code']
				]);
				return $result;

			}
			
		}




	}