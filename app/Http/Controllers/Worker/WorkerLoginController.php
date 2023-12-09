<?php

namespace App\Http\Controllers\Worker;
use App\Http\Controllers\Controller;
use App\Models\MainFormModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;


class WorkerLoginController extends Controller
{
    public function index()
    {
        if(session()->get('worker-session') == true)
        {
            return redirect()->route('worker-dashboard');
        }
        return view('worker.workerLogin');
    }

    /** Worker Login
     * @param Request $request
     * @return JsonResponse
     */

    public function workerLogin(Request $request)
    {
        $validate = $request->validate([
            'phone_no' => 'required',
            'otp' => 'required',
        ],[
            'phone_no.required' => 'Phone No Cannot Be Blank',
            'otp.required' => 'OTP Cannot Be Blank',
            ]);
        $phone_no = $request->input('phone_no');
        $otp = $request->input('otp');
        $worker = DB::table('Worker.worker_main_form_models')
            ->where('phone_no',$phone_no)
            ->first();
        if ($worker && $otp === "45789") {
            session()->put('worker', $worker);
            session()->put('worker-session', true);
            return response()->json(['message' => 'Login successful','status'=>'true', 'redirect' => '/worker-dashboard']);
        } else {
            return response()->json(['message' => 'Phone No or OTP does not match','status'=>'false']);
        }

    }
    public function loginDash(Request $request)
    {

        if(session()->get('worker-session') != true)
        {
            return Redirect::to('/');
        }
        $record['worker'] = session()->get('worker');
        $record['status'] = DB::table('Worker.worker_application_status')->first();
     $data['wrkr'] = DB::table('Worker.worker_main_basic_details')->where('worker_id',$record['worker']->worker_id)->first();
        return view('worker.workerdashboard',$record,$data)->with('success','User logged in successfully!');
    }

    public function logoutUser(Request $request)
    {
        session::flush();
        session()->flush();
        session()->regenerate(true);
        return Redirect::to('/');
    }
    public function getProfile()
    {
        if(session()->get('worker-session') != true)
        {
            return Redirect::to('/');
        }
        $record['worker'] =$workerValue = session()->get('worker');
        $data['user'] = DB::table('Worker.worker_main_form_models as wfm')
                        ->join('Worker.worker_main_basic_details as wmbd','wfm.worker_id','=','wmbd.worker_id')
                        ->join('Masterdata.gender as gen', 'wmbd.gender', '=', 'gen.gender_code')
                        ->join('Masterdata.category as cat', 'wmbd.category', '=', 'cat.category_code')
                        ->where('wfm.worker_id',$workerValue->worker_id)
                        ->select('wfm.*','wmbd.*','gen.*','cat.*')
                        ->first();
        $data['wrkr'] = DB::table('Worker.worker_main_basic_details')->where('worker_id',$record['worker']->worker_id)->first();
        return view('worker.workerProfile',$data);
    }



}
