<?php
namespace App\Http\Controllers\Admin;
namespace App\Http\Controllers\Office;
use App\Http\Controllers\Controller;
use App\Models\applicationStatus;
use App\Models\employerModel;
use App\Models\MainFormModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Models\Abaocwwb;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Storage;
use Validator;

class OfficeinfoController extends Controller
{
    protected $officeinfo;
    public function __construct(Abaocwwb $officedata)
    {
        $this->officeinfo = $officedata;
    }
    public function officeloginSuccess()
    {
        $sessionvalue = session()->all();
        $usernamedisplay=$sessionvalue["usersessionvalue"]["username"];
        $user_id=$sessionvalue["usersessionvalue"]["user_id"];
        $office_id=$sessionvalue["usersessionvalue"]["office_id"];
        $data['users'] = DB::table('User.users')->where('users.username',$usernamedisplay)->first();
        $loginfirstattemptvalue = $sessionvalue["usersessionvalue"]["pwd_ch_first_attempt"];
        try {
            if($data['users']->id == $user_id)
            {
                $rowCount = MainFormModel::where('office_id',$office_id)->count();
                $countApproved =MainFormModel::where('status', 'F')
                    ->where('office_id',$office_id)->count();
                $countPending =MainFormModel::whereIn('status', ['A', 'B'])->where('office_id',$office_id)->count();
                $countRejected = MainFormModel::where('status', 'D')->count();
                $data= DB::table('Worker.worker_main_form_models as wfm')
                    ->join('Worker.worker_main_basic_details as wmbd','wfm.worker_id','=','wmbd.worker_id')
                    ->join('User.users as user','wfm.office_id','=','user.office_id')
                    ->where('wfm.office_id',$data['users']->office_id)
                    ->where('user.role_id',$data['users']->role_id)
                    ->where(function ($query) {
                        $query->where('wfm.status', 'A')
                            ->orWhere('wfm.status', 'B');
                    })
                    ->select('wfm.worker_id','wfm.phone_no','wfm.created_at','wmbd.first_name','wmbd.last_name')
                    ->get();
            }

            else{
                $countPending =MainFormModel::where('status', 'C')->count();
                $countApproved =MainFormModel::where('status', 'B')->count();
                $rowCount = MainFormModel::where('status', 'C')->count();
                $data= DB::table('Worker.worker_main_form_models as wfm')
                    ->join('Worker.worker_main_basic_details as wmbd','wfm.worker_id','=','wmbd.worker_id')
                    ->join('User.users as user','wfm.office_id','=','user.office_id')
                    ->where('wfm.status','C')
                    ->where('wfm.office_id',$data['users']->office_id)
                    ->where('user.role_id',$data['users']->role_id)
                    ->select('wfm.worker_id','wfm.phone_no','wfm.created_at','wmbd.first_name','wmbd.last_name')
                    ->get();
            }

        }
        catch(\Exception $e){
            return response()->json(['error' => 'Database error'], 500);
        }

        if($loginfirstattemptvalue == 1)
        {
            return view('office.officeuserdashboard',compact('usernamedisplay','loginfirstattemptvalue','data','countApproved','countPending','countRejected'),['rowCount' => $rowCount]);
        }
        else
        {
            return view('office.officeuserchangepwd',compact('usernamedisplay','loginfirstattemptvalue'));
        }

    }
    public function logout(){
        $sessionvalue = session()->all();
        $tablename = 'User.users';
        $userid =  $sessionvalue['usersessionvalue']['user_id'];
        $checkuser = $this->officeinfo->getUserInfobyId($tablename,$userid);
        Session::flush();
        $status = 'sucess';
        $action = 'logout';
        $this->userlog($checkuser,$status,$action);
        return Redirect::to('/');
    }
    public function changePassword(Request $request)
    {
        $sessionvalue = session()->all();
        $oldpassword = $request->input('oldusrpwd');
        $newpassword = $request->input('newusrpwd');
        $hashpwd = Hash::make($newpassword);
        $confirmpassword = $request->input('confusrpwd');
        $tablename = 'User.users';
        $userid =  $sessionvalue['usersessionvalue']['user_id'];
        $checkuser = $this->officeinfo->getUserInfobyId($tablename,$userid);
        if(Hash::check($oldpassword,$checkuser[0]->password))
        {
            if($oldpassword !=$newpassword)
            {
                if($newpassword == $confirmpassword)
                {
                    $validated = $request->validate(
                        [
                            'newusrpwd' => 'required|min:8',
                            'confusrpwd' => 'required|min:8'
                        ],
                        [

                            'newusrpwd.required'=>'New Password Cannot Be Blank',
                            'newusrpwd.min'=>'New Password Must Contain Minimum 8 Characters',
                            'confusrpwd.required'=>'Confirm Password Cannot Be Blank',
                            'confusrpwd.min'=>'Confirm Password Must Contain Minimum 8 Characters'
                        ]
                    );
                    if($validated == TRUE)
                    {
                        $updatearr = array('password'=>$hashpwd,'pwd_ch_first_attempt'=>1);
                        $wherearr = array(['id','=',$userid]);
                        $this->officeinfo->updateData($tablename,$updatearr,$wherearr);
                        return response()->json(['msg' => 'Password Changed Successfully.'], 200);

                    }

                }
                else
                {
                    $msgarr = array('message'=>'The given data was invalid.','errors'=>array('conf_pwd_match'=>array('0'=>'**New Password and Confirm Password Doesnot match.')));
                    return response()->json($msgarr, 422);
                }

            }
            else
            {
                $msgarr = array('message'=>'The given data was invalid.','errors'=>array('new_pwd_match'=>array('0'=>'**New Password should not be same as  old Password.')));
                return response()->json($msgarr, 422);
            }

        }
        else
        {
            $msgarr = array('message'=>'The given data was invalid.','errors'=>array('old_pwd_match'=>array('0'=>'**Old Password Doesnot Match')));
            return response()->json($msgarr, 422);
        }

    }

