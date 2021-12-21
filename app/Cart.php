<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Cart extends Model
{
    protected $table = 'cart';
    protected $primaryKey = 'id';
    protected $fillable = [];
    public $productURL ='';
    public function __construct()
    {
        $this->productURL = url('uploads/product');
    }

    //Cart
    
    public function getCartByUserId($userId)
    {
        $select = DB::raw('*');
        $dataBase = DB::table('cart')->select($select);
        $dataBase->where('user_id', $userId);
        $result = $dataBase->get()->first();
        return $result;
    }
    public function isCartExist($userId){
        $select = DB::raw('*');
        $dataBase = DB::table('cart')->select($select);
        $dataBase->where('user_id', $userId);
        $result = $dataBase->get()->first();
        return $result;
    }
    public function addCart($cartData)
    {
        return DB::table('cart')->insertGetId($cartData);
    }
    public function updateCart($where,$cartData)
    {
        $affectedRows = DB::table('cart')->where($where)
            ->update(
                $cartData
            );
        return $affectedRows;

    }
    public function removeCartByUserId($userId)
    {
        return DB::table('cart')->where('user_id', $userId)->delete();
    }


    //Cart Products
    public function getCartProducts($cartId)
    {
        $databaseQuery  = DB::table('cart_products')
            ->select(
                '*'
            )
            ->where('cart_id', $cartId)
            ->where('is_product', '1');
        $responseList = $databaseQuery->orderBy('id','ASC')->get();
        return $responseList;
    }
    public function getCartAllItems($cartId)
    {
        $databaseQuery  = DB::table('cart_products')
            ->select(
                '*'
            )
            ->where('cart_id', $cartId);
            #->where('is_product', '1');
        $responseList = $databaseQuery->orderBy('id','ASC')->get();
        return $responseList;
    }
    public function getCartVouchers($cartId)
    {
        $databaseQuery  = DB::table('cart_products')
            ->select(
                '*'
            )
            ->where('cart_id', $cartId)
            ->where('is_product', '2');
        $responseList = $databaseQuery->orderBy('id','ASC')->get();
        return $responseList;
    }

    //item exist in cart or not
    public function isItemExistInCart($cartId, $cartItemId)
    {
        //, 'week_number' => $currentWeek
        $responseData = \DB::table('cart_products')->select('*')->where(['cart_id' => $cartId, 'id' => $cartItemId])->first();
        return $responseData;
    }
    //Add Item into Cart  Item
    public function addCartItem($cartItem)
    {
        return DB::table('cart_products')->insertGetId($cartItem);
    }

    //Update Item into cart Item
    public function updateCartItem($where,$cartItem)
    {
        $affectedRows = DB::table('cart_products')->where($where)
            ->update(
                $cartItem
            );
        return $affectedRows;

    }

    public function removeCartItemsByUserId($cartId)
    {
        return DB::table('cart_products')->where('cart_id', $cartId)->delete();
    }
    //Remove Item from Cart
    public function removeCartItem($cartId, $cartItemId)
    {
        $dataBase = DB::table('cart_products');
        #$dataBase->where("user_id", $userId);
        $dataBase->where("cart_id", $cartId);
        $dataBase->where("id", $cartItemId);
        return $dataBase->delete();
    }


    public function getCartProductTotalAndVat($cartId)
    {
        $select = DB::raw('COALESCE(sum(total_price),0) AS totalProductPrice, COALESCE(sum(total_vat),0) AS totalProductVat, COALESCE(sum(quantity),0) AS totalProductQty');
        $databaseQuery  = DB::table('cart_products')
            ->select(
                $select
            )
            ->where('cart_id', $cartId)
            ->where('is_product', '1');
        $responseList = $databaseQuery->orderBy('id','ASC')->get()->first();
        return array($responseList->totalProductPrice,$responseList->totalProductVat,$responseList->totalProductQty);
    }
    public function getCartVoucherTotalAndVat($cartId)
    {
        $select = DB::raw('COALESCE(sum(total_price),0) AS totalVoucherPrice, COALESCE(sum(total_vat),0) AS totalVoucherVat');
        $databaseQuery  = DB::table('cart_products')
            ->select(
                $select
            )
            ->where('cart_id', $cartId)
            ->where('is_product', '2');
        $responseList = $databaseQuery->orderBy('id','ASC')->get()->first();
        return array($responseList->totalVoucherPrice,$responseList->totalVoucherVat);
    }
    public function getCartTotalAndVat($cartId)
    {
        $select = DB::raw('COALESCE(sum(total_price),0) AS totalAmount, COALESCE(sum(total_vat),0) AS totalVat');
        $databaseQuery  = DB::table('cart_products')
            ->select(
                $select
            )
            ->where('cart_id', $cartId);
            #->where('is_product', '2');
        $responseList = $databaseQuery->orderBy('id','ASC')->get()->first();
        return array($responseList->totalAmount,$responseList->totalVat);
    }

    public function isExistVoucherCode($code)
    {
        //, 'week_number' => $currentWeek
        $responseData = \DB::table('voucher_orders')->select('*')->where(['voucher_code' => $code])->first();
        return $responseData;
    }

    public function getCartProductShippingCharges($cartId)
    {
        $select = DB::raw('COALESCE(sum(shipping_charge_amount),0) AS totalShippingChargeAmount, COALESCE(sum(shipping_charge_vat),0) AS totalShippingChargeVat');
        $databaseQuery  = DB::table('cart_products')
            ->select(
                $select
            )
            ->where('cart_id', $cartId)
            ->where('is_product', '1');
        $responseList = $databaseQuery->orderBy('id','ASC')->get()->first();
        return array($responseList->totalShippingChargeAmount,$responseList->totalShippingChargeVat);
    }
    public function isExistOrderConfirmationId($orderConfirmationId)
    {
        #$select = DB::raw('COALESCE(count(orderConfirmationId),0) AS isExist');
        $select = DB::raw('*');
        $responseData = DB::table('paypal_cart_temp')
            ->select(
                $select
            )
            ->where('orderConfirmationId', $orderConfirmationId)->get()->first();

        return $responseData;
    }
    public function addPaypalTempOrder($cartData)
    {
        return DB::table('paypal_cart_temp')->insertGetId($cartData);
    }
    public function updatePaypalTempOrder($where,$cartData)
    {
        $affectedRows = DB::table('paypal_cart_temp')->where($where)
            ->update(
                $cartData
            );
        return $affectedRows;

    }
    //Cart Products
    public function getCartSignatureCollection($cartId)
    {
        $databaseQuery  = DB::table('cart_products')
            ->select(
                '*'
            )
            ->where('cart_id', $cartId)
            ->where('is_product', '3');
        $responseList = $databaseQuery->orderBy('id','ASC')->get();
        return $responseList;
    }
    public function getCartProductSCTotalAndVat($cartId)
    {
        $select = DB::raw('COALESCE(sum(total_price),0) AS totalProductPrice, COALESCE(sum(total_vat),0) AS totalProductVat, COALESCE(sum(quantity),0) AS totalProductQty');
        $databaseQuery  = DB::table('cart_products')
            ->select(
                $select
            )
            ->where('cart_id', $cartId)
            ->where('is_product', '3');
        $responseList = $databaseQuery->orderBy('id','ASC')->get()->first();
        return array($responseList->totalProductPrice,$responseList->totalProductVat,$responseList->totalProductQty);
    }
    public function getCartProductSCShippingCharges($cartId)
    {
        $select = DB::raw('COALESCE(sum(shipping_charge_amount),0) AS totalShippingChargeAmount, COALESCE(sum(shipping_charge_vat),0) AS totalShippingChargeVat');
        $databaseQuery  = DB::table('cart_products')
            ->select(
                $select
            )
            ->where('cart_id', $cartId)
            ->where('is_product', '3');
        $responseList = $databaseQuery->orderBy('id','ASC')->get()->first();
        return array($responseList->totalShippingChargeAmount,$responseList->totalShippingChargeVat);
    }
}
