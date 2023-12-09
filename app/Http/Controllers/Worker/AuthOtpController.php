<?php

namespace App\Http\Controllers\Worker;
use App\Http\Controllers\Controller;
use App\Models\OtpVerificationCode;
use App\Models\WorkerModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Auth;

class AuthOtpController extends Controller
{
    public function login()
    {
        return view('/worker/login');
    }

    /****Generate OTP****/
    public function generate(Request $request)
    {
        $validate = $request->validate([
            'uan'=>'required|exists:pgsql.Worker.workers',
        ]);
        #generate otp
        $verificationCode = $this->generateOtp($request->uan);
        $message = "Your OTP To Login is - ".$verificationCode->otp;
        # Return With OTP
        return redirect()->route('', ['user_id' => $verificationCode->user_id])->with('success',  $message);

    }
    public function generateOtp($uan)
    {

        $worker = WorkerModel::Where('uan',$uan)->first();
        #user doesnt have an existing otp
        $verificationCode = OtpVerificationCode::Where('user_id', $worker->id)->latest()->first;
        $now = Carbon::now();
        if($verificationCode && $now->isBefore($verificationCode->expire_at))
        {
            return $verificationCode;
        }
        //create a new OTP
        return OtpVerificationCode::create([
            'user_id'=>$worker->id,
            'otp'=> rand(123456,999999),
            'expire_at'=>Carbon::now()->addMinutes(10),

        ]);

    }
}
