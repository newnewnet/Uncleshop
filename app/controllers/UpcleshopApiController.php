<?php

	class UpcleshopApiController extends Controller
	{
		public function getBill()
		{
			// $fanpageID = Session::get('page_fid_select', '');

			// if($fanpageID == '')
			// 	return 0;

			$result = DB::table('customers')->get();

			
			return $result;
		}
	}