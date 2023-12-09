<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class applicationStatus extends Model
{
    use HasFactory;
    protected $table = 'Worker.worker_application_status';
    protected $primaryKey = 'id';
    protected $fillable =[
        'application_id','application_status', 'remarks','role_id','office_id','user_id','from_user','to_user','expiry'
    ];
}
