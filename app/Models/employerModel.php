<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employerModel extends Model
{
    use HasFactory;
    protected $table = 'Worker.temp_worker_employer_details';
    protected $primaryKey = 'id';
    protected $fillable = ['worker_id','employer_name','board','type_of_work','workplace','mobile','district','subdistrict','city','pin_code','doj','nature_of_work','mgnrega_no'];
}
