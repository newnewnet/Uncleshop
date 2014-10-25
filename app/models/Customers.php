<?php 
	class Customers extends Eloquent
	{
		protected $table = 'customers';
		protected $guarded = array();
		public $timestamps = false;
		protected $primaryKey = 'customers_id';

		public function getCustomers($key)
		{
			$result = '';
			if($key != '')
			{
				$customers  = new Customers;
				$result = $customers->orWhere('customers_id', 'LIKE', "%".$key."%")
								->orWhere('customers_name', 'LIKE', "%".$key."%")
								->orWhere('customers_last_name', 'LIKE', "%".$key."%")
								->orWhere('customers_tel', 'LIKE', "%".$key."%")
								->get();
				
			}
			return $result;
		}
		public function updateCustomers($array)
		{
			if(count($array)!=0)
			{
				$result = $this->where('customers_id','=',$array['customers_id'])
						->update(array(
								'customers_name' => $array['customers_name'],
								'customers_last_name' => $array['customers_last_name'],				
								'customers_address' => $array['customers_address'],
								'customers_sex' => $array['customers_sex'],
								'customers_tel' =>$array['customers_tel'],
							));
				return $result;
			}
		}
		public function deleteCustomers($array)
		{
			if(isset($array['customers_id']))
			{
				$result = $this->where('customers_id', '=', $array['customers_id'])->delete();
				return $result;
			}
		}
		
	}