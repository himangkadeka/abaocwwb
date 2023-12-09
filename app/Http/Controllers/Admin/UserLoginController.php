<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Models\Abaocwwb;
use Carbon\Carbon;
use Auth;
use Validator;

class UserLoginController extends Controller
{
    protected $userinfo;
    public function __construct(Abaocwwb $user)
    {
        $this->userinfo = $user;
    }
    public function index()
    {
        return view('admin.userlogin');
    }
    public function reloadCaptcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }
    public function checkLogin(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $captcha =  $request->input('captcha');
        $validated = $request->validate(
                [
                    'username' => 'required',
                    'password' => 'required|min:8',
                    'captcha' => 'required|captcha'
                    
                ],
                [
                    'username.required'=>'Username Cannot be Blank',
                    'password.required'=>'Password Cannot be Blank',
                    'password.min' => 'Password Must Contain Minimum 8 Characters',
                    'captcha.required'=>'Captcha Cannot be Blank',
                    'captcha.captcha'=>'Captcha Does Not Match'
                ]
        );
        if ($validated == TRUE) {
            $tablename = 'User.users';
            $checkuser = $this->userinfo->getUserInfo($tablename,$username);
            if(($checkuser->count()) == 1 && $checkuser[0]->role_id == 1 && $checkuser[0]->status== 1)
            {
                if(Hash::check($password,$checkuser[0]->password))
                {
                    $usersessionarr = array('user_id'=>$checkuser[0]->id,'username'=>$checkuser[0]->username,'role_id'=>$checkuser[0]->role_id,'office_id'=>$checkuser[0]->office_id);
                    session()->put('usersessionvalue',$usersessionarr);
                    $status = 'sucess';
                    $action = 'login';
                    $usernamedisplay = $checkuser[0]->username;
                    $this->userlog($checkuser,$status,$action);
                    return response()->json(['msg' => 'sucess'], 200);
                }else
                {
                    $status = 'fail';
                    $action = 'login';
                    $this->userlog($checkuser,$status,$action);
                    $msgarr = array('message'=>'The given data was invalid.','errors'=>array('invalid_user'=>array('0'=>'**Invalid Password')));
                    return response()->json($msgarr, 422); 
                }

            }else
            {
                $status = 'fail';
                $action = 'login';
                $checkuser[0] = (object)array('id'=>0,'username'=>$username);
                $this->userlog($checkuser,$status,$action);
                $msgarr = array('message'=>'The given data was invalid.','errors'=>array('invalid_user'=>array('0'=>'**User Dosenot Exists')));
                    return response()->json($msgarr, 422); 
            }
       }
    }
    public function checkofficeLogin(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $captcha =  $request->input('captcha');
        $validated = $request->validate(
                [
                    'username' => 'required',
                    'password' => 'required|min:8',
                    'captcha' => 'required|captcha'
                    
                ],
                [
                    'username.required'=>'Username Cannot be Blank',
                    'password.required'=>'Password Cannot be Blank',
                    'password.min' => 'Password Must Contain Minimum 8 Characters',
                    'captcha.required'=>'Captcha Cannot be Blank',
                    'captcha.captcha'=>'Captcha Does Not Match'
                ]
        );
        if ($validated == TRUE) {
            $tablename = 'User.users';
            $checkuser = $this->userinfo->getUserInfo($tablename,$username);
            if(($checkuser->count()) == 1 && $checkuser[0]->role_id != 1 && $checkuser[0]->status== 1)
            {
                if(Hash::check($password,$checkuser[0]->password))
                {
                    $usersessionarr = array('user_id'=>$checkuser[0]->id,'username'=>$checkuser[0]->username,'role_id'=>$checkuser[0]->role_id,'office_id'=>$checkuser[0]->office_id,'pwd_ch_first_attempt'=>$checkuser[0]->pwd_ch_first_attempt);
                    session()->put('usersessionvalue',$usersessionarr);
                    $status = 'sucess';
                    $action = 'login';
                    $usernamedisplay = $checkuser[0]->username;
                    $this->userlog($checkuser,$status,$action);
                    return response()->json(['msg' => 'sucess'], 200);
                }else
                {
                    $status = 'fail';
                    $action = 'login';
                    $this->userlog($checkuser,$status,$action);
                    $msgarr = array('message'=>'The given data was invalid.','errors'=>array('invalid_user'=>array('0'=>'**Invalid Password')));
                    return response()->json($msgarr, 422); 
                }

            }else
            {
                $status = 'fail';
                $action = 'login';
                $checkuser[0] = (object)array('id'=>0,'username'=>$username);
                $this->userlog($checkuser,$status,$action);
                $msgarr = array('message'=>'The given data was invalid.','errors'=>array('invalid_user'=>array('0'=>'**User Dosenot Exists Or User Deactivated.')));
                return response()->json($msgarr, 422); 
            }
       }
    }

    public function loginSucess()
    {
        $sessionvalue = session()->all();
        $usernamedisplay=$sessionvalue["usersessionvalue"]["username"];
        return view('admin.admindashboard',compact('usernamedisplay'));
    }
    public function logout(){
        $sessionvalue = session()->all();
        $tablename = 'User.users'; 
        $userid =  $sessionvalue['usersessionvalue']['user_id'];
        $checkuser = $this->userinfo->getUserInfobyId($tablename,$userid);
        Session::flush();
        $status = 'sucess';
        $action = 'logout';
        $this->userlog($checkuser,$status,$action);
        return Redirect::to('/');
    }
    public function userlog($checkuser,$status,$action)
    {
        $currentTime = Carbon::now();
        $accesstime = $currentTime->toDateTimeString(); 
        $server_add = $_SERVER['REMOTE_ADDR'];
        $userlogarr = array('user_id'=>$checkuser[0]->id,'username'=>$checkuser[0]->username,'ip_add'=>$server_add,'action'=>$action,'status'=>$status,'access_time'=>$accesstime);
        $userlogarr_json = json_encode($userlogarr);
        $userlogdetail = array('log_details'=> $userlogarr_json);
        $tablename = 'User.userlogs';
        $this->userinfo->insertData($tablename,$userlogdetail);
    }
}
