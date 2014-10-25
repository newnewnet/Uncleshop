<?php

	class UncleshopApiController extends Controller
	{
		public function getCustomers()
		{	
			$customers = new Customers;
			$key = Input::get('key');
			$result = $customers->getCustomers($key);
			return $result;
		}
		public function updateCustomers()
		{
			$customers = new Customers;
			$array = Input::all();
			$result = $customers->updateCustomers($array);
			return $result;
		}
		public function saveBill()
		{
			$array = Input::all();
			$bill = new Bill;
			$bill->insertBill($array);

		}
		public function saveAdmin()
		{
			$array = Input::all();
			$admin = new Admin;
			$admin->insertAdmin($array);
		}
		public function loginAdmin()
		{
			$array = Input::all();
			if(count($array)==0)
			{
				return null;
			}
			$admin = new Admin;

			$result = $admin->loginAmin($array);
			
			return $result;

		}
	}