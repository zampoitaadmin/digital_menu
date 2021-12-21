<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class MenuBranding extends Model
{
    public $table = 'menu_branding';
    protected $fillable = [
        'menu_branding_id ',
        'user_id',
        'brand_color',
        'secondary_color',
        'third_color',
        'font_color',
        'brand_logo',
        'brand_banner_image',
        'status',
        'created_at',
        'updated_at'
    ];
    public function __construct()
    {
        $this->status = array(
            'ACTIVE'=>'Active',
            'INACTIVE'=>'Inactive',
            'DELETED'=>'Delete'
        );
    }
    //Branding By User ID
    public function getOneByUserId($userId)
    {
        $select = DB::raw('*');
        $dataBase = DB::table('menu_branding')->select($select);
        $dataBase->where('user_id', '=', $userId);
        $dataBase->where('status', $this->status['ACTIVE']);
        $responseData= $dataBase->get()->first();
        return $responseData;
    }


    public function createRecord($crud)
    {
        $lastId = DB::table('menu_branding')->insertGetId($crud);
        return $lastId;
    }
    public function updateRecord($crud,$where)
    {
        $update = DB::table('menu_branding')->where($where)->update($crud);
        return $update;
    }


    public function getById($id)
    {
        $category = DB::table('menu_branding')->where('menu_branding_id',$id)->first();
        return $category;
    }

}
