<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainAddressModel extends Model
{
    use HasFactory;
    protected $table = 'Worker.worker_main_address';
    protected $primaryKey = 'id';
    protected $fillable = [
        'worker_id', 'c_residence','c_house_type','c_circle', 'c_house_no','c_road','c_area','c_city','c_state','c_district','c_post_office','c_pin','c_std',
        'p_residence','p_house_type','p_house_no','p_road','p_area','p_city','p_circle','p_state','p_district', 'p_post_office','p_pin', 'p_std','landmark',
        'landline','ration_no','ration_type'
    ];
}
