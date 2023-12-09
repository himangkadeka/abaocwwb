<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormModel extends Model
{
    use HasFactory;
    protected $table ='Worker.temp_form_models' ;
    protected $primaryKey = 'id';
    protected $fillable = [
        'worker_id','phone_no','district','office_id'
    ];
}
