<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainCertificateModel extends Model

{
    protected $guarded = [];
    use HasFactory;
    protected $table= 'Worker.main_worker_certificate';
    protected $primaryKey = 'id';
    protected $fillable = ['worker_id','type_of_issuer','issue_date','issue_no','type_of_employer','name','mobile','from_date','to_date'];

}
