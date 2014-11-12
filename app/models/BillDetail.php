<?php 
	class BillDetail extends Eloquent
	{
		protected $table = 'bill_detail';
		protected $guarded = array();
		public $timestamps = false;
		protected $primaryKey = 'bill_detail_id';

		public function updateBillDeatail($array)
		{
			if(isset($array))
			{			
				$result = $this->where('bill_detail_id','=',$array['bill_detail_id'])
						->update(array(
								'bill_detail_status' => 1,
								'bill_detail_price' => $array['bill_detail_price'],
								'admin_id' => $array['admin_id'],
							));



				$billDetailData =  $this->where('bill_detail_id','=',$array['bill_detail_id'])->first();

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
		public function cutBillDeatail($array)
		{
			if(isset($array))
			{
				$this->where('bill_detail_id','=',$array['bill_detail_id'])
						->update(array(
								'bill_detail_status' => 2,
								'bill_detail_price' => $array['bill_detail_price'],
								'admin_id' => $array['admin_id'],
							));			

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
											'bill_price' => $array['bill_price']
								));

				return $result;

			}
		}


	}