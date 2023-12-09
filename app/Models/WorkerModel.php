<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class WorkerModel extends Model
{
    use HasFactory;
    protected $table = 'Worker.workers';
    protected $primaryKey = 'id';
    protected $fillable= [
        'firstname','lastname','phone_no','address','aadhaar_id','username','uan'
    ];

//    public static function getWorkerData($table)
//    {
//        $data = DB::table($table)->get();
//        return $data;
//    }
    public function familyMembers()
    {
        return $this->hasMany(FamilyModel::class);
    }
}
