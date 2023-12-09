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

class MasterdataController extends Controller
{
    protected $masterdatainfo;
    public function __construct(Abaocwwb $masterdata)
    {
        $this->masterdatainfo = $masterdata;
    }
    public function stateentryForm()
    {
        $sessionvalue = session()->all();
        $tablename = 'Masterdata.state';
        $allstateinfo = $this->masterdatainfo->getAllData($tablename);   
        if(isset($sessionvalue['usersessionvalue']))
        {
            $usernamedisplay = $sessionvalue['usersessionvalue']['username'];
            return view('admin.stateentryform',compact('usernamedisplay','allstateinfo'));
        }else
        {
            return redirect()->to('/');
        }
    }
    public function addState(Request $request)
    {
        $sessionvalue = session()->all(); 
        if(isset($sessionvalue['usersessionvalue']))
            {
            Validator::extend('alpha_spaces', function ($attribute, $value) {
                return preg_match('/^[\pL\s]+$/u', $value);  
            });
            $statecode = $request->input('statecode');
            $statename = $request->input('statename');
            $validated = $request->validate(
                [
                    'statecode' => 'required|numeric',
                    'statename' => 'required|alpha_spaces'
                    
                ],
                [
                    'statecode.required'=>'State Code Cannot be Blank',
                    'statecode.numeric'=>'State Code can only be Numeric',
                    'statename.required'=>'State Name Cannot be Blank',
                    'statename.alpha_spaces' => 'State Name Should conatin letters only'
                ]
            );
            if($validated == TRUE)
            {
                $tablename = 'Masterdata.state';
                $wherearr = array(['state_code','=',$statecode],['state_name','=',$statename]);
                $checkstate = $this->masterdatainfo->whereclause($tablename, $wherearr);
                $allstateinfo = $this->masterdatainfo->getAllData($tablename);
                if(($checkstate->count()) == '0')
                {
                    $currentTime = Carbon::now();
                    $createtime = $currentTime->toDateTimeString();
                    $insertarr = array('state_code'=>$statecode,'state_name'=>$statename,'created_on'=>$createtime);
                    $this->masterdatainfo->insertData($tablename,$insertarr);
                    $usernamedisplay = $sessionvalue['usersessionvalue']['username'];
                    return Redirect::back()->with('msg', 'State Added Sucessfully.');
                }
                else
                {
                    $usernamedisplay = $sessionvalue['usersessionvalue']['username'];
                    return view('admin.stateentryform',compact('usernamedisplay','allstateinfo'))->with('errmsg','State Name Already Exits.');
                }
            }
        }
        else
        {
            return redirect()->to('/'); 
        }
        
    }
    public function districtentryform()
    {
        $sessionvalue = session()->all(); 
        $table1 = 'Masterdata.district as dis';
        $table2 = 'Masterdata.state as st';
        $cond = 'st.state_code';
        $equal = '=';
        $secondcond = 'dis.state_code';
        $selectfield =[['dis.*','st.state_name']];
        $allstateinfo = $this->masterdatainfo->getAllData($table2);
        $alldistrictinfo = $this->masterdatainfo->innerjointwotables($table1,$table2,$cond,$equal,$secondcond,$selectfield);
        if(isset($sessionvalue['usersessionvalue']))
        {
            $usernamedisplay = $sessionvalue['usersessionvalue']['username'];
            return view('admin.districtentryform',compact('usernamedisplay','allstateinfo','alldistrictinfo'));
        }
        else
        {
            return redirect()->to('/');   
        }
    }
    public function addDistrict(Request $request)
    {
        $sessionvalue = session()->all(); 
        if(isset($sessionvalue['usersessionvalue']))
        {
            Validator::extend('alpha_spaces', function ($attribute, $value) {
                return preg_match('/^[\pL\s]+$/u', $value);  
            });
            $statecode = $request->input('state');
            $districtcode = $request->input('districtcode');
            $districtname = $request->input('districtname');
            $validated = $request->validate(
                [
                    'statecode' => 'not_in:""',
                    'districtcode' => 'required|numeric',
                    'districtname' => 'required|alpha_spaces'
                    
                ],
                [
                    'statecode.not_in'=>'Please Select a State',
                    'districtcode.required'=>'District Code Cannot Be Blank',
                    'districtcode.numeric'=>'District Code can only be Numeric',
                    'districtname.required'=>'District Name Cannot be Blank',
                    'districtname.alpha_spaces' => 'District Name Should conatin letters only'
                ]
            );
            if($validated == TRUE)
            {
                $table1 = 'Masterdata.district as dis';
                $table2 = 'Masterdata.state as st';
                $cond = 'st.state_code';
                $equal = '=';
                $secondcond = 'dis.state_code';
                $selectfield =[['dis.*','st.state_name']];
                $wherearrdistrictcode = array(['district_code','=',$districtcode]);
                $wherearrdistrictname = array(['district_name','like','%'.$districtname.'%']);
                $allstateinfo = $this->masterdatainfo->getAllData($table2);
                $checkdistrict = $this->masterdatainfo->whereclause($table1, $wherearrdistrictcode);
                $checkdistrictname = $this->masterdatainfo->whereclause($table1, $wherearrdistrictname);
                $alldistrictinfo = $this->masterdatainfo->innerjointwotables($table1,$table2,$cond,$equal,$secondcond,$selectfield);
                if(($checkdistrict->count()) != '0')
                {
                    $usernamedisplay = $sessionvalue['usersessionvalue']['username'];
                    return view('admin.districtentryform',compact('usernamedisplay','allstateinfo','alldistrictinfo'))->with('errmsg','District Code  Already Exits.');
                }
                elseif(($checkdistrictname->count()) !='0')
                {
                    $usernamedisplay = $sessionvalue['usersessionvalue']['username'];
                    return view('admin.districtentryform',compact('usernamedisplay','allstateinfo','alldistrictinfo'))->with('errmsg','District Name Already Exits.');
                }
                else
                {
                    $currentTime = Carbon::now();
                    $createtime = $currentTime->toDateTimeString();
                    $insertarr = array('district_code'=>$districtcode,'state_code'=>$statecode,'district_name'=>$districtname,'created_on'=>$createtime);
                    $this->masterdatainfo->insertData($table1,$insertarr);
                    $usernamedisplay = $sessionvalue['usersessionvalue']['username'];
                    return Redirect::back()->with('msg', 'Dsitrict Added Sucessfully.');
                }
            }
        }
        else
        {
            return redirect()->to('/');
        }    
    }
    public function postofficeentryForm()
    {
        set_time_limit(600);
        ini_set('memory_limit', '-1');
        $sessionvalue = session()->all(); 
        $table = 'Masterdata.podetails as po';
        $table1 = 'Masterdata.state as st';
        $table2 = 'Masterdata.district as dis';
        $cond = 'po.statecode';
        $cond1 = 'st.state_code';
        $cond2 = 'po.districtcode';
        $cond3 = 'dis.district_code';
        $equal = '=';
        $selectfield = [['po.*','st.state_name','dis.district_name']];
        $order = 'po.statecode';
        $allstateinfo = $this->masterdatainfo->getAllData($table1);
          if(isset($sessionvalue['usersessionvalue']))
          {
              $usernamedisplay = $sessionvalue['usersessionvalue']['username'];
              return view('admin.postofficeentryform',compact('usernamedisplay','allstateinfo'));
          }
          else
          {
            return redirect()->to('/');  
          }

    }
    public function getdistrictinfo(Request $request)
    {
        $table = 'Masterdata.district';
        $statecode = $request->input('statecode');
        $wherearr = array('state_code'=>$statecode);
        $districts = $this->masterdatainfo->whereclause($table,$wherearr);
        $returnstr[] = '<option  value="">--Select District--</option>';
        foreach($districts as $districtname){
            $returnstr[] ='<option value="'.$districtname->district_code.'">'.$districtname->district_name.'</option>';
        }
        return response()->json(array('districtinfo'=> $returnstr), 200);
    }
    public function getpostofficeinfo(Request $request)
    {
        $statecode = $request->input('statecode');
        $districtcode = $request->input('districtcode');
        $table = 'Masterdata.podetails as po';
        $table1 = 'Masterdata.state as st';
        $table2 = 'Masterdata.district as dis';
        $cond = 'po.statecode';
        $cond1 = 'st.state_code';
        $cond2 = 'po.districtcode';
        $cond3 = 'dis.district_code';
        $equal = '=';
        $wherearr = array('po.statecode'=>$statecode,'po.districtcode'=>$districtcode);
        $selectfield = [['po.*','st.state_name','dis.district_name']];
        $order = 'po.statecode';
        $i=1;
        $podata = $this->masterdatainfo->innerjointhreetables($table,$table1,$table2,$cond,$cond1,$cond2,$cond3,$equal,$selectfield,$order,$wherearr);
        if($podata->count() !='0')
        {
            foreach($podata as $podetails)
            {
                $returnstr[]=array("slno"=>$i,"Post Office"=>$podetails->poname,"Pin"=>$podetails->pincode,"District"=>$podetails->district_name,"State"=>$podetails->state_name,"Created On"=>$podetails->created_on,"Action"=>'<span><i class="fas fa-edit" style="color: #12d3d0;"></i><i class="fas fa-solid fa-trash" style="color: #ee1b1b; padding-left:5px;"></i></span>');
                $i++;
            }
            $data = [
                "data" => $returnstr
            ];
            echo json_encode($data);
        }
        else
        {
            $msgarr = array('message'=>'The given data was invalid.','errors'=>array('check_po'=>array('0'=>'Please select a State and District.')));
            return response()->json($msgarr, 422); 
        }

    }
    public function addPo(Request $request)
    {
            $statecode = $request->input('statecode');
            $districtcode = $request->input('districtcode');
            $poname = $request->input('poname');
            $pincode = $request->input('pincode');
            $currentTime = Carbon::now();
            $createtime = $currentTime->toDateTimeString();
            $validated = $request->validate(
            [
                'statecode' => 'not_in:""',
                'districtcode' =>  'not_in:""',
                'poname' => 'required',
                'pincode'=>'required|numeric|digits_between:6,6',
                
            ],
            [
                'statecode.not_in'=>'Please Select a State',
                'districtcode.not_in'=>'Please Select a District',
                'poname.required'=>'Postoffice Name Cannot Be Blank',
                'pincode.required'=>'Pincode Cannot Be Blank',
                'pincode.numeric'=>'Pin Code can only be Numeric',
                'pincode.digits_between'=>'Pin Code Cannot be more than 6 digits',
            ]
            );
            if($validated == TRUE)
            {
                $tablename = 'Masterdata.podetails'; 
                $insertarr = array('poname'=>$poname,'pincode'=>$pincode,'districtcode'=>$districtcode,'statecode'=>$statecode,'created_on'=>$createtime);
                $this->masterdatainfo->insertData($tablename,$insertarr);
               return response()->json(['msg' => 'Postoffice Added Sucessfully.'], 200);
            }
    }
    public function subdistrictentryform()
    {
        $sessionvalue = session()->all(); 
        $table = 'Masterdata.subdistrict as subdis';
        $table1 = 'Masterdata.district as dis';
        $table2 = 'Masterdata.state as st';
        $cond = 'subdis.district_code';
        $cond1 = 'dis.district_code';
        $cond2 = 'subdis.state_code';
        $cond3 = 'st.state_code';
        $equal = '=';
        $order = 'subdis.state_code';
        $selectfield =[['subdis.*','dis.district_name','st.state_name']];
        $allstateinfo = $this->masterdatainfo->getAllData($table2);
        $allsubdistrictinfo = $this->masterdatainfo->innerjointhreetables($table,$table1,$table2,$cond,$cond1,$cond2,$cond3,$equal,$selectfield,$order,$wherearr = NULL);
        if(isset($sessionvalue['usersessionvalue']))
        {
            $usernamedisplay = $sessionvalue['usersessionvalue']['username'];
            return view('admin.subdistrictentryform',compact('usernamedisplay','allstateinfo','allsubdistrictinfo'));
        }
        else
        {
            return redirect()->to('/');   
        }
    }
    public function addSubdistrict(Request $request)
    {
        $statecode = $request->input('statecode');
        $districtcode = $request->input('districtcode');
        $subdiscode = $request->input('subdiscode');
        $subdisname = $request->input('subdisname');
        $currentTime = Carbon::now();
        $createtime = $currentTime->toDateTimeString();
        Validator::extend('alpha_spaces', function ($attribute, $value) {
            return preg_match('/^[\pL\s]+$/u', $value);  
        });
        $validated = $request->validate(
        [
            'statecode' => 'not_in:""',
            'districtcode' =>  'not_in:""',
            'subdisname'=> 'required|alpha_spaces',
            'subdiscode' => 'required|numeric'       
        ],
        [
            'statecode.not_in'=>'Please Select a State',
            'districtcode.not_in'=>'Please Select a District',
            'subdiscode.required'=>'Sub District Code  Cannot Be Blank',
            'subdiscode.numeric'=>'Sub District Code can only be Numeric',
            'subdisname.required'=>'Sub District Name Cannot Be Blank',
            'subdisname.alpha_spaces' => 'Sub District Name Should conatin letters only'
        ]
        );
        if($validated == TRUE)
        {
            $tablename = 'Masterdata.subdistrict'; 
            $insertarr = array('subdistrict_code'=>$subdiscode,'district_code'=>$districtcode,'state_code'=>$statecode,'subdistrict_name'=>$subdisname,'created_on'=>$createtime);
            $wherearr = array(['subdistrict_code','=',$subdiscode],['district_code','=',$districtcode],['state_code','=',$statecode]);
            $checkdist_code = $this->masterdatainfo->whereclause($tablename,$wherearr);
            if($checkdist_code->count()!='0')
            {
                $msgarr = array('message'=>'The given data was invalid.','errors'=>array('check_discode'=>array('0'=>'Sub District Code Already Exists.')));
                return response()->json($msgarr, 422);
            }
            else
            {
            $this->masterdatainfo->insertData($tablename,$insertarr);
            return response()->json(['msg' => 'Sub District Added Sucessfully.'], 200);
            }
        }
    }
    public function bankentryform()
    {
        set_time_limit(600);
        ini_set('memory_limit', '-1');
        $sessionvalue = session()->all(); 
        $table = 'Masterdata.bank as bk';
        $table1 = 'Masterdata.state as st';
        $select = 'bk.bank_name';
        $groupby = 'bk.bank_name';
        $orderby ='bk.bank_name';
        $allbankname = $this->masterdatainfo->getAllGroupByData($table,$groupby,$select,$orderby);
        $allstateinfo = $this->masterdatainfo->getAllData($table1);
        if(isset($sessionvalue['usersessionvalue']))
        {
            $usernamedisplay = $sessionvalue['usersessionvalue']['username'];
            return view('admin.bankentryform',compact('usernamedisplay','allbankname','allstateinfo'));
        }
        else
        {
            return redirect()->to('/');   
        }

    }
    public function getbankinfo(Request $request)
    {
        $bankname = $request->input('bankname');
        $table = 'Masterdata.bank as bk';
        $wherearr = array(['bank_name','=',$bankname]);
        $allbankinfo = $this->masterdatainfo->whereclause($table,$wherearr);
        $i=1;
        if($allbankinfo->count() !='0')
        {
            foreach($allbankinfo as $bankinfo)
            {
                $returnstr[]=array("slno"=>$i,"state"=>$bankinfo->state,"ifsc"=>$bankinfo->ifsc,"branch_name"=>$bankinfo->branch_name,"bank_name"=>$bankinfo->bank_name,"Created On"=>$bankinfo->created_on,"Action"=>'<span><i class="fas fa-edit" style="color: #12d3d0;"></i><i class="fas fa-solid fa-trash" style="color: #ee1b1b; padding-left:5px;"></i></span>');
                $i++;
            }
            $data = [
                "data" => $returnstr
            ];
            echo json_encode($data);
        }
        else
        {
            $msgarr = array('message'=>'The given data was invalid.','errors'=>array('check_bank'=>array('0'=>'Please select a Bank.')));
            return response()->json($msgarr, 422); 
        }

    }
    public function addBank(Request $request)
    {
        $state = $request->input('state');
        $ifsccode = $request->input('ifsccode');
        $branchname = $request->input('branchname');
        $bankname = $request->input('bankname');
        $currentTime = Carbon::now();
        $createtime = $currentTime->toDateTimeString();
        Validator::extend('alpha_spaces', function ($attribute, $value) {
            return preg_match('/^[\pL\s]+$/u', $value);  
        });
        $validated = $request->validate(
            [
                'state' => 'not_in:""',
                'ifsccode' =>  'required',
                'branchname' => 'required',
                'bankname'=>'required|alpha_spaces',
                
            ],
            [
                'state.not_in'=>'Please Select a State',
                'ifsccode.required'=>'IFSC Code Name Cannot Be Blank',
                'branchname.required'=>'Branch Name Cannot Be Blank',
                'bankname.required'=>'Bank Name Cannot Be Blank',
                'bankname.alpha_spaces' => 'Bank Name Should conatin letters only'
            ]
        );
        if($validated == TRUE)
        {
            $tablename = 'Masterdata.bank'; 
            $getid = $this->masterdatainfo->getAllData($tablename)->last()->id;
            $id = $getid+1;
            $insertarr = array('id'=>$id,'state'=>$state,'ifsc'=>$ifsccode,'branch_name'=>$branchname,'bank_name'=>$bankname,'created_on'=>$createtime);
            $this->masterdatainfo->insertData($tablename,$insertarr);
            return response()->json(['msg' => 'Bank Added Sucessfully.'], 200);
        }
    }
    public function categoryentryform()
    {
        $sessionvalue = session()->all(); 
        $table = 'Masterdata.category as ct';
        $allcategoryinfo = $this->masterdatainfo->getAllData($table);
        if(isset($sessionvalue['usersessionvalue']))
        {
            $usernamedisplay = $sessionvalue['usersessionvalue']['username'];
            return view('admin.categoryentryform',compact('usernamedisplay','allcategoryinfo'));
        }
        else
        {
            return redirect()->to('/');   
        }
    }
    public function addCategory(Request $request)
    {
        $categorycode = $request->input('categorycode');
        $categoryname = $request->input('categoryname');
        $currentTime = Carbon::now();
        $createtime = $currentTime->toDateTimeString();
        Validator::extend('alpha_spaces', function ($attribute, $value) {
            return preg_match('/^[\pL\s]+$/u', $value);  
        });
        $validated = $request->validate(
            [
                'categorycode' => 'required|numeric',
                'categoryname'=>'required|alpha_spaces',
                
            ],
            [
                'categorycode.required'=>'Category Code Cannot Be Blank',
                'categorycode.numeric'=>'Category Code Can Only Be Numeric',
                'categoryname.required'=>'Category Name Cannot Be Blank',
                'categoryname.alpha_spaces' => 'Category Name Should conatin letters only'
            ]
        );
        if($validated == TRUE)
        {
            $tablename = 'Masterdata.category'; 
            $getid = $this->masterdatainfo->getAllData($tablename)->last()->id;
            $id = $getid+1;
            $insertarr = array('id'=>$id,'category_code'=>$categorycode,'category_name'=>$categoryname,'created_on'=>$createtime);
            $this->masterdatainfo->insertData($tablename,$insertarr);
            return response()->json(['msg' => 'Category Added Sucessfully.'], 200);
        }
    }
    public function educationentryform()
    {
        $sessionvalue = session()->all(); 
        $table = 'Masterdata.education as ed';
        $alleducationinfo = $this->masterdatainfo->getAllData($table);
        if(isset($sessionvalue['usersessionvalue']))
        {
            $usernamedisplay = $sessionvalue['usersessionvalue']['username'];
            return view('admin.educationentryform',compact('usernamedisplay','alleducationinfo'));
        }
        else
        {
            return redirect()->to('/');  
        }
    }
    public function addEducation(Request $request)
    {
        $educationcode = $request->input('educationcode');
        $educationname = $request->input('educationname');
        $currentTime = Carbon::now();
        $createtime = $currentTime->toDateTimeString();
        Validator::extend('alpha_spaces', function ($attribute, $value) {
            return preg_match('/^[\pL\s]+$/u', $value);  
        });
        $validated = $request->validate(
            [
                'educationcode' => 'required|numeric',
                'educationname'=>'required|alpha_spaces',
                
            ],
            [
                'educationcode.required'=>'Eductaion Code Cannot Be Blank',
                'educationcode.numeric'=>'Eductaion Code Can Only Be Numeric',
                'educationname.required'=>'Eductaion Name Cannot Be Blank',
                'educationname.alpha_spaces' => 'Eductaion Name Should conatin letters only'
            ]
        );
        if($validated == TRUE)
        {
            $tablename = 'Masterdata.education'; 
            $getid = $this->masterdatainfo->getAllData($tablename)->last()->id;
            $id = $getid+1;
            $insertarr = array('id'=>$id,'education_code'=>$educationcode,'education_name'=>$educationname,'created_on'=>$createtime);
            $this->masterdatainfo->insertData($tablename,$insertarr);
            return response()->json(['msg' => 'Education Added Sucessfully.'], 200);
        }
    }
    public function genderentryform()
    {
        $sessionvalue = session()->all(); 
        $table = 'Masterdata.gender as gn';
        $allgenderinfo = $this->masterdatainfo->getAllData($table);
        if(isset($sessionvalue['usersessionvalue']))
        {
            $usernamedisplay = $sessionvalue['usersessionvalue']['username'];
            return view('admin.genderentryform',compact('usernamedisplay','allgenderinfo'));
        }
        else
        {
            return redirect()->to('/');   
        }
    }
    public function addGender(Request $request)
    {
        $gendercode = $request->input('gendercode');
        $gendername = $request->input('gendername');
        $currentTime = Carbon::now();
        $createtime = $currentTime->toDateTimeString();
        Validator::extend('alpha_spaces', function ($attribute, $value) {
            return preg_match('/^[\pL\s]+$/u', $value);  
        });
        $validated = $request->validate(
            [
                'gendercode' => 'required|numeric',
                'gendername'=>'required|alpha_spaces',
                
            ],
            [
                'gendercode.required'=>'Gender Code Cannot Be Blank',
                'gendercode.numeric'=>'Gender Code Can Only Be Numeric',
                'gendername.required'=>'Gender Name Cannot Be Blank',
                'gendername.alpha_spaces' => 'Gender Name Should conatin letters only'
            ]
        );
        if($validated == TRUE)
        {
            $tablename = 'Masterdata.gender'; 
            $getid = $this->masterdatainfo->getAllData($tablename)->last()->id;
            $id = $getid+1;
            $insertarr = array('id'=>$id,'gender_code'=>$gendercode,'gender_name'=>$gendername,'created_on'=>$createtime);
            $this->masterdatainfo->insertData($tablename,$insertarr);
            return response()->json(['msg' => 'Gender Added Sucessfully.'], 200);
        }
    }
    public function housetypeentryform()
    {
        $sessionvalue = session()->all(); 
        $table = 'Masterdata.house as hu';
        $allhousetypeinfo = $this->masterdatainfo->getAllData($table);
        if(isset($sessionvalue['usersessionvalue']))
        {
            $usernamedisplay = $sessionvalue['usersessionvalue']['username'];
            return view('admin.housetypeentryform',compact('usernamedisplay','allhousetypeinfo'));
        }
        else
        {
            return redirect()->to('/');  
        }
    }
    public function addHousetype(Request $request)
    {
        $housetypecode = $request->input('housetypecode');
        $housetype = $request->input('housetype');
        $currentTime = Carbon::now();
        $createtime = $currentTime->toDateTimeString();
        Validator::extend('alpha_spaces', function ($attribute, $value) {
            return preg_match('/^[\pL\s]+$/u', $value);  
        });
        $validated = $request->validate(
            [
                'housetypecode' => 'required|numeric',
                'housetype'=>'required|alpha_spaces',
                
            ],
            [
                'housetypecode.required'=>'House Type Code Cannot Be Blank',
                'housetypecode.numeric'=>'House Type Code Can Only Be Numeric',
                'housetype.required'=>'House Type Cannot Be Blank',
                'housetype.alpha_spaces' => 'House Type Should conatin letters only'
            ]
        );
        if($validated == TRUE)
        {
            $tablename = 'Masterdata.house'; 
            $getid = $this->masterdatainfo->getAllData($tablename)->last()->id;
            $id = $getid+1;
            $insertarr = array('id'=>$id,'house_code'=>$housetypecode,'house_type'=>$housetype,'created_on'=>$createtime);
            $this->masterdatainfo->insertData($tablename,$insertarr);
            return response()->json(['msg' => 'Gender Added Sucessfully.'], 200);
        }
    }
    public function maritialstatusentryform()
    {
        $sessionvalue = session()->all(); 
        $table = 'Masterdata.marital_status as ms';
        $allmaritalstatusinfo = $this->masterdatainfo->getAllData($table);
        if(isset($sessionvalue['usersessionvalue']))
        {
            $usernamedisplay = $sessionvalue['usersessionvalue']['username'];
            return view('admin.maritalstatusentryform',compact('usernamedisplay','allmaritalstatusinfo'));
        }
        else
        {
            return redirect()->to('/');  
        }
    }
    public function addMaritalstatus(Request $request)
    {
        $maritalstatuscode = $request->input('maritalstatuscode');
        $maritalstatus = $request->input('maritalstatus');
        $currentTime = Carbon::now();
        $createtime = $currentTime->toDateTimeString();
        Validator::extend('alpha_spaces', function ($attribute, $value) {
            return preg_match('/^[\pL\s]+$/u', $value);  
        });
        $validated = $request->validate(
            [
                'maritalstatuscode' => 'required|numeric',
                'maritalstatus'=>'required|alpha_spaces',
                
            ],
            [
                'maritalstatuscode.required'=>'Marital Status Code Cannot Be Blank',
                'maritalstatuscode.numeric'=>'Marital Status Code Can Only Be Numeric',
                'maritalstatus.required'=>'Marital Status Cannot Be Blank',
                'maritalstatus.alpha_spaces' => 'Marital Status Should conatin letters only'
            ]
        );
        if($validated == TRUE)
        {
            $tablename = 'Masterdata.marital_status'; 
            $getid = $this->masterdatainfo->getAllData($tablename)->last()->id;
            $id = $getid+1;
            $insertarr = array('id'=>$id,'marital_code'=>$maritalstatuscode,'marital_status'=>$maritalstatus,'created_on'=>$createtime);
            $this->masterdatainfo->insertData($tablename,$insertarr);
            return response()->json(['msg' => 'Marital Status Added Sucessfully.'], 200);
        }
    }
    public function natureofworkentryform()
    {
        $sessionvalue = session()->all(); 
        $table = 'Masterdata.nature_of_work as nw';
        $allnatureofworkinfo = $this->masterdatainfo->getAllData($table);
        if(isset($sessionvalue['usersessionvalue']))
        {
            $usernamedisplay = $sessionvalue['usersessionvalue']['username'];
            return view('admin.natureofworkentryform',compact('usernamedisplay','allnatureofworkinfo'));
        }
        else
        {
            return redirect()->to('/');  
        }
    }
    public function addNatureofwork(Request $request)
    {
        $natureofworkcode = $request->input('natureofworkcode');
        $natureofwork = $request->input('natureofwork');
        $currentTime = Carbon::now();
        $createtime = $currentTime->toDateTimeString();
        Validator::extend('alpha_spaces', function ($attribute, $value) {
            return preg_match('/^[\pL\s]+$/u', $value);  
        });
        $validated = $request->validate(
            [
                'natureofworkcode' => 'required|numeric',
                'natureofwork'=>'required|alpha_spaces',
                
            ],
            [
                'natureofworkcode.required'=>'Nature of Work Code Cannot Be Blank',
                'natureofworkcode.numeric'=>'Nature of Work Code Can Only Be Numeric',
                'natureofwork.required'=>'Nature of Work Cannot Be Blank',
                'natureofwork.alpha_spaces' => 'Nature of Work Should conatin letters only'
            ]
        );
        if($validated == TRUE)
        {
            $tablename = 'Masterdata.nature_of_work'; 
            $getid = $this->masterdatainfo->getAllData($tablename)->last()->id;
            $id = $getid+1;
            $insertarr = array('id'=>$id,'nature_of_work_code'=>$natureofworkcode,'nature_of_work'=>$natureofwork,'created_on'=>$createtime);
            $this->masterdatainfo->insertData($tablename,$insertarr);
            return response()->json(['msg' => 'Nature of Work Added Sucessfully.'], 200);
        }
    }
    public function residencetypeentryform()
    {
        $sessionvalue = session()->all(); 
        $table = 'Masterdata.residence as re';
        $allresidencetypeinfo = $this->masterdatainfo->getAllData($table);
        if(isset($sessionvalue['usersessionvalue']))
        {
            $usernamedisplay = $sessionvalue['usersessionvalue']['username'];
            return view('admin.residencetypeentryform',compact('usernamedisplay','allresidencetypeinfo'));
        }
        else
        {
            return redirect()->to('/');
        }
    }
    public function addResidencetype(Request $request)
    {
        $residencetypecode = $request->input('residencetypecode');
        $residencetype = $request->input('residencetype');
        $currentTime = Carbon::now();
        $createtime = $currentTime->toDateTimeString();
        Validator::extend('alpha_spaces', function ($attribute, $value) {
            return preg_match('/^[\pL\s]+$/u', $value);  
        });
        $validated = $request->validate(
            [
                'residencetypecode' => 'required|numeric',
                'residencetype'=>'required|alpha_spaces',
                
            ],
            [
                'residencetypecode.required'=>'Residence Type Code Cannot Be Blank',
                'residencetypecode.numeric'=>'Residence Type Code Can Only Be Numeric',
                'residencetype.required'=>'Residence Type Cannot Be Blank',
                'residencetype.alpha_spaces' => 'Residence Type Should conatin letters only'
            ]
        );
        if($validated == TRUE)
        {
            $tablename = 'Masterdata.residence'; 
            $getid = $this->masterdatainfo->getAllData($tablename)->last()->id;
            $id = $getid+1;
            $insertarr = array('id'=>$id,'residence_code'=>$residencetypecode,'residence_name'=>$residencetype,'created_on'=>$createtime);
            $this->masterdatainfo->insertData($tablename,$insertarr);
            return response()->json(['msg' => 'Residence Type Added Sucessfully.'], 200);
        }
    }
    public function issuertypeentryform()
    {
        $sessionvalue = session()->all(); 
        $table = 'Masterdata.type_of_issuer_table as iss';
        $allissuertypeinfo = $this->masterdatainfo->getAllData($table);
        if(isset($sessionvalue['usersessionvalue']))
        {
            $usernamedisplay = $sessionvalue['usersessionvalue']['username'];
            return view('admin.issuertypeentryform',compact('usernamedisplay','allissuertypeinfo'));
        }
        else
        {
            return redirect()->to('/'); 
        }
    }
    public function addIssuertype(Request $request)
    {
        $issuertypecode = $request->input('issuertypecode');
        $issuertypename = $request->input('issuertypename');
        $currentTime = Carbon::now();
        $createtime = $currentTime->toDateTimeString();
        Validator::extend('alpha_spaces', function ($attribute, $value) {
            return preg_match('/^[\pL\s]+$/u', $value);  
        });
        $validated = $request->validate(
            [
                'issuertypecode' => 'required|numeric',
                'issuertypename'=>'required|alpha_spaces',
                
            ],
            [
                'issuertypecode.required'=>'Issuer Type Code Cannot Be Blank',
                'issuertypecode.numeric'=>'Issuer Type Code Can Only Be Numeric',
                'issuertypename.required'=>'Issuer Type Cannot Be Blank',
                'issuertypename.alpha_spaces' => 'Issuer Type Should conatin letters only'
            ]
        );
        if($validated == TRUE)
        {
            $tablename = 'Masterdata.type_of_issuer_table'; 
            $getid = $this->masterdatainfo->getAllData($tablename)->last()->id;
            $id = $getid+1;
            $insertarr = array('id'=>$id,'issuer_code'=>$issuertypecode,'issuer_name'=>$issuertypename,'created_on'=>$createtime);
            $this->masterdatainfo->insertData($tablename,$insertarr);
            return response()->json(['msg' => 'Issuer Type Added Sucessfully.'], 200);
        }
    }
    public function worktypeentryform()
    {
        $sessionvalue = session()->all(); 
        $table = 'Masterdata.type_of_work as wt';
        $allworktypeinfo = $this->masterdatainfo->getAllData($table);
        if(isset($sessionvalue['usersessionvalue']))
        {
            $usernamedisplay = $sessionvalue['usersessionvalue']['username'];
            return view('admin.worktypeentryform',compact('usernamedisplay','allworktypeinfo'));
        }
        else
        {
            return redirect()->to('/');  
        }
    }
    public function addWorktype(Request $request)
    {
        $worktypecode = $request->input('worktypecode');
        $worktypename = $request->input('worktypename');
        $currentTime = Carbon::now();
        $createtime = $currentTime->toDateTimeString();
        Validator::extend('alpha_spaces', function ($attribute, $value) {
            return preg_match('/^[\pL\s]+$/u', $value);  
        });
        $validated = $request->validate(
            [
                'worktypecode' => 'required|numeric',
                'worktypename'=>'required|alpha_spaces',
                
            ],
            [
                'worktypecode.required'=>'Work Type Code Cannot Be Blank',
                'worktypecode.numeric'=>'Work Type Code Can Only Be Numeric',
                'worktypename.required'=>'Work Type Cannot Be Blank',
                'worktypename.alpha_spaces' => 'Work Type Should conatin letters only'
            ]
        );
        if($validated == TRUE)
        {
            $tablename = 'Masterdata.type_of_work'; 
            $getid = $this->masterdatainfo->getAllData($tablename)->last()->id;
            $id = $getid+1;
            $insertarr = array('id'=>$id,'work_type_code'=>$worktypecode,'work_type_name'=>$worktypename,'created_on'=>$createtime);
            $this->masterdatainfo->insertData($tablename,$insertarr);
            return response()->json(['msg' => 'Work Type Added Sucessfully.'], 200);
        }
    }
    public function officelistentryform()
    {
        $sessionvalue = session()->all(); 
        $table = 'Masterdata.office as ol';
        $table1 = 'Masterdata.district as dis'; 
        $cond = 'ol.district_code';
        $equal = '=';
        $secondcond = 'dis.district_code';
        $selectfield =[['ol.*','dis.district_name']];
        $wherearr = array(['state_code','=','18']);
        $alldistrictinfo = $this->masterdatainfo->whereclause($table1,$wherearr);
        $allofficeinfo = $this->masterdatainfo->innerjointwotables($table,$table1,$cond,$equal,$secondcond,$selectfield);
        if(isset($sessionvalue['usersessionvalue']))
        {
            $usernamedisplay = $sessionvalue['usersessionvalue']['username'];
            return view('admin.officeentryform',compact('usernamedisplay','allofficeinfo','alldistrictinfo'));
        }
        else
        {
            return redirect()->to('/');  
        }
    }
    public function addOffice(Request $request)
    {
        $districtcode = $request->input('districtcode');
        $officename = $request->input('officename');
        $currentTime = Carbon::now();
        $createtime = $currentTime->toDateTimeString();
        $validated = $request->validate(
            [
                'districtcode' => 'not_in:""',
                'officename'=>'required'
                
            ],
            [
                'districtcode.not_in'=>'Please Select a District',
                'officename.required'=>'Office Name Cannot Be Blank',
            ]
        );
        if($validated == TRUE)
        {
            $tablename = 'Masterdata.office'; 
            $getid = $this->masterdatainfo->getAllData($tablename)->last()->office_id;
            $id = $getid+1;
            $insertarr = array('office_id'=>$id,'district_code'=>$districtcode,'office_name'=>$officename,'created_on'=>$createtime);
            $this->masterdatainfo->insertData($tablename,$insertarr);
            return response()->json(['msg' => 'Office Added Sucessfully.'], 200);
        }
    }
    public function rolelistentryform()
    {
        $sessionvalue = session()->all(); 
        $table = 'Masterdata.roles as rl';
        $allroleinfo = $this->masterdatainfo->getAllData($table);
        if(isset($sessionvalue['usersessionvalue']))
        {
            $usernamedisplay = $sessionvalue['usersessionvalue']['username'];
            return view('admin.roleentryform',compact('usernamedisplay','allroleinfo'));
        }
        else
        {
            return redirect()->to('/');  
        }
    }
    public function addRole(Request $request)
    {
        $rolename = $request->input('rolename');
        $currentTime = Carbon::now();
        $createtime = $currentTime->toDateTimeString();
        $validated = $request->validate(
            [
                'rolename'=>'required'
                
            ],
            [
                'rolename.required'=>'Rolename Name Cannot Be Blank'
            ]
        );
        if($validated == TRUE)
        {
            $tablename = 'Masterdata.roles'; 
            $getid = $this->masterdatainfo->getAllData($tablename)->last()->id;
            $id = $getid+1;
            $insertarr = array('id'=>$id,'role_name'=>$rolename,'created_on'=>$createtime);
            $this->masterdatainfo->insertData($tablename,$insertarr);
            return response()->json(['msg' => 'Role Added Sucessfully.'], 200);
        }
    }
    public function designationentryform()
    {
        $sessionvalue = session()->all(); 
        $table = 'Masterdata.designation as desig';
        $alldesignationinfo = $this->masterdatainfo->getAllData($table);
        if(isset($sessionvalue['usersessionvalue']))
        {
            $usernamedisplay = $sessionvalue['usersessionvalue']['username'];
            return view('admin.designationentryform',compact('usernamedisplay','alldesignationinfo'));
        }
        else
        {
            return redirect()->to('/');  
        }
    }
    public function addDesignation(Request $request)
    {
        $designame = $request->input('designame');
        $currentTime = Carbon::now();
        $createtime = $currentTime->toDateTimeString();
        $validated = $request->validate(
            [
                'designame'=>'required'
                
            ],
            [
                'designame.required'=>'Designation Cannot Be Blank'
            ]
        );
        if($validated == TRUE)
        {
            $tablename = 'Masterdata.designation'; 
            $getid = $this->masterdatainfo->getAllData($tablename)->last()->id;
            $id = $getid+1;
            $insertarr = array('id'=>$id,'designation'=>$designame,'created_on'=>$createtime);
            $this->masterdatainfo->insertData($tablename,$insertarr);
            return response()->json(['msg' => 'Designation Added Sucessfully.'], 200);
        }
    }
    public function ageproofentryform()
    {
        $sessionvalue = session()->all(); 
        $table = 'Masterdata.age_proof as ag';
        $allageproofinfo = $this->masterdatainfo->getAllData($table);
        if(isset($sessionvalue['usersessionvalue']))
        {
            $usernamedisplay = $sessionvalue['usersessionvalue']['username'];
            return view('admin.ageproofentryform',compact('usernamedisplay','allageproofinfo'));
        }
        else
        {
            return redirect()->to('/');  
        }
    }
    public function addAgeproof(Request $request)
    {
        $ageproof = $request->input('ageproof');
        $currentTime = Carbon::now();
        $createtime = $currentTime->toDateTimeString();
        $validated = $request->validate(
            [
                'ageproof'=>'required'
                
            ],
            [
                'ageproof.required'=>'Age Proof Cannot Be Blank'
            ]
        );
        if($validated == TRUE)
        {
            $tablename = 'Masterdata.age_proof'; 
            $getid = $this->masterdatainfo->getAllData($tablename)->last()->id;
            $id = $getid+1;
            $insertarr = array('id'=>$id,'age_proof_code'=>$id,'age_proof_name'=>$ageproof,'created_on'=>$createtime);
            $this->masterdatainfo->insertData($tablename,$insertarr);
            return response()->json(['msg' => 'Age Proof Added Sucessfully.'], 200);
        }
    }
    public function schemesentryform()
    {
        $sessionvalue = session()->all(); 
        $table = 'Masterdata.schemes as sch';
        $allschemeinfo = $this->masterdatainfo->getAllData($table);
        if(isset($sessionvalue['usersessionvalue']))
        {
            $usernamedisplay = $sessionvalue['usersessionvalue']['username'];
            return view('admin.schemeentryform',compact('usernamedisplay','allschemeinfo'));
        }
        else
        {
            return redirect()->to('/');  
        } 
    }
    public function addScheme(Request $request)
    {
        $schemename = $request->input('schemename');
        $currentTime = Carbon::now();
        $createtime = $currentTime->toDateTimeString();
        $validated = $request->validate(
            [
                'schemename'=>'required'
                
            ],
            [
                'schemename.required'=>'Scheme Cannot Be Blank'
            ]
        );
        if($validated == TRUE)
        {
            $tablename = 'Masterdata.schemes'; 
            $getid = $this->masterdatainfo->getAllData($tablename)->last()->id;
            $id = $getid+1;
            $insertarr = array('id'=>$id,'scheme_code'=>$id,'scheme_name'=>$schemename,'created_on'=>$createtime);
            $this->masterdatainfo->insertData($tablename,$insertarr);
            return response()->json(['msg' => 'Scheme Added Sucessfully.'], 200);
        }
    }
}