    public function applicationReceived()
    {
        $sessionvalue = session()->all();
        $usernamedisplay = $sessionvalue["usersessionvalue"]["username"];
        $data['users'] = DB::table('User.users')->where('users.username', $usernamedisplay)->first();
        $loginfirstattemptvalue = $sessionvalue["usersessionvalue"]["pwd_ch_first_attempt"];
        $rowCount = MainFormModel::count();
        $countApproved = MainFormModel::where('status', 'F')->count();
        $countPending = MainFormModel::where('status', 'A')->count();
        try {

            $rowCount = MainFormModel::count();
            $countApproved = MainFormModel::where('status', 'F')->count();
            $countPending = MainFormModel::where('status', 'A')->count();
            $data = DB::table('Worker.worker_main_form_models as wfm')
                ->join('Worker.worker_main_basic_details as wmbd', 'wfm.worker_id', '=', 'wmbd.worker_id')
                ->join('User.users as user', 'wfm.office_id', '=', 'user.office_id')
//                ->where('wfm.status', 'A')
                ->where('wfm.office_id', $data['users']->office_id)
                ->where('user.role_id', $data['users']->role_id)
                ->select('wfm.worker_id', 'wfm.phone_no', 'wfm.created_at', 'wmbd.first_name', 'wmbd.last_name')
                ->get();
        }
//            else{
//                $rowCount = MainFormModel::where('status', 'C')->count();
////                $countApproved =MainFormModel::where('status', 'F')->count();
////                $countPending =MainFormModel::where('status', 'A')->count();
//                $data= DB::table('Worker.worker_main_form_models as wfm')
//                    ->join('Worker.worker_main_basic_details as wmbd','wfm.worker_id','=','wmbd.worker_id')
//                    ->join('User.users as user','wfm.office_id','=','user.office_id')
//                    ->where('wfm.status','C')
//                    ->where('wfm.office_id',$data['users']->office_id)
//                    ->where('user.role_id',$data['users']->role_id)
//                    ->select('wfm.worker_id','wfm.phone_no','wfm.created_at','wmbd.first_name','wmbd.last_name')
//                    ->get();
//            }


//     }
        catch(\Exception $e){
            return response()->json(['error' => 'Database error'], 500);
        }


            return view('office.application-received',compact('usernamedisplay','loginfirstattemptvalue','data','countApproved','countPending'),['rowCount' => $rowCount]);


    }

