<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {
	protected $fillable = [
		'name',
		'code',
		'price',
	];

	static $rules = [
		'name'  => 'required',
		'code'  => 'required|string|unique:products',
		'price' => 'required|integer'
	];

	protected $hidden = [
		'created_at',
		'updated_at',
	];
}
