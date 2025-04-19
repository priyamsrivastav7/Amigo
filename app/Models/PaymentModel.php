<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'order_id', 'cf_order_id', 'payment_session_id',
        'order_amount', 'currency', 'status', 'payment_info'
    ];
}
