<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainBasicDetails extends Model
{
    use HasFactory;
    protected $table = 'Worker.worker_main_basic_details';
    protected $primaryKey = 'id';
    protected $fillable = [
        'worker_id', 'first_name','last_name', 'gurdain_name','gender','maritial_status','category','eshram_no','education','occupation','dob','pf_no','esic_no','email'
    ];
}
