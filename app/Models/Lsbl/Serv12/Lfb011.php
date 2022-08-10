<?php

namespace App\Models\Lsbl\Serv12;

use Illuminate\Database\Eloquent\Model;

class Lfb011 extends Model
{
    protected $connection = 'lsbl_12_dummy_othr';
    protected $table = 'lfb011';
    protected $primary = 'Id_global';
    protected $fillable = [
        'Vessel_code',
        'No_ba',
        'No_voyage',
        'Arrival_date',
        'Arrival_time',
        'Arrival_at',
        'Arrival_draf_fwd',
        'Arrival_draf_aft',
        'Arrival_sum_stock',
        'Departure_date',
        'Departure_time',
        'Departure_at',
        'Departure_draf_fwd',
        'Departure_draf_aft',
        'Departure_sum_stock',
        'Flow_meter_before',
        'Flow_meter_after',
        'Remarks',
        'sync',
        'Approval_flag',
        'Approval_by',
        'Approval_date',
        'Created_by',
        'Created_date',
        'Modify_by',
        'Modify_date',
        'Aktif',
    ];
}