    public function applicationApproved()
    {
        $sessionvalue = session()->all();
        $usernamedisplay = $sessionvalue["usersessionvalue"]["username"];
        $data['users'] = DB::table('User.users')->where('users.username', $usernamedisplay)->first();
        $loginfirstattemptvalue = $sessionvalue["usersessionvalue"]["pwd_ch_first_attempt"];
        $rowCount = MainFormModel::count();
        $countApproved = MainFormModel::where('status', 'F')->count();
        $countPending = MainFormModel::where('status', 'A')->count();
        try {

            $rowCount = MainFormModel::count();
            $countApproved = MainFormModel::where('status', 'F')->count();
            $countPending = MainFormModel::where('status', 'A')->count();
            $data = DB::table('Worker.worker_main_form_models as wfm')
                ->join('Worker.worker_main_basic_details as wmbd', 'wfm.worker_id', '=', 'wmbd.worker_id')
                ->join('User.users as user', 'wfm.office_id', '=', 'user.office_id')
                ->where('wfm.status', 'F')
                ->where('wfm.office_id', $data['users']->office_id)
                ->where('user.role_id', $data['users']->role_id)
                ->select('wfm.worker_id', 'wfm.phone_no', 'wfm.created_at', 'wmbd.first_name', 'wmbd.last_name')
                ->get();
        }

        catch(\Exception $e){
            return response()->json(['error' => 'Database error'], 500);
        }


        return view('office.application-approved',compact('usernamedisplay','loginfirstattemptvalue','data','countApproved','countPending'),['rowCount' => $rowCount]);


    }

