<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class UserCategory extends Model
{
    public $table = 'user_category';
    protected $fillable = [
        'user_category_id ',
        'user_id',
        'category_id',
        'change_category_name',
        'user_category_order',
        'created_at',
        'updated_at'
    ];

    public function getUserSelectedCategories($userId)
    {
        //$select = DB::raw('category.*,user_category.*');
        $select = DB::raw('category.id,category.name,category.spanish,category.status,category.category_type,user_category.change_category_name,user_category.user_category_order,user_category.user_category_id,user_category.category_id');
        $dataBase = DB::table('category')->select($select);
        $dataBase->where('user_category.user_id', '=', $userId);
        $dataBase->leftJoin('user_category', function ($leftJoin) {
            $leftJoin->on('category.id', '=', 'user_category.category_id');
            #$leftJoin->where('product_image.active', 1);
            #$leftJoin->where('product_image.isDelete', 0);
        });
        $dataBase->where('category.status', 'active');
        #$responseData= $dataBase->orderBy('user_category.user_category_order','asc')->get();
        $responseData= $dataBase->orderByRaw("user_category.user_category_order asc, user_category.user_category_id DESC")->get();
        return $responseData;
    }

    public function getAllUserSelectedCategoryIds($userId)
    {
        //$select = DB::raw('category.*,user_category.*');
        $dataBase = DB::table('category')->select(DB::raw("group_concat(user_category.category_id) as userCategoryIds"));
        $dataBase->where('user_category.user_id', '=', $userId);
        $dataBase->leftJoin('user_category', function ($leftJoin) {
            $leftJoin->on('category.id', '=', 'user_category.category_id');
            #$leftJoin->where('product_image.active', 1);
            #$leftJoin->where('product_image.isDelete', 0);
        });
        $dataBase->where('category.status', 'active');
        $responseData= $dataBase->orderBy('user_category.user_category_order','asc')->get()->first();
        if($responseData->userCategoryIds){
            $arr = explode(",", $responseData->userCategoryIds);
            return array_map('intval', $arr);
        }else{
            return array();
        }
    }


    public function createRecord($crud)
    {
        $lastId = DB::table('user_category')->insertGetId($crud);
        return $lastId;
    }
    public function createBulkRecord($crud)
    {
        $lastId = DB::table('user_category')->insert($crud);
        return $lastId;
    }
    public function deleteRecord($id,$userId=0)
    {
        $dataBase =  DB::table('user_category');
        if($userId > 0){
            $dataBase->where('user_id', $userId);
             #->whereIn('category_id', $needDeleteArr)
        }
        $dataBase->where('user_category_id', $id);
        $dataBase->delete();
        return true;
    }
    public function deleteRecordByCategoryId($id,$userId=0)
    {
        $dataBase =  DB::table('user_category');
        if($userId > 0){
            $dataBase->where('user_id', $userId);
            #->whereIn('category_id', $needDeleteArr)
        }
        $dataBase->where('category_id', $id);
        $dataBase->delete();
        return true;
    }
    public function deleteBulkRecordByCategoryIds($ids,$userId=0)
    {
        $dataBase =  DB::table('user_category');
        if($userId > 0){
            $dataBase->where('user_id', $userId);
            #->whereIn('category_id', $needDeleteArr)
        }
        #$dataBase->where('category_id', $id);
        $dataBase->whereIn('category_id', $ids);
        $dataBase->delete();
        return true;
    }
    public function deleteAllCategoryByUseId($userId=0)
    {
        $dataBase =  DB::table('user_category');
        $dataBase->where('user_id', $userId);
        $dataBase->delete();
        return true;
    }
    public function getUserSelectedCategoryIds($userId)
    {
        $info = DB::table('user_category')
            ->select(DB::raw("group_concat(user_category.category_id) as userCategoryIds"))
            ->leftJoin('category', function ($leftJoin) {
                $leftJoin->on('category.id', '=', 'user_category.category_id');
            })
            ->where('user_category.user_id',$userId)
            ->where('category.status', 'active')
            ->orderBy('user_category.user_category_order','asc')
            ->first();
        if($info->userCategoryIds){
            $arr = explode(",", $info->userCategoryIds);
            return array_map('intval', $arr);
        }else{
            return array();
        }
    }



    public function insertUserCategory($crud)
    {
        return DB::table('user_category')->insertGetId($crud);
    }

    /*public function getMaxUserCategoryOrder($userId)
    {
        #SELECT max(user_category_order) as max_user_category_order FROM `user_category` WHERE `user_id` = '2930'
        return DB::table('user_category')
            ->where('user_id', $userId)
            ->max('user_category_order');
    }*/
    public function getNewUserCategoryOrder($userId)
    {
        $maxUserCategoryOrder = DB::table('user_category')
            ->where('user_id', $userId)
            ->max('user_category_order');
        if($maxUserCategoryOrder === NULL){
            $maxUserCategoryOrder = 1;
        }else if($maxUserCategoryOrder > 0){
            $maxUserCategoryOrder++;
        }else{
            $maxUserCategoryOrder = 1;
        }
        return $maxUserCategoryOrder;
    }

    public function updateRecord($crud,$where)
    {
        $update = DB::table('user_category')->where($where)->update($crud);
        return $update;
    }
    public function getMaxUserCategoryOrder($userId)
    {
        $maxUserCategoryOrder = DB::table('user_category')
            ->where('user_id', $userId)
            ->max('user_category_order');
        if($maxUserCategoryOrder === NULL){
            $maxUserCategoryOrder = 1;
        }else if($maxUserCategoryOrder > 0){
            $maxUserCategoryOrder++;
        }else{
            $maxUserCategoryOrder = 1;
        }
        return $maxUserCategoryOrder;
    }
}
