<?php 
	class Product extends Eloquent
	{
		protected $table = 'product';
		protected $guarded = array();
		public $timestamps = false;
		protected $primaryKey = 'product_id';


	}