    public function applicationDetails($id)
    {
        $sessionvalue = session()->all();
        $usernamedisplay=$sessionvalue["usersessionvalue"]["username"];
        $data['username'] = DB::table('User.users')->where('users.username','=',$usernamedisplay)->first();
        $data['da'] = DB::table('User.users as user')
            ->join('Masterdata.roles as role','user.role_id','=','role.id')
            ->where('user.office_id',$data['username']->office_id)
            ->where('role_id',4)
            ->get();

        $data['ro'] = DB::table('User.users as user')
            ->join('Masterdata.roles as role','user.role_id','=','role.id')
            ->where('user.office_id',$data['username']->office_id)
            ->where('role_id',3)
            ->get();

        $data['tfm'] = DB::table('Worker.worker_main_form_models')->where('worker_id', $id)->first();
        $data['twbd'] = DB::table('Worker.worker_main_basic_details')->where('worker_id', $id)->first();
        $data['twam'] = DB::table('Worker.worker_main_address')->where('worker_id', $id)->first();
        $data['twfm'] =  DB::table('Worker.main_worker_family')->where('worker_id', $id)->get();
        $data['twbm'] = DB::table('Worker.worker_main_bank_details')->where('worker_id', $id)->first();
        $data['twed'] = DB::table('Worker.worker_main_employer_details')->where('worker_id', $id)->first();
        $data['twc'] =  DB::table('Worker.main_worker_certificate')->where('worker_id', $id)->get();
        $data['tws'] = DB::table('Worker.worker_main_schemes')->where('worker_id',$id)->get();
        $data['twd'] = DB::table('Worker.worker_main_documents')->where('worker_id', $id)->first();

        $data['twbdjoin']
            = DB::table('Worker.worker_main_basic_details as twbd')
            ->join('Masterdata.gender as gen', 'twbd.gender', '=', 'gen.gender_code')
            ->join('Masterdata.marital_status as ms', 'twbd.maritial_status', '=', 'ms.marital_code')
            ->join('Masterdata.education as edu', 'twbd.education', '=', 'edu.education_code')
            ->join('Masterdata.category as cat', 'twbd.category', '=', 'cat.category_code')
            ->where('twbd.worker_id', $id)
            ->select('twbd.*','gen.*', 'ms.*', 'cat.*', 'edu.*')
            ->first();
        $data['twamjoin'] = DB::table('Worker.worker_main_address as twam')
            ->join('Masterdata.residence as cres', 'twam.c_residence', '=', 'cres.residence_code')
            ->join('Masterdata.residence as pres', 'twam.p_residence', '=', 'pres.residence_code')
            ->join('Masterdata.house as chs', 'twam.c_house_type', '=', 'chs.house_code')
            ->join('Masterdata.house as phs', 'twam.p_house_type', '=', 'phs.house_code')
            ->join('Masterdata.state as cst', 'twam.c_state', '=', 'cst.state_code')
            ->join('Masterdata.state as pst', 'twam.p_state', '=', 'pst.state_code')
            ->join('Masterdata.district as cds', 'twam.c_district', '=', 'cds.district_code')
            ->join('Masterdata.district as pds', 'twam.p_district', '=', 'pds.district_code')
            ->join('Masterdata.subdistrict as scds', 'twam.c_circle', '=', 'scds.subdistrict_code')
            ->join('Masterdata.subdistrict as spds', 'twam.p_circle', '=', 'spds.subdistrict_code')
            ->join('Masterdata.podetails as cpo', 'twam.c_post_office', '=', 'cpo.poid')
            ->join('Masterdata.podetails as ppo', 'twam.p_post_office', '=', 'ppo.poid')
            ->where('twam.worker_id', $id)
            ->select('twam.*','cres.*', 'pres.*', 'chs.*', 'phs.*', 'cst.*', 'pst.*', 'cds.*', 'pds.*','scds.*','spds.*','cpo.*','ppo.*')
            ->first();
        $data['twedjoin'] = DB::table('Worker.worker_main_employer_details as twed')
            ->join('Masterdata.type_of_work as tow','twed.type_of_work','=','tow.work_type_code')
            ->join('Masterdata.nature_of_work as now','twed.nature_of_work','=', 'now.nature_of_work_code')
            ->join('Masterdata.district as cds', 'twed.district', '=', 'cds.district_code')
            ->join('Masterdata.subdistrict as sd', 'twed.subdistrict', '=', 'sd.subdistrict_code')
            ->where('twed.worker_id',$id)
            ->select('twed.*','tow.*','now.*','cds.*','sd.*')
            ->first();
        $data['twcjoin'] = DB::table('Worker.main_worker_certificate as twc')
            ->join('Masterdata.type_of_issuer_table as toi','twc.type_of_issuer','=','toi.issuer_code')
            ->where('twc.worker_id',$id)
            ->select('twc.*','toi.*')
            ->get();
        $data['twsjoin'] = DB::table('Worker.worker_main_schemes as tws')
            ->join('Masterdata.schemes as sc','tws.scheme_name','=','sc.scheme_code')
            ->where('tws.worker_id',$id)
            ->select('tws.*','sc.*')
            ->get();
        $data['twdcj'] = DB::table('Worker.worker_main_documents as twdc')
            ->join('Masterdata.age_proof as apt','twdc.age_proof_id','=','apt.age_proof_code')
            ->where('twdc.worker_id',$id)
            ->select('twdc.*','apt.*')
            ->get();
        $data['states'] = DB::table('Masterdata.state')->select('state_code', 'state_name')->orderBy('state_name')->get();
        $data['districts'] = DB::table('Masterdata.district')->select('district_code', 'district_name')->orderBy('district_name')->get();
        $data['residence'] = DB::table('Masterdata.residence')->where('residence_code', '!=', $data['twamjoin']->residence_code)->get();
        $data['house'] = DB::table('Masterdata.house')->where('house_code', '!=', $data['twamjoin']->house_code)->get();
        $data['gender'] = DB::table('Masterdata.gender')->where('gender_code', '!=',  $data['twbdjoin']->gender_code)->get();
        $data['marital'] = DB::table('Masterdata.marital_status')->where('marital_code', '!=',  $data['twbdjoin']->marital_code)->get();
        $data['category'] = DB::table('Masterdata.category')->where('category_code', '!=',  $data['twbdjoin']->category_code)->get();
        $data['education'] = DB::table('Masterdata.education')->where('education_code', '!=',  $data['twbdjoin']->education_code)->get();
        $data['now'] = DB::table('Masterdata.nature_of_work')->where('nature_of_work_code','!=',$data['twedjoin']->nature_of_work_code)->get();
        $data['tow'] = DB::table('Masterdata.type_of_work')->where('work_type_code','!=', $data['twedjoin']->work_type_code)->get();
//        dd($data);
//        exit();
        return view('office.office-applications',$data,$sessionvalue);

    }
    public function getIdProof($id,$worker_id)
    {
        $id_proof = DB::table('Worker.temp_worker_documents')
            ->where('worker_id',$worker_id)
            ->first();
        $headers = ['Content-Type' => 'application/pdf'];
        $file = Storage::path($id_proof->id_proof);
//         dd($file);
        return response()->file($file);
    }

