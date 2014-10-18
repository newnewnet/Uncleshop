<?php 
	class Bill_detail extends Eloquent
	{
		protected $table = 'bill_detail';
		protected $guarded = array();
		public $timestamps = false;
		protected $primaryKey = 'bill_detail_id';


	}