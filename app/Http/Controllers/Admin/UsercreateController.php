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
class UsercreateController extends Controller
{
    protected $usercreateinfo;
    public function __construct(Abaocwwb $usercreate)
    {
        $this->usercreateinfo = $usercreate;
    }
    public function userlistentryform()
    {
        $sessionvalue = session()->all(); 
        $table = 'User.users as u';
        $table1 = 'Masterdata.roles as r';
        $table2 = 'Masterdata.office as o';
        $table3 = 'Masterdata.designation as d';
        $cond = 'u.role_id';
        $cond1 = 'r.id';
        $cond2 = 'u.office_id';
        $cond3 = 'o.office_id';
        $cond4 = 'u.desig_id';
        $cond5 = 'd.id';
        $equal = '=';
        $selectfield = [['u.*','r.role_name','o.office_name','d.designation']];
        $order = 'u.id';
        $userdatainfo = $this->usercreateinfo->innerjoinfourtables($table,$table1,$table2,$table3,$cond,$cond1,$cond2,$cond3,$cond4,$cond5,$equal,$selectfield,$order,$wherearr = NULL);
        $allofficeinfo = $this->usercreateinfo->getAllData($table2);
        $allroleinfo = $this->usercreateinfo->getAllData($table1);
        $alldesignationinfo = $this->usercreateinfo->getAllData($table3);
        if(isset($sessionvalue['usersessionvalue']))
        {
            $usernamedisplay = $sessionvalue['usersessionvalue']['username'];
            return view('admin.userentryform',compact('usernamedisplay','userdatainfo','allofficeinfo','allroleinfo','alldesignationinfo'));
        }
        else
        {
            return redirect()->to('/');   
        }

    }
    public function addUser(Request $request)
    {
        $sessionvalue = session()->all();
        if(isset($sessionvalue['usersessionvalue']))
        {
            Validator::extend('alpha_spaces', function ($attribute, $value) {
                return preg_match('/^[\pL\s]+$/u', $value);  
            });
            $username = $request->input('username');
            $password = $request->input('password');
            $hashpwd = Hash::make($password);
            $firstname = $request->input('firstname');
            $lastname = $request->input('lastname');
            $phone = $request->input('phone');
            $email = $request->input('email');
            $desig = $request->input('desig');
            $officeid = $request->input('officeid');
            $role = $request->input('role');
            $status = '0';
            $pwdch_status = '0';
            $currentTime = Carbon::now();
            $createtime = $currentTime->toDateTimeString();

            $validated = $request->validate(
                [
                    'username'=>'required',
                    'password' => 'required|min:8',
                    'firstname' => 'required|alpha_spaces',
                    'lastname' => 'required|alpha_spaces',
                    'phone'=> 'required|min:10|numeric',
                ],
                [
                    'username.required'=>'Username Cannot Be Blank',
                    'password.required'=>'Password Cannot Be Blank',
                    'password.min'=>'Password Must Contain Minimum 8 Characters',
                    'firstname.required'=>'First Name Cannot be Blank',
                    'firstname.alpha_spaces' => 'First Name Should conatin letters only',
                    'lastname.required'=>'Last Name Cannot be Blank',
                    'lastname.alpha_spaces' => 'Last Name Should conatin letters only',
                    'phone.required'=>'Phone No. Cannot be Blank',
                    'phone.min'=>'Phone No Must Contain Minimum 10 Numbers',
                    'phone.numeric'=>'Phone No Must Contain only Numeric value',
                ]
            );
            if($validated == TRUE)
            {
                $tablename = 'User.users';
                $getid = $this->usercreateinfo->getAllData($tablename)->last()->id;
                $id = $getid+1;
                $insertarr = array('id'=>$id,'username'=>$username,'password'=>$hashpwd,'firstname'=>$firstname,'lastname'=>$lastname,'phone'=>$phone,'email'=>$email,'role_id'=>$role,'office_id'=> $officeid,'created_on'=>$createtime,'desig_id'=>$desig,'status'=>$status,'pwd_ch_first_attempt'=>$pwdch_status);
                $this->usercreateinfo->insertData($tablename,$insertarr);
                return response()->json(['msg' => 'User Created Sucessfully.'], 200);

            }
        }
        else
        {
            return redirect()->to('/');
        }
    }
    public function enableUser(Request $request)
    {
        $sessionvalue = session()->all();
        if(isset($sessionvalue['usersessionvalue']))
        {
            $id = $request->input('id');
            $tablename = 'User.users';
            $updatearr = array('status'=>1);
            $wherearr = array(['id','=',$id]);
            $this->usercreateinfo->updateData($tablename,$updatearr,$wherearr);
            return response()->json(['msg' => 'User Status Enabled Sucessfully.'], 200);
        }
        else
        {
            return redirect()->to('/');
        }
    }
    public function disableUser(Request $request)
    {
        $sessionvalue = session()->all();
        if(isset($sessionvalue['usersessionvalue']))
        {
            $id = $request->input('id');
            $tablename = 'User.users';
            $updatearr = array('status'=>0);
            $wherearr = array(['id','=',$id]);
            $this->usercreateinfo->updateData($tablename,$updatearr,$wherearr);
            return response()->json(['msg' => 'User Status Disabled Sucessfully.'], 200);
        }
        else
        {
            return redirect()->to('/');
        }
    }
}