    public function getResProof($id,$worker_id)
    {

        $res_proof = DB::table('Worker.temp_worker_documents')
            ->where('worker_id',$worker_id)
            ->first();
        $headers = ['Content-Type' => 'application/pdf'];
        $file = Storage::path($res_proof->residential_proof);
        return response()->file($file);

    }

    public function getAgeProof($id,$worker_id)
    {
        $session_worker_id = session()->get('worker_id');
        $age_proof = DB::table('Worker.temp_worker_documents')
            ->where('worker_id',$session_worker_id)
            ->first();
        $headers = ['Content-Type' => 'application/pdf'];
        $file = Storage::path($age_proof->age_proof);
        return response()->file($file);

    }
    public function getBankXerox($id,$worker_id)
    {
        $session_worker_id = session()->get('worker_id');
        $pass_xerox = DB::table('Worker.temp_worker_documents')
            ->where('worker_id',$session_worker_id)
            ->first();
        $headers = ['Content-Type' => 'application/pdf'];
        $file = Storage::path($pass_xerox->passbook_xerox_proof);
        return response()->file($file);

    }
    public function getCertProof($id,$worker_id)
    {
        $session_worker_id = session()->get('worker_id');
        $cert_proof = DB::table('Worker.temp_worker_documents')
            ->where('worker_id',$session_worker_id)
            ->first();
        $headers = ['Content-Type' => 'application/jpg'];
        $file = Storage::path($cert_proof->certificate_proof);
        return response()->file($file);
    }
    public function getPassport($id,$worker_id)
    {
        $session_worker_id = session()->get('worker_id');
        $passport = DB::table('Worker.temp_worker_documents')
            ->where('worker_id',$session_worker_id)
            ->first();
        $headers = ['Content-Type' => 'application/jpg'];
        $file = Storage::path($passport->passport_image);
        return response()->file($file);
    }
    public function getThumb($id,$worker_id)
    {

        $thumb = DB::table('Worker.temp_worker_documents')
            ->where('worker_id',$worker_id)
            ->first();
        $headers = ['Content-Type' => 'application/jpg'];
        $file = Storage::path($thumb->thumb_image);
        return response()->file($file);
    }
    public function getAddress($id,$worker_id)
    {

        $address_proof = DB::table('Worker.temp_worker_documents')
            ->where('worker_id',$worker_id)
            ->first();
        $headers = ['Content-Type' => 'application/jpg'];
        $file = Storage::path($address_proof->address_proof);
        return response()->file($file);
    }
    public function getBankCopy($id,$worker_id)
    {

        $getBankCopy = DB::table('Worker.temp_worker_documents')
            ->where('worker_id',$worker_id)
            ->first();
        $headers = ['Content-Type' => 'application/jpg'];
        $file = Storage::path($getBankCopy->bank_passbook);
        return response()->file($file);

    }
    public function decl($id,$worker_id)
    {

        $decl = DB::table('Worker.temp_worker_documents')
            ->where('worker_id',$worker_id)
            ->first();
        $headers = ['Content-Type' => 'application/jpg'];
        $file = Storage::path($decl->declaration_file);
        return response()->file($file);

    }
    public function approveApplication(Request $request)
    {
        $sessionvalue = session()->all();
        $usernamedisplay=$sessionvalue["usersessionvalue"]["username"];
        $data = DB::table('User.users')->where('users.username',$usernamedisplay)->first();

        $data = applicationStatus::Create([
            'application_id' => $request->application_id,
            'application_status' => env('APPLICATION_FINAL_APPROVED'),
            'remarks' => $request->remarks,
            'role_id' => $data->role_id,
            'office_id' => $data->office_id,
            'user_id' => $data->id,
            'from_user'=> $data->id,
        ]);
        $application = $request->application_id;
        $data = MainFormModel::where('worker_id', $application)->update([
            'status' => env('APPLICATION_FINAL_APPROVED'),
        ]);

        return redirect()->route('officeloginsuccess')->with('msg','Application Approved Successfully');

    }
    public function rejectApplication(Request $request)
    {
        $sessionvalue = session()->all();
        $usernamedisplay=$sessionvalue["usersessionvalue"]["username"];
        $data = DB::table('User.users')->where('users.username',$usernamedisplay)->first();

        $data = applicationStatus::Create([
            'application_id' => $request->application_id,
            'application_status' => env('APPLICATION_REJECT'),
            'remarks' => $request->remarks,
            'role_id' => $data->role_id,
            'office_id' => $data->office_id,
            'user_id' => $data->id,
            'from_user'=> $data->id,
        ]);
        $application = $request->application_id;
        $data = MainFormModel::where('worker_id', $application)->update([
            'status' => env('APPLICATION_REJECT'),
        ]);

        return redirect()->route('officeloginsuccess')->with('msg','Application Approved Successfully');
    }
    public function forwardApplication(Request $request)
    {
        $sessionvalue = session()->all();
        $usernamedisplay=$sessionvalue["usersessionvalue"]["username"];
        $data = DB::table('User.users')->where('users.username',$usernamedisplay)->first();

        $data = applicationStatus::Create([
            'application_id' => $request->application_id,
            'application_status' => env('DEALING_ASSISTANT'),
            'remarks' => $request->remarks,
            'role_id' => $data->role_id,
            'office_id' => $data->office_id,
            'user_id' => $data->id,
            'from_user'=> $data->username,
            'to_user' => $request->role_id,
        ]);
        $application = $request->application_id;
        $data = MainFormModel::where('worker_id', $application)->update([
            'status' => env('DEALING_ASSISTANT'),
        ]);
        return redirect()->route('officeloginsuccess')->with('msg','Application Forwarded Successfully');
    }
    public function forwardApplicationRo(Request $request)
    {
        $sessionvalue = session()->all();
        $usernamedisplay=$sessionvalue["usersessionvalue"]["username"];
        $data = DB::table('User.users')->where('users.username',$usernamedisplay)->first();

        $data = applicationStatus::Create([
            'application_id' => $request->application_id,
            'application_status' => env('REGISTERING_OFFICER'),
            'remarks' => $request->remarks,
            'role_id' => $data->role_id,
            'office_id' => $data->office_id,
            'user_id' => $data->id,
            'from_user'=> $data->username,
            'to_user' => $request->role_id,
        ]);

        $application = $request->application_id;
        $data = MainFormModel::where('worker_id', $application)->update([
            'status' => env('REGISTERING_OFFICER'),
        ]);
        return redirect()->route('officeloginsuccess')->with('msg','Application Forwarded to RO Successfully');
    }
}

