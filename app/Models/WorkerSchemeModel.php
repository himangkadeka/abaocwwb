<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkerSchemeModel extends Model
{
    protected $guarded;
    use HasFactory;
    protected $table ='Worker.worker_main_schemes' ;
    protected $primaryKey = 'id';
    protected $fillable = [
        'worker_id','scheme_name','registration_id','date'
    ];
}
