<?php

	class UncleshopApiController extends Controller
	{
		public function getCustomers()
		{	
			$customers = new Customers;
			$key = Input::get('key');
			$param = $this->validateParamBill(Input::all());
			$result = $customers->getCustomers($param,$key);
			return $result;
		}
		public function saveCustomers()
		{
			$customers = new Customers;
			$array = Input::all();
			$result = $customers->insertCustomers($array);
			return $result;
		}
		public function checkCustomersId()
		{
			$customers = new Customers;
			$array = Input::all();
			$result = $customers->checkCustomersId($array);
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
			return $bill->insertBill($array);

		}
		public function getBill()
		{
			$billCode = Input::get('bill_code');
			$bill = new Bill;
			return $bill->getBill($billCode);

		}
		public function updateBill()
		{
			$array = Input::all();
			$bill = new Bill;
			return $bill->updateBill($array);

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
		public function getAdminInterest()
		{
			$admin = new Admin;
			$result = $admin->getAdminInterest();
			return $result;
		}
		public function searchBill()
		{
			$key = Input::get('key');
			$status = Input::get('status');
			$param = $this->validateParamBill(Input::all());
			$bill= new Bill;
			$result = $bill->searchBill($param,$key,$status);
			return $result;
		}
		private function validateParamBill($param)
		{
			if(empty($param['page']))
			{
				$param['page'] = 1;
			}

			if(empty($param['perpage']))
			{
				$param['perpage'] = 10;
			}

			return $param;
		}
		public function timeLineBill()
		{
			$date = '';
			$date = Input::get('date');
			$column = Input::get('column');
			$param = $this->validateParamBill(Input::all());
			$billDetail= new BillDetail;
			$result = $billDetail->timeLineBill($date,$param,$column);
			return $result;
		}
		public function updateBillDetail()
		{
			$array = Input::all();
			$billDetail= new BillDetail;
			$result = $billDetail->updateBillDetail($array);
			return $result;
		}
		public function cutBillDetail()
		{
			$array = Input::all();
			$billDetail= new BillDetail;
			$result = $billDetail->cutBillDetail($array);
			return $result;
		}
		public function payOnlyInterest()
		{
			$array = Input::all();
			$billDetail= new BillDetail;
			$result = $billDetail->payOnlyInterest($array);
			return $result;
		}
		public function deleteBill()
		{
			$billCode = Input::get('bill_code');
			$bill = new Bill;
			return $bill->deleteBill($billCode);
		}
	}