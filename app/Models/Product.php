<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Product extends Model
{
    public $table = 'product';

    protected $fillable = [
        'category_id ',
        'user_id',
        'product_type',
        'product_name',
        'product_description',
        'product_main_image',
        'product_price',
        'product_topa',
        'product_1r',
        'product_12r',
        'product_multiple_image',
        'product_order',
        'status',
        'created_at',
        'updated_at'
    ];

    public function getProductData($categoryId, $userId)
    {
        // SELECT products.*, category.name FROM products JOIN category ON products.category_id = category.id WHERE products.category_id = '11' AND products.user_id = '2930' ORDER BY category.id ASC, products.product_order ASC

        $select = DB::raw('products.*, category.name');
        $dataBase = DB::table('products')->select($select);
        $dataBase->where('products.user_id', '=', $userId);
        $dataBase->join('category', function ($join) {
            $join->on('products.category_id', '=', 'category.id');
        });
        $dataBase->where('products.category_id', $categoryId);
        #$responseData= $dataBase->orderBy('user_category.user_category_order','asc')->get();
        $responseData= $dataBase->orderByRaw("category.id ASC, products.product_order ASC")->get();
        return $responseData;
    }
}
