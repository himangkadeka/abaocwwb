<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainFormModel extends Model
{
    use HasFactory;
    protected $table ='Worker.worker_main_form_models' ;
    protected $primaryKey = 'id';
    protected $fillable = ['worker_id','phone_no','district','status','office_id'
    ];
}
