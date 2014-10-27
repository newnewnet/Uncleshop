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
		public function deleteCustomers()
		{
			$customers = new Customers;
			$array = Input::all();
			$result = $customers->deleteCustomers($array);
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
			$result = $admin->insertAdmin($array);
			return $result;

		}
		public function checkUser()
		{
			$array = Input::all();
			$admin = new Admin;
			$result = $admin->getCountUser($array);
			return $result;
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
		public function updateAdmin()
		{
			$admin = new Admin;
			$array = Input::all();
			$result = $admin->updateAdmin($array);
			return $result;
		}
		public function deleteAdmin()
		{
			$admin = new Admin;
			$array = Input::all();
			$result = $admin->deleteAdmin($array);
			return $result;
		}
		public function getAdmin()
		{
			$admin = new Admin;
			$result = $admin->getAdmin();
			return $result;
		}
	}