<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
class Product extends Model
{
    public $table = 'products';
    protected $primaryKey = 'product_id';
    protected $fillable = [
        'product_id',
        'category_id',
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
    public function getProductInfo($productId)
    {
        $select = DB::raw('products.*, category.name');
        $dataBase = DB::table('products')->select($select);
        $dataBase->join('category', function ($join) {
            $join->on('products.category_id', '=', 'category.id');
        });
        $dataBase->where('products.product_id', $productId);
        $responseData= $dataBase->first();
        return $responseData;
    }
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
    public function createRecord($crud)
    {
        $lastId = DB::table('products')->insertGetId($crud);
        return $lastId;
    }
    public function updateRecord($crud,$where)
    {
        $update = DB::table('products')->where($where)->update($crud);
        return $update;
    }
    public function createBulkRecord($crud)
    {
        $lastId = DB::table('product_allergies')->insert($crud);
        return $lastId;
    }
    public function getProductAllergyIds($productId)
    {
        $info = DB::table('product_allergies')
            ->select(DB::raw("group_concat(product_allergies.allergy_id) as allergyIds"))
            ->where('product_allergies.product_id',$productId)
            ->orderBy('product_allergies.product_allergy_id','desc')
            ->first();
        if($info->allergyIds){
            $arr = explode(",", $info->allergyIds);
            return array_map('intval', $arr);
        }else{
            return array();
        }
    }
    public function deleteProductAllergy($productId, $needDeleteArr)
    {
        DB::table('product_allergies')
            ->where('product_id', $productId)
            ->whereIn('allergy_id', $needDeleteArr)
            ->delete();
        return true;
    }
    public function deleteRecordByProductId($productId)
    {
        $dataBase =  DB::table('product_allergies');
        $dataBase->where('product_id', $productId);
        $dataBase->delete();
        return true;
    }
    public function getById($id)
    {
        $product = DB::table('products')->where('product_id',$id)->first();
        return $product;
    }
}
