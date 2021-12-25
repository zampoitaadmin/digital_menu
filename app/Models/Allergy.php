<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Allergy extends Model
{
    public $table = 'allergy';

    protected $fillable = [
        'name ',
        'spanish',
        'image',
        'status',
        'created_on',
        'created_by',
        'updated_on',
        'updated_by'
    ];

    public function getProductAllergies($productId)
    {
        // SELECT product_allergies.*, allergy.name, allergy.spanish, allergy.image FROM product_allergies JOIN allergy ON product_allergies.allergy_id=allergy.id WHERE product_allergies.product_id = '283' AND allergy.status = 'active'

        $select = DB::raw('product_allergies.*, allergy.name, allergy.spanish, allergy.image');
        $dataBase = DB::table('product_allergies')->select($select);
        $dataBase->join('allergy', function ($join) {
            $join->on('product_allergies.allergy_id', '=', 'allergy.id');
        });
        $dataBase->where('product_allergies.product_id', $productId);
        $dataBase->where('allergy.status', 'active');
        $responseData= $dataBase->get();
        return $responseData;
    }

    public function getAllAllergies()
    {
        // SELECT allergy.* FROM allergy WHERE allergy.status = 'active'
        $select = DB::raw('allergy.*');
        $dataBase = DB::table('allergy')->select($select);
        $dataBase->where('allergy.status', 'active');
        $responseData= $dataBase->get();
        return $responseData;
    }
}
