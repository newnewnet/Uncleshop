<?php

	class UncleshopApiController extends Controller
	{
		public function getCutomers()
		{
			// $fanpageID = Session::get('page_fid_select', '');

			// if($fanpageID == '')
			// 	return 0;

			// $result = DB::table('customers')->get();

			
			$customers = new Customers;
			$result = $customers->getCustomers();
			return $result;
		}
		public function saveCutomers()
		{

		}
	}