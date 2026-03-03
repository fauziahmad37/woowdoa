<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'transactions';

    protected $primaryKey = 'transaction_id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'transaction_id',
        'partner_service_id',
        'mitra_id',
        'virtual_account_no',
        'virtual_account_name',
        'virtual_account_email',
        'virtual_account_phone',
        'inquiry_request_id',
        'payment_request_id',
        'trx_date_init',
        'trx_date_time',
        'maxi_trans_date',
        'reference_no',
        'channel_code',
        'language',
        'amount',
        'hashed_source_account_no',
        'source_bank_code',
        'trxid',
        'insert_id',
        'is_delete',
    ];

    public $timestamps = true;
}
