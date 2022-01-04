<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
class MerchantFixedMenuData extends Model
{
    public $table = 'merchant_fixed_menu_data';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'user_id',
        'category_id',
        'price',
        'menu_description_conditions',
        'created_at',
        'updated_at',
    ];
    public function createRecord($crud)
    {
        $lastId = DB::table('merchant_fixed_menu_data')->insertGetId($crud);
        return $lastId;
    }
    public function getFixedMenuByCategoryIdUserId($userId, $categoryId)
    {
        $select = DB::raw('merchant_fixed_menu_data.*');
        $dataBase = DB::table('merchant_fixed_menu_data')->select($select);
        $dataBase->where('merchant_fixed_menu_data.user_id', '=', $userId);
        $dataBase->where('merchant_fixed_menu_data.category_id', '=', $categoryId);
        $responseData= $dataBase->first();
        return $responseData;
    }
    public function updateRecord($crud,$where)
    {
        $update = DB::table('merchant_fixed_menu_data')->where($where)->update($crud);
        return $update;
    }
    public function getById($id)
    {
        $product = DB::table('merchant_fixed_menu_data')->where('id',$id)->first();
        return $product;
    }
}
