<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtpVerificationCode extends Model
{
    use HasFactory;
    protected $table= 'Worker.verification_codes';
    protected $primaryKey= 'id';
    protected $fillable = ['uan','otp','expire_at'];


}
