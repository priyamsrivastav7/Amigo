<?php
namespace App\Models;

use CodeIgniter\Model;

class CouponModel extends Model
{
    protected $table = 'coupons';
    protected $primaryKey = 'id';
    protected $allowedFields = ['code', 'type', 'value', 'min_order_amount', 'max_discount', 'expiry_date', 'status'];

    // Function to validate coupon
    public function validateCoupon($code)
    {
        return $this->where('code', $code)
                    ->where('status', 'active')
                    ->where('expiry_date >=', date('Y-m-d'))
                    ->first();
    }
}
