<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Category extends Model
{
    public $table = 'category';
    protected $fillable = [
        'id',
        'user_id',
        'category_type',
        'name',
        'spanish',
        'product_price',
        'menu_description_conditions',
        'status',
        'created_on',
        'created_by',
        'updated_on',
        'updated_by'
    ];
    public function __construct()
    {
        $this->type = array(
            'Normal'=>'Normal',
            'FIXED'=>'Fixed'
        );
        $this->status = array(
            'ACTIVE'=>'active',
            'INACTIVE'=>'inactive',
            'DELETED'=>'deleted'
        );
    }

    public function getAllWithUser($userId)
    {
        $select = DB::raw('id,name,spanish,status,category_type');
        $dataBase = DB::table('category')->select($select);
        //$dataBase->where('token', $sso);
        $dataBase->where(function ($query) use ($userId) {
            $query->where('user_id', '=', $userId)
                ->orWhere('created_by', '=', 1); //ADMIN Category
        });
        $dataBase->where('category.status', 'active');
        $responseData= $dataBase->orderBy('name','asc')->get()->all();
        return $responseData;

        /*
          $select = DB::raw('category.id,category.name,category.spanish,category.status,category.category_type, CASE WHEN user_category.category_id > 0 THEN 1 ELSE 0 END as isSelected');
        $dataBase = DB::table('category')->select($select);
        //$dataBase->where('token', $sso);
        $dataBase->leftJoin('user_category', function ($leftJoin) use($userId) {
            $leftJoin->on('user_category.category_id', '=', 'category.id');
            $leftJoin->where('user_category.category_id', $userId);
            #$leftJoin->where('product_image.isDelete', 0);
        });
        $dataBase->where(function ($query) use ($userId) {
            $query->where('category.user_id', '=', $userId)
                ->orWhere('category.created_by', '=', 1); //ADMIN Category
        });
        $dataBase->where('category.status', 'active');
        $responseData= $dataBase->orderBy('category.name','asc')->get()->all();
        return $responseData;
        */
    }
    public function getAllOnlyByUser($userId)
    {
        $select = DB::raw('id,name,spanish,status,category_type');
        $dataBase = DB::table('category')->select($select);
        $dataBase->where('user_id', '=', $userId);
        $dataBase->where('category.status', 'active');
        $responseData= $dataBase->orderBy('name','asc')->get()->all();
        return $responseData;
    }
    public function getCategoryIdsCreatedByUser($userId)
    {
        $info = DB::table('category')
            ->select(DB::raw("group_concat(id) as categoryIds"))
            ->where('created_by',$userId)
            ->first();
        if($info->categoryIds){
            $arr = explode(",", $info->categoryIds);
            return array_map('intval', $arr);
        }else{
            return array();
        }
    }
    public function getAllMain()
    {
        $category = DB::table('category')->orderBy('created_at','desc')->get()->all();
        return $category;
    }
    public function getAllCategoryData()
    {
        $category = DB::table('category')->orderBy('created_at','desc')->get()->all();
        return $category;
    }
    public function createRecord($crud)
    {
        $lastId = DB::table('category')->insertGetId($crud);
        return $lastId;
    }
    public function updateRecord($crud,$where)
    {
        $update = DB::table('category')->where($where)->update($crud);
        return $update;
    }

    public function getById($id)
    {
        $category = DB::table('category')->where('id',$id)->first();
        return $category;
    }
    public function deleteRecord($where)
    {
        $category = DB::table('category')->where($where)->delete();
        return $category;
    }


    public function getTotalByUser($userId)
    {
        $select = DB::raw('*');
        $dataBase = DB::table('category')->select($select);
        $dataBase->where('user_id', '=', $userId);
        $dataBase->where('category.status', 'active');
        $responseData= $dataBase->count();
        return $responseData;
    }

}
