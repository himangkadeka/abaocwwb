<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyModel extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'Worker.temp_worker_family_models';
    protected $primaryKey = 'id';
    protected $fillable = [
            'worker_id', 'first_name', 'last_name','gurdain_name', 'dob','relation','profession','education','nominee','already_registered','bocwwb_id'];

    public static function where($string, $worker_id)
    {
    }
}
