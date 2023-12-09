<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainBankModel extends Model
{
    use HasFactory;
    protected $table = 'Worker.worker_main_bank_details';
    protected $primaryKey = 'id';
    protected $fillable =[
        'worker_id','ifsc_pk', 'bank_name','branch_name','bank_address','account_no'
    ];
}
