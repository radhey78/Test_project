<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{	
	protected $primaryKey = 'id';
    protected $fillable =['name','price','product_image_one','product_image_two','product_image_three','product_category'];

}
