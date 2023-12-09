<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchemesModel extends Model
{
    protected $guarded;
    use HasFactory;
    protected $table ='Worker.temp_worker_schemes' ;
    protected $primaryKey = 'id';
    protected $fillable = [
        'worker_id','scheme_name','registration_id','date'
    ];

}
