<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankModel extends Model
{
    use HasFactory;
    protected $table = 'Worker.temp_worker_bank_models';
    protected $primaryKey = 'id';
    protected $fillable =[
       'worker_id','ifsc_pk', 'bank_name','branch_name','bank_address','account_no'
    ];
}
