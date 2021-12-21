<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Cron extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'order_id';
    protected $fillable = [];
    public function __construct()
    {
    }

    public function getTodayGiftVoucherList($date)
    {
        $responseData = DB::table('voucher_orders')
            ->where('voucher_orders.email_sent', 'no')
            ->where('voucher_orders.when_to_email_voucher', $date)
            ->select('voucher_orders.*')
            ->get();
        return $responseData;
    }


}
