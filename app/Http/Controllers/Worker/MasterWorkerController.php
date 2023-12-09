<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Http\Requests\validationRequest;
use App\Models\AddressModel;
use App\Models\BankModel;
use App\Models\DocumentModel;
use App\Models\employerModel;
use App\Models\FamilyModel;
use App\Models\FormModel;
use App\Models\MainAddressModel;
use App\Models\MainBankModel;
use App\Models\MainBasicDetails;
use App\Models\MainCertificateModel;
use App\Models\MainDocumentModel;
use App\Models\MainEmpModel;
use App\Models\MainFamilyModel;
use App\Models\MainFormModel;
use App\Models\SchemesModel;
use App\Models\WorkerBasicDetails;
use App\Models\workerCertificate;
use App\Models\WorkerSchemeModel;
use Carbon\Carbon;
use Faker\Core\File;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use mysql_xdevapi\Exception;
use PhpParser\Node\Expr\Cast;

class MasterWorkerController extends Controller
{
    /****View Homepage****/
    public function index()
    {
        $data['dists'] = DB::table('Masterdata.district')->where('state_code', '=', 18)->orderBy('district_name')->get();
        //          dd($data);
        return view('index', $data);
    }
    /** Display districts */
    public function getDistricts(Request $request)
    {
        $districts['districts'] = DB::table('Masterdata.district')
            ->where('state_code', $request->state_code)
            ->select('district_code', 'district_name')->orderBy('district_name')->get();
        return response()->json($districts);
    }
    /** Display Office **/
    public function getOffice(Request $request)
    {
        $data['office'] = DB::table('Masterdata.office')
            ->where('district_code',$request->district_code)
            ->select('office_id','office_name')->orderBy('office_name')->get();
        return response()->json($data);
    }
    /** Display sub-districts */
    public function getSubDist(Request $request)
    {
        $data['subdist'] = DB::table('Masterdata.subdistrict')
            ->where('district_code',$request->district_code)
            ->select('subdistrict_code','subdistrict_name')->orderBy('subdistrict_name')->get();
        return response()->json($data);
    }
    /** Display sub-districts post-office */
    public function getSubdistPostOffc(Request $request)
    {
        $data['subdist'] = DB::table('Masterdata.subdistrict')
            ->where('state_code', $request->state_code)
            ->where('district_code',$request->district_code)
            ->select('subdistrict_code','subdistrict_name')->orderBy('subdistrict_name')->get();
        $data['postoffice'] = DB::table('Masterdata.podetails')
            ->where('statecode',$request->state_code)
            ->where('districtcode',$request->district_code)
            ->select('poid','poname','pincode')->orderBy('poname')
            ->get();
        return response()->json($data);
    }
    /** Display pin-codes */
    public function getPin(Request $request)
    {
        $data['pincode'] = DB::table('Masterdata.podetails')
            ->where('statecode',$request->state_code)
            ->where('districtcode',$request->district_code)
            ->where('poid',$request->poid)
            ->select('pincode')
            ->first();
        return response()->json($data);
    }
    public function getBank(Request $request)
    {
        $data['ifsc'] = DB::table('Masterdata.bank')
            ->where('ifsc',$request->ifsc)
            ->first();
        return response()->json($data);
    }

    /**save preliminary data**/
    public function saveModal(Request $request)
    {
//        dd($request->all());
        $adhaar_no = $request->adhaarno;
        $prefix = "WRKAS01";
        $rand_no = rand(1, 1000000000);
        $rand_no_with_prefix = $prefix . $rand_no;
        $validate = $request->validate([
            'phone_no' => 'required|digits:10',
            'adhaarno' => 'required|digits:12',
            'office_id' => 'required',
            'district' => 'required'
        ],[
            'phone_no.required' => 'Phone No Cannot Be Blank',
            'phone_no.digits' => 'Phone number must have exactly 10 digits',
            'adhaarno.required' => 'Adhaar No Cannot Be Blank',
            'adhaarno.digits' => 'Adhaar No Should Be Twelve Digit No',
            'office_id.required' => 'Office Cannot Be Blank',
            'district.required' => 'District Cannot Be Blank'

            ]);
        session()->put('adhaar_no', null);//intialize adhaar
        session()->put('adhaar_no', $adhaar_no);

        /** check if $userExists by using phone number */
        $userExists = DB::table('Worker.temp_form_models')->where('phone_no', $validate['phone_no'])->first();
        if (!$userExists)//if not exists the insert data
        {
//            dd('user not exist');
            $data = FormModel::Create([
                'worker_id' => $rand_no_with_prefix,
                'phone_no' => $request->phone_no,
                'district' => $request->district,
                'office_id' => $request->office_id,
            ]);
            session()->put('worker_id', $data->worker_id);
            return response()->json(['msg' => 'Worker registered successfully','redirect' => '/worker/worker-basic-details']);


        } else {
            //check worker if exists in basic details
            //  $temp_form1 = DB::table('Worker.temp_worker_basic_details')->where('worker_id',$userExists->worker_id  )->first();
            session()->put('worker_id', $userExists->worker_id);
//            return redirect()->route('main-page')->with('success');
            return response()->json(['msg' => 'Worker already registered','redirect' => '/worker/worker-basic-details']);
//            dd('User Exist');
        }
    }

    /**Redirect To Worker Basic Details page**/
    public function mainPage(Request $request)
    {
        $session_worker_id = session()->get('worker_id');
        if (!$session_worker_id) {
            return $this->sessionFlash();
        }

        $data['formdata'] = $formdata = DB::table('Worker.temp_worker_basic_details as twbd')
            ->join('Worker.temp_form_models as tfm', 'twbd.worker_id', '=', 'tfm.worker_id')
            ->join('Masterdata.gender as gen', 'twbd.gender', '=', 'gen.gender_code')
            ->join('Masterdata.marital_status as ms', 'twbd.maritial_status', '=', 'ms.marital_code')
            ->join('Masterdata.education as edu', 'twbd.education', '=', 'edu.education_code')
            ->join('Masterdata.category as cat', 'twbd.category', '=', 'cat.category_code')
            ->where('twbd.worker_id', $session_worker_id)
            ->select('twbd.*', 'tfm.*', 'gen.*', 'ms.*', 'cat.*', 'edu.*')
            ->first();

        if ($data['formdata']) {
            $data['gender'] = DB::table('Masterdata.gender')->where('gender_code', '!=', $formdata->gender_code)->get();
            $data['marital'] = DB::table('Masterdata.marital_status')->where('marital_code', '!=', $formdata->marital_code)->get();
            $data['category'] = DB::table('Masterdata.category')->where('category_code', '!=', $formdata->category_code)->get();
            $data['education'] = DB::table('Masterdata.education')->where('education_code', '!=', $formdata->education_code)->get();
            return view('Worker/edit.edit-worker-basic-details', $data);

        } else {
            $data['gender'] = DB::table('Masterdata.gender')->get();
            $data['category'] = DB::table('Masterdata.category')->get();
            $data['marital'] = DB::table('Masterdata.marital_status')->get();
            $data['education'] = DB::table('Masterdata.education')->get();
            $data['formdata'] = $formdata = DB::table('Worker.temp_form_models')->where('worker_id', $session_worker_id)->first();
            return view('worker.worker-basic-details', $data);
        }
    }

    public function sessionFlash()
    {
        Session::flush();
        session()->regenerate();
        return redirect()->route('homepage');
    }

    /** save basic worker basic data */
    public function saveBasic(Request $request)
    {
        $validate = $request->validate([
            'worker_id' => 'unique:pgsql.Worker.temp_worker_basic_details',
            'first_name' => 'required|alpha',
            'last_name' => 'required|alpha',
            'gurdain_name' => 'required|regex:/^[\pL\s]+$/u',
            'gender' => 'required',
            'maritial_status' => 'required',
            'category' => 'required',
            'dob' => 'required|date',
            'eshram_no' => 'numeric',
            'education' => 'required'
        ], [
            'worker_id.unique' => 'The Worker is already registered!',
            'first_name.required' => 'First Name Cannot Be Blank',
            'last_name.required' => 'Last Name Cannot Be Blank',
            'gurdain_name.required' => 'Guardian Name Cannot Be Blank',
            'gurdain_name.alpha' => 'Guardian Name Cannot Be a No',
            'gender.required' => 'Gender Cannot Be Blank',
            'category.required' => 'Category Cannot Be Blank',
            'dob.required' => 'Date Of Birth Cannot Be Blank',
            'dob.date' => 'Date Of Birth is Not Valid',
            'education.required' => 'Education Cannot Be Blank',
            'eshram_no' => 'Eshram No Must Be Numbers'
        ]);

        $data = WorkerBasicDetails::Create([
            'worker_id' => $request->worker_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gurdain_name' => $request->gurdain_name,
            'gender' => $request->gender,
            'maritial_status' => $request->maritial_status,
            'category' => $request->category,
            'dob' => $request->dob,
            'eshram_no' => $request->eshram_no,
            'education' => $request->education,
            'pf_no' => $request->pf_no,
            'esic_no' => $request->esic_no,
            'email' => $request->email,
        ]);
        return redirect()->route('submit-basic-details', ['id' => $data->id])->with('success');
    }
    /** end */
    /** update worker data if data already exists */
    public function updateBasic(Request $request)
    {
        $data = WorkerBasicDetails::where('worker_id', $request->worker_id)->update([
            'worker_id' => $request->worker_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gurdain_name' => $request->gurdain_name,
            'gender' => $request->gender,
            'maritial_status' => $request->maritial_status,
            'category' => $request->category,
            'dob' => $request->dob,
            'eshram_no' => $request->eshram_no,
//           'occupation'=> $request->occupation,
            'education' => $request->education,
            'pf_no' => $request->pf_no,
            'esic_no' => $request->esic_no,
            'email' => $request->email,

        ]);
        return redirect()->route('submit-basic-details')->with('success');
    }

    /** Redirect to address page **/
    public function pageAddress(Request $request)
    {
        $session_worker_id = session()->get('worker_id');
        if (!$session_worker_id) {
            return $this->sessionFlash();
        }
        $data['formdata'] = $formdata = DB::table('Worker.temp_worker_address_models as twam')
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
            ->where('twam.worker_id', $session_worker_id)
            ->select('twam.*','cres.*', 'pres.*', 'chs.*', 'phs.*', 'cst.*', 'pst.*', 'cds.*', 'pds.*','scds.*','spds.*','cpo.*','ppo.*')
            ->first();
        if ($formdata) {
            $data['states'] = DB::table('Masterdata.state')->select('state_code', 'state_name')->orderBy('state_name')->get();
            $data['districts'] = DB::table('Masterdata.district')->select('district_code', 'district_name')->orderBy('district_name')->get();
            $data['subdistrict'] = DB::table('Masterdata.subdistrict')->select('subdistrict_code','subdistrict_name')->orderBy('subdistrict_name')->get();
            $data['podetails'] = DB::table('Masterdata.podetails')->select('poid','poname','pincode')->orderBy('poname')->get();
            $data['residence'] = DB::table('Masterdata.residence')->where('residence_code', '!=', $formdata->residence_code)->get();
            $data['house'] = DB::table('Masterdata.house')->where('house_code', '!=', $formdata->house_code)->get();
            return view('worker/edit.edit-worker-address-details', $data);
        } else {
            $data['states'] = DB::table('Masterdata.state')->orderBy('state_name')->get();
            $data['residence'] = DB::table('Masterdata.residence')->get();
            $data['house'] = DB::table('Masterdata.house')->get();
            $data['formdata'] = $formdata = DB::table('Worker.temp_worker_basic_details')->where('worker_id', $session_worker_id)->first();
            return view('worker.worker-address', $data);
        }
    }

    /** Save worker Address */
    public function saveAddress(Request $request)
    {
        $validate = $request->validate([
            'worker_id' => 'unique:pgsql.Worker.temp_worker_address_models',
            'c_residence' => 'required',
            'c_house_type' => 'required',
            'c_house_no' => 'numeric',
            'c_road' => 'required|custom_rule',
            'c_area' => 'required|custom_rule',
            'c_city' => 'required|regex:/^[\pL\s]+$/u',
            'c_state' => 'required',
            'c_district' => 'required',
            'c_post_office' => 'required',
            'c_pin' => 'required|min:6|numeric',
            'c_std' => 'numeric',
            'c_circle' => 'required',
            'p_residence' => 'required',
            'p_house_type' => 'required',
            'p_house_no' => 'numeric',
            'p_road' => 'required|custom_rule',
            'p_area' => 'required|custom_rule',
            'p_city' => 'required|regex:/^[\pL\s]+$/u',
            'p_state' => 'required',
            'p_district' => 'required',
            'p_post_office' => 'required',
            'p_pin' => 'required|min:6|numeric',
            'p_circle' => 'required',
            'p_std' => 'numeric',
            'ration_no' => 'numeric',
            'ration_type' => 'required|regex:/^[\pL\s]+$/u'
        ],
            [
                'c_residence.required' => 'Residence Type Cannot Be Blank',
                'c_house_type.required' => 'House Type Cannot Be Blank',
                'c_house_no.numeric' => 'House No Should Be Letters',
                'c_area.required' => 'Area Name Cannot Be Blank',
                'c_area.alpha' => 'Area Name Cannot Be a Number',
                'c_city.required' => 'City Cannot Be Blank',
                'c_city.alpha' => 'City Cannot Be a Number',
                'c_district.required' => 'District Cannot Be blank',
                'c_circle.required' => 'Sub-District Cannot Be blank',
                'c_post_office.required' => 'Post Office Cannot Be Blank',
                'c_pin.required' => 'Pin Code Cannot Be Blank',
                'c_road.required' => 'Road Name Cannot Be Blank',
                'c_std.numeric' => 'STD Code Should Be a NUmber',
                'c_state.required' => 'State Cannot Be Blank',
                'p_residence.required' => 'Residence Type Cannot Be Blank',
                'p_house_no.numeric' => 'House No Should Be Number',
                'p_house_type.required' => 'House Type Cannot Be Blank',
                'p_area.required' => 'Area Name Cannot Be Blank',
                'p_area.alpha' => 'Area Name Cannot Be a Number',
                'p_city.required' => 'City Cannot Be Blank',
                'p_city.alpha' => 'City Cannot Be a Number',
                'p_district.required' => 'District Cannot Be blank',
                'p_circle.required' => 'Sub-District Cannot Be blank',
                'p_post_office.required' => 'Post Office Cannot Be blank',
                'p_pin.required' => 'Pin Code Cannot Be blank',
                'p_state.required' => 'State Cannot Be blank',
                'p_std.numeric' => 'STD Code Should Be a NUmber',
                'p_road.required' =>'Road Name Cannot Be Blank',
                'ration_no.numeric' => 'Ration No Cannot Be Letters',
                'ration_type.alpha' => 'Ration Type Cannot Be Blank',
                'c_road.custom_rule' => 'Road Contains Invalid Character',
                'p_road.custom_rule' => 'Road Contains Invalid Character'
            ]);

        $data = AddressModel::Create([
            'worker_id' => $request->worker_id,
            'c_residence' => $request->c_residence,
            'c_house_type' => $request->c_house_type,
            'c_house_no' => $request->c_house_no,
            'c_road' => $request->c_road,
            'c_area' => $request->c_area,
            'c_city' => $request->c_city,
            'c_state' => $request->c_state,
            'c_district' => $request->c_district,
            'c_post_office' => $request->c_post_office,
            'c_pin' => $request->c_pin,
            'c_std' => $request->c_std,
            'c_circle' => $request->c_circle,
            'landmark' => $request->landmark,
            'p_residence' => $request->p_residence,
            'p_house_type' => $request->p_house_type,
            'p_house_no' => $request->p_house_no,
            'p_road' => $request->p_road,
            'p_area' => $request->p_area,
            'p_city' => $request->p_city,
            'p_state' => $request->p_state,
            'p_district' => $request->p_district,
            'p_post_office' => $request->p_post_office,
            'p_pin' => $request->p_pin,
            'p_std' => $request->p_std,
            'p_circle' => $request->p_circle,
            'ration_type' => $request->ration_type,
            'ration_no' => $request->ration_no,
            'landline' => $request->landline,

        ]);

        return redirect()->route('save-address', ['id' => $data->id])->with('success');
    }

    public function updateAddress(Request $request)
    {
        $validate = $request->validate([

            'c_residence' => 'required',
            'c_house_type' => 'required',
            'c_house_no' => 'numeric',
            'c_road' => 'required|custom_rule',
            'c_area' => 'required|custom_rule',
            'c_city' => 'required|regex:/^[\pL\s]+$/u',
            'c_state' => 'required',
            'c_district' => 'required',
            'c_post_office' => 'required',
            'c_pin' => 'required|min:6|numeric',
            'c_std' => 'numeric',
            'c_circle' => 'required',
//            'landmark' => 'custom_rule',
            'p_residence' => 'required',
            'p_house_type' => 'required',
            'p_house_no' => 'numeric',
            'p_road' => 'required|regex:/^[\pL\s]+$/u',
            'p_area' => 'required|custom_rule',
            'p_city' => 'required|regex:/^[\pL\s]+$/u',
            'p_state' => 'required',
            'p_district' => 'required',
            'p_post_office' => 'required',
            'p_pin' => 'required|min:6|numeric',
            'p_circle' => 'required',
            'p_std' => 'numeric',
            'ration_no' => 'numeric',
            'ration_type' => 'required|regex:/^[\pL\s]+$/u'
        ],
            [
                'c_residence.required' => 'Residence Type Cannot Be Blank',
                'c_house_type.required' => 'House Type Cannot Be Blank',
                'c_house_no.numeric' => 'House No Should Be Letters',
                'c_area.required' => 'Area Name Cannot Be Blank',
                'c_area.alpha' => 'Area Name Cannot Be a Number',
                'c_city.required' => 'City Cannot Be Blank',
                'c_city.alpha' => 'City Cannot Be a Number',
                'c_district.required' => 'District Cannot Be blank',
                'c_circle.required' => 'Sub-District Cannot Be blank',
                'c_post_office.required' => 'Post Office Cannot Be Blank',
                'c_pin.required' => 'Pin Code Cannot Be Blank',
                'c_road.required' => 'Road Name Cannot Be Blank',
                'c_std.numeric' => 'STD Code Should Be a NUmber',
                'c_state.required' => 'State Cannot Be Blank',
                'p_residence.required' => 'Residence Type Cannot Be Blank',
                'p_house_no.numeric' => 'House No Should Be Number',
                'p_house_type.required' => 'House Type Cannot Be Blank',
                'p_area.required' => 'Area Name Cannot Be Blank',
                'p_area.alpha' => 'Area Name Cannot Be a Number',
                'p_city.required' => 'City Cannot Be Blank',
                'p_city.alpha' => 'City Cannot Be a Number',
                'p_district.required' => 'District Cannot Be blank',
                'p_circle.required' => 'Sub-District Cannot Be blank',
                'p_post_office.required' => 'Post Office Cannot Be blank',
                'p_pin.required' => 'Pin Code Cannot Be blank',
                'p_state.required' => 'State Cannot Be blank',
                'p_std.numeric' => 'STD Code Should Be a NUmber',
                'p_road.required' =>'Road Name Cannot Be Blank',
                'ration_no.numeric' => 'Ration No Cannot Be Letters',
                'ration_type.alpha' => 'Ration Type Cannot Be Blank'

            ]);
        $data = AddressModel::where('worker_id', $request->worker_id)->update([
            'worker_id' => $request->worker_id,
            'c_residence' => $request->c_residence,
            'c_house_type' => $request->c_house_type,
            'c_house_no' => $request->c_house_no,
            'c_road' => $request->c_road,
            'c_area' => $request->c_area,
            'c_city' => $request->c_city,
            'c_state' => $request->c_state,
            'c_district' => $request->c_district,
            'c_post_office' => $request->c_post_office,
            'c_pin' => $request->c_pin,
            'c_std' => $request->c_std,
            'c_circle' => $request->c_circle,
            'landmark' => $request->landmark,
            'p_residence' => $request->p_residence,
            'p_house_type' => $request->p_house_type,
            'p_house_no' => $request->p_house_no,
            'p_road' => $request->p_road,
            'p_area' => $request->p_area,
            'p_city' => $request->p_city,
            'p_state' => $request->p_state,
            'p_district' => $request->p_district,
            'p_post_office' => $request->p_post_office,
            'p_pin' => $request->p_pin,
            'p_std' => $request->p_std,
            'p_circle' => $request->p_circle,
            'ration_type' => $request->ration_type,
            'ration_no' => $request->ration_no,
            'landline' => $request->landline,
        ]);
        return redirect()->route('save-address')->with('success');
    }

    /** passing id to bank details page */
    public function pageBank(Request $request)
    {
        $session_worker_id = session()->get('worker_id');
        if (!$session_worker_id) {
            return $this->sessionFlash();
        }
        $data['formdata'] = $formdata = DB::table('Worker.temp_worker_bank_models')
            ->where('worker_id', $session_worker_id)->first();
        if ($formdata) {
            $data['ifsc']= DB::table('Worker.temp_worker_bank_models as twbm')
                ->join('Masterdata.bank as bank','twbm.ifsc_pk','=','bank.id')
                ->where('worker_id', $session_worker_id)
                ->select('twbm.*','bank.*')
                ->first();
            return view('worker/edit.edit-worker-bank-details', $data);
        } else {

            $data['formdata'] = $formdata = DB::table('Worker.temp_worker_address_models')->where('worker_id', $session_worker_id)->first();
            return view('worker.worker-bank-details', $data);
        }

    }

    public function saveBankDetails(Request $request)
    {
        $validate = $request->validate([

            'bank_name' => 'required|regex:/([- ,\/0-9a-zA-Z]+)/',
            'branch_name' => 'required|regex:/([- ,\/0-9a-zA-Z]+)/',
            'bank_address' => 'required|regex:/([- ,\/0-9a-zA-Z]+)/',
            'account_no' => 'required|min:11,|numeric',
            'account_no_confirmation' => 'required|min:11,|numeric'

        ], [
            'bank_name.required' => 'Bank Number Cannot Be Blank',
            'branch_name.required'=> 'Branch Name Cannot Be Blank',
            'bank_address.required'=> 'Bank Address Cannot Be Blank',
            'account_no.required' => 'Account No Cannot Be Blank'

        ]);
        $session_worker_id = session()->get('worker_id');
        if (!$session_worker_id) {
            return $this->sessionFlash();
        }
        $data = BankModel::Create([
            'worker_id' => $session_worker_id,
            'ifsc_pk' => $request->ifsc_pk,
            'bank_name' => $request->bank_name,
            'branch_name' => $request->branch_name,
            'bank_address' => $request->bank_address,
            'account_no' => $request->account_no,

        ]);
        return redirect()->route('submit-bank', ['id' => $data->worker_id]);
    }

    public function updateBank(Request $request)
    {
        $validate = $request->validate([
            'bank_name' => 'required|regex:/([- ,\/0-9a-zA-Z]+)/',
            'branch_name' => 'required|regex:/([- ,\/0-9a-zA-Z]+)/',
            'bank_address' => 'required|regex:/([- ,\/0-9a-zA-Z]+)/',
            'account_no' => 'required|min:11|numeric|confirmed',
            'account_no_confirmation' => 'required|min:11|'

        ], [

            'bank_name.required' => 'Bank Number Cannot Be Blank',
            'branch_name.required'=> 'Branch Name Cannot Be Blank',
            'bank_address.required'=> 'Bank Address Cannot Be Blank',
            'account_no.required' => 'Account No Cannot Be Blank'
        ]);
        $session_worker_id = session()->get('worker_id');
        if (!$session_worker_id) {
            return $this->sessionFlash();
        }
        $data = BankModel::where('worker_id', $session_worker_id)->update([
            'ifsc_pk' => $request->ifsc_pk,
            'bank_name' => $request->bank_name,
            'branch_name' => $request->branch_name,
            'bank_address' => $request->bank_address,
            'account_no' => $request->account_no,
        ]);

        return redirect()->route('submit-bank')->with('success');
    }

    public function pageFamily(Request $request)
    {
        $session_worker_id = session()->get('worker_id');
        if (!$session_worker_id) {
            return $this->sessionFlash();
        }

        $data['formdata'] = $formdata = DB::table('Worker.temp_worker_family_models')->where('worker_id', $session_worker_id)->first();
        if ($formdata) {
            $data['formdata'] = $formdata = DB::table('Worker.temp_worker_family_models as twfm')
                ->join('Worker.temp_form_models as tfm', 'twfm.worker_id', '=', 'tfm.worker_id')
                ->join('Worker.temp_worker_basic_details as twbd', 'twfm.worker_id', '=', 'twbd.worker_id')
                ->where('twfm.worker_id', $session_worker_id)
                ->select('tfm.worker_id', 'twfm.*')
                ->get();
            return view('worker/edit.edit-worker-family-details', $data);
        } else {
            $data['formdata'] = $formdata = DB::table('Worker.temp_form_models as tfm')
                ->join('Worker.temp_worker_basic_details as twbd', 'tfm.worker_id', '=', 'twbd.worker_id')
                ->where('tfm.worker_id', $session_worker_id)
                ->select('tfm.*', 'twbd.*')
                ->first();
            $data['education'] = DB::table('Worker.temp_worker_basic_details as twbd')
                ->join('Masterdata.education as edu','twbd.education','=','edu.education_code')
                ->where('twbd.worker_id',$session_worker_id)
                ->select('twbd.education','edu.*')
                ->first();
            return view('worker.worker-family-details', $data);
        }
    }

    public function saveFamily(Request $request)
    {
        $rules = [
            'first_name.*' => 'required|string|max:255',
            'last_name.*' => 'required|string|max:255',
            'gurdain_name.*' => 'required|string|max:255',
            'dob.*' => 'required|date',
            'relation.*' => 'required|string|max:255',
            'profession.*' => 'nullable|string|max:255',
            'education.*' => 'nullable|string|max:255',
            'nominee.*' => 'nullable|string|max:255',
            'already_registered.*' => 'required|boolean',
            'bocwwb_id.*' => 'nullable|string|max:255',
        ];
        $messages = [
            'first_name.*.required' =>'First name cannot be blank',
            'last_name.*.required' =>'Last name cannot be blank',
            'gurdain_name.*.required' => 'Guardian name cannot be blank',
            'relation.*.required' => 'Relation cannot be blank',
            'profession.*.required' => 'Profession cannot be blank',
            'education.*.required' => 'Education cannot be blank',
            'dob.*.required' => 'Date of birth cannot be blank',
            'dob.*.date' => 'The date of birth must be a valid date.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $f_names = $request->first_name;
        $session_worker_id = session()->get('worker_id');
        DB::beginTransaction();
        try {
            if (is_array($f_names) && !empty($f_names)) {
                foreach ($f_names as $key => $f_name) {
                    $data = FamilyModel::Create([
                        'worker_id' => $session_worker_id,
                        'first_name' => $f_names[$key],
                        'last_name' => $request->last_name[$key],
                        'gurdain_name' => $request->gurdain_name[$key],
                        'dob' => $request->dob[$key],
                        'relation' => $request->relation[$key],
                        'profession' => $request->profession[$key],
                        'education' => $request->education[$key],
                        'nominee' => $request->nominee[$key],
                        'already_registered' => $request->already_registered[$key],
                        'bocwwb_id' => $request->bocwwb_id[$key],
                    ]);
                    if ($data != true) {
                        DB::rollback();
                        return redirect()->back()->with('error', '#WFM0001 Unable to insert data!');
                    }
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', '#WFM0002 DB exception error!');
        }

        return redirect()->route('submit-family-details');
    }
    public function updateFamily(Request $request)
    {
        $rules = [
            'first_name.*' => 'required|string|max:255',
            'last_name.*' => 'required|string|max:255',
            'gurdain_name.*' => 'required|string|max:255',
            'dob.*' => 'required|date',
            'relation.*' => 'required|string|max:255',
            'profession.*' => 'nullable|string|max:255',
            'education.*' => 'nullable|string|max:255',
            'nominee.*' => 'nullable|string|max:255',
            'already_registered.*' => 'required|boolean',
            'bocwwb_id.*' => 'nullable|string|max:255',
        ];
        $messages = [
            'first_name.*.required' =>'First name cannot be blank',
            'last_name.*.required' =>'Last name cannot be blank',
            'gurdain_name.*.required' => 'Guardian name cannot be blank',
            'relation.*.required' => 'Relation cannot be blank',
            'profession.*.required' => 'Profession cannot be blank',
            'education.*.required' => 'Education cannot be blank',
            'dob.*.required' => 'Date of birth cannot be blank',
            'dob.*.date' => 'The date of birth must be a valid date.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $f_names = $request->first_name;
        $session_worker_id = session()->get('worker_id');
        DB::beginTransaction();
        try {
            if (is_array($f_names) && !empty($f_names)) {
                $affectedRows = DB::table('Worker.temp_worker_family_models')
                    ->where('worker_id',$session_worker_id)->delete();
                foreach ($f_names as $key => $f_name) {
                    $data = FamilyModel::Create([
                        'worker_id' => $session_worker_id,
                        'first_name' => $f_names[$key],
                        'last_name' => $request->last_name[$key],
                        'gurdain_name' => $request->gurdain_name[$key],
                        'dob' => $request->dob[$key],
                        'relation' => $request->relation[$key],
                        'profession' => $request->profession[$key],
                        'education' => $request->education[$key],
                        'nominee' => $request->nominee[$key],
                        'already_registered' => $request->already_registered[$key],
                        'bocwwb_id' => $request->bocwwb_id[$key],
                    ]);

                        if ($data === false) {
                            DB::rollback();
                            return redirect()->back()->with('error', '#WFM0001 Unable to update data!');
                        }
                    }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            return redirect()->back()->with('error', '#WFM0002 DB exception error!');
        }

        return redirect()->route('submit-family-details');
    }

    public function pageEmployer(Request $request)
    {
        $session_worker_id = session()->get('worker_id');
        if (!$session_worker_id) {
            return $this->sessionFlash();
        }
        $data['formdata'] = $formdata = DB::table('Worker.temp_worker_employer_details as twed')
            ->join('Masterdata.type_of_work as tow','twed.type_of_work','=', 'tow.work_type_code')
            ->join('Masterdata.nature_of_work as now','twed.nature_of_work','=','now.nature_of_work_code')
            ->join('Masterdata.district as dist','twed.district','=','dist.district_code')
            ->join('Masterdata.subdistrict as subdist','twed.subdistrict','=','subdist.subdistrict_code')
            ->where('worker_id',$session_worker_id)
            ->select('twed.*','tow.*','now.*','dist.*','subdist.*')
            ->first();
        if ($formdata) {
            $data['districts'] = DB::table('Masterdata.district')->where('state_code', '=', '18')
                ->select('district_code', 'district_name', 'state_code')
                ->orderBy('district_name')->get();
            $data['worktype'] = DB::table('Masterdata.type_of_work')->select('work_type_code', 'work_type_name')->get();
            $data['worknature'] = DB::table('Masterdata.nature_of_work')->select('nature_of_work_code', 'nature_of_work')->get();
            return view('worker/edit.edit-worker-employer-details',$data);
        } else {
            $data['formdata'] = $formdata = DB::table('Worker.temp_worker_family_models')->where('worker_id', $session_worker_id)->first();
            $data['districts'] = DB::table('Masterdata.district')->where('state_code', '=', '18')
                ->select('district_code', 'district_name', 'state_code')
                ->orderBy('district_name')->get();
            $data['worktype'] = DB::table('Masterdata.type_of_work')->select('work_type_code', 'work_type_name')->get();
            $data['worknature'] = DB::table('Masterdata.nature_of_work')->select('nature_of_work_code', 'nature_of_work')->get();
            return view('worker.worker-employer-details', $data);

        }

    }

    public function saveEmployer(Request $request)
    {

        $validate = $request->validate([
            'employer_name' => 'required|regex:/^[\pL\s]+$/u',
            'board' => 'required|regex:/^[\pL\s]+$/u',
            'type_of_work' => 'required',
            'workplace' => 'required|custom_rule',
            'mobile' => 'required|digits:10',
            'district' => 'required',
            'city' => 'required',
            'pin_code' => 'required|digits:6|numeric',
            'doj' => 'required|date',
            'nature_of_work' => 'required',
            'subdistrict' => 'required',
            'mgnrega_no' => 'numeric'

        ],[
            'employer_name.required' => 'Employer Name cannot Be Blank',
            'board.required'=> 'Board Cannot Be Blank',
            'type_of_work.required' => 'Type Of Work Cannot Be Blank',
            'workplace.required' => 'Workplace Cannot Be Blank',
            'mobile.required' => 'Mobile No Cannot Be Blank',
            'mobile.digits' => 'Please Enter Ten Digit No',
            'mobile.regex' => 'Check Mobile No Properly',
            'district.required'=> 'District Cannot Be Blank',
            'city.required'=> 'City Cannot Be Blank',
            'pin_code.required' => 'Pin Code Cannot Be Blank',
            'pin_code.digits'=> 'Please Enter Six Digit Pin Code',
            'doj.required'=> 'Date Of Joining Cannot Be Blank',
            'doj.date' => 'The Date Of Joining Must Be a Valid Date',
            'nature_of_work.required' => 'Nature Of Work Cannot Be Blank',
            'subdistrict.required' => 'Sub-District Cannot Be Blank',
            'mgnrega_no.numeric' => 'mgnrega no should be a number'

        ]);
        $session_worker_id = session()->get('worker_id');
        if (!$session_worker_id) {
            return $this->sessionFlash();
        }

        $data = employerModel::Create([
            'worker_id' => $session_worker_id,
            'employer_name' => $request->employer_name,
            'board' => $request->board,
            'type_of_work' => $request->type_of_work,
            'workplace' => $request->workplace,
            'mobile' => $request->mobile,
            'district' => $request->district,
            'subdistrict' => $request->subdistrict,
            'city' => $request->city,
            'pin_code' => $request->pin_code,
            'doj' => $request->doj,
            'nature_of_work' => $request->nature_of_work,
            'mgnrega_no' => $request->mgnrega_no,

        ]);
        return redirect()->route('submit-employer-details');
    }
    public function updateEmployer(Request $request)
    {
        $validate = $request->validate([
            'employer_name' => 'required|regex:/^[\pL\s]+$/u',
            'board' => 'required|regex:/^[\pL\s]+$/u',
            'type_of_work' => 'required',
            'workplace' => 'required|custom_rule',
            'mobile' => 'required|digits:10',
            'district' => 'required',
            'city' => 'required',
            'pin_code' => 'required|digits:6|numeric',
            'doj' => 'required|date',
            'nature_of_work' => 'required',
            'subdistrict' => 'required',
            'mgnrega_no' => 'numeric',

        ],[
            'employer_name.required' => 'Employer Name cannot Be Blank',
            'board.required'=> 'Board Cannot Be Blank',
            'type_of_work.required' => 'Type Of Work Cannot Be Blank',
            'workplace.required' => 'Workplace Cannot Be Blank',
            'mobile.required' => 'Mobile No Cannot Be Blank',
            'mobile.digits' => 'Please Enter Ten Digit No',
            'mobile.regex' => 'Check Mobile No Properly',
            'district.required'=> 'District Cannot Be Blank',
            'city.required'=> 'City Cannot Be Blank',
            'pin_code.required' => 'Pin Code Cannot Be Blank',
            'pin_code.digits'=> 'Please Enter Six Digit Pin Code',
            'doj.required'=> 'Date Of Joining Cannot Be Blank',
            'doj.date' => 'The Date Of Joining Must Be a Valid Date',
            'nature_of_work.required' => 'Nature Of Work Cannot Be Blank',
            'subdistrict.required' => 'Sub-District Cannot Be Blank',
            'mgnrega_no.numeric' => 'mgnrega no should be a number',

        ]);
        $session_worker_id = session()->get('worker_id');
        if (!$session_worker_id) {
            return $this->sessionFlash();
        }
        $data = employerModel::where('worker_id', $session_worker_id)->update([
            'worker_id' =>  $session_worker_id,
            'employer_name' => $request->employer_name,
            'board' => $request->board,
            'type_of_work' => $request->type_of_work,
            'workplace' => $request->workplace,
            'mobile' => $request->mobile,
            'district' => $request->district,
            'subdistrict' => $request->subdistrict,
            'city' => $request->city,
            'pin_code' => $request->pin_code,
            'doj' => $request->doj,
            'nature_of_work' => $request->nature_of_work,
            'mgnrega_no' => $request->mgnrega_no,

        ]);
        return redirect()->route('submit-employer-details');
    }

    public function pageCertificate()
    {
        $session_worker_id = session()->get('worker_id');
        if (!$session_worker_id) {
            return $this->sessionFlash();
        }
        $data['formdata'] = $formdata = DB::table('Worker.temporary_worker_certificate')
                    ->where('worker_id', $session_worker_id)->first();
        if ($formdata) {
            $data['twc'] = DB::table('Worker.temporary_worker_certificate as twc')
                ->join('Masterdata.type_of_issuer_table as tot','twc.type_of_issuer','=','tot.issuer_code')
                ->where('twc.worker_id', $session_worker_id)
                ->select('twc.*','tot.*')
                ->get();
            $data['type_of_issuer'] = DB::table('Masterdata.type_of_issuer_table')
                ->select('issuer_code', 'issuer_name')
                ->get();
            return view('worker/edit.edit-worker-working-certificate',$data);
        } else {
            $data['formdata'] = $formdata = DB::table('Worker.temp_worker_employer_details')->where('worker_id', $session_worker_id)->first();

            $data['type_of_issuer'] = DB::table('Masterdata.type_of_issuer_table')
                ->select('issuer_code', 'issuer_name')
                ->get();
            return view('worker.worker-working-certificate', $data);

        }

    }

    public function saveCertificate(Request $request)
    {
        $rules = [
            'type_of_issuer.*' => 'required',
            'issue_date.*' => 'required|date',
            'issue_no.*' => 'required|string|max:255',
            'from_date.*' => 'required|date',
            'to_date.*' => 'required|date',
            'mobile.*' => 'required|digits:10',
            'type_of_employer.*' => 'required',
        ];
        $messages = [
            'type_of_issuer.*.required' => 'Type of issuer Cannot be blank',
            'issue_date.*.date' => 'The Date of issue must be a valid date.',
            'issue_date.*.required' => 'The Date of issue Cannot Be Blank.',
            'issue_no.*.required' => 'The Issue No Cannot Be Blank.',
            'from_date.*.date' => 'The From Date must be a valid date.',
            'from_date.*.required' => 'The From Date Cannot Be Blank.',
            'to_date.*.date' => 'The To Date must be a valid date.',
            'to_date.*.required' => 'The To Date must be a valid date.',
            'mobile.*.required' => 'Mobile No Cannot Be Blank',
            'type_of_employer.*.required' => 'Type Of Employer Cannot Be Blank',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $f_names = $request->type_of_issuer;
        $session_worker_id = session()->get('worker_id');
        DB::beginTransaction();
        try {
            if (is_array($f_names) && !empty($f_names)) {
                foreach ($f_names as $key => $f_name) {
                    $data = workerCertificate::Create([
                        'worker_id' => $session_worker_id,
                        'type_of_issuer' => $f_names[$key],
                        'name' => $request->name[$key],
                        'issue_date' => $request->issue_date[$key],
                        'issue_no' => $request->issue_no[$key],
                        'from_date' => $request->from_date[$key],
                        'to_date' => $request->to_date[$key],
                        'mobile' => $request->mobile[$key],
                        'type_of_employer' => $request->type_of_employer[$key],
                    ]);

                    if ($data != true) {
                        DB::rollback();
                        return redirect()->back()->with('error', '#WFM0001 Unable to insert data!');
                    }
                }
                DB::commit();
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', '#WFM0002 DB exception error!');
        }
        return redirect()->route('submit-certificate-details');
    }

    public function updateCertificate(Request $request)
    {

        $rules = [
            'type_of_issuer.*' => 'required',
            'issue_date.*' => 'required|date',
            'issue_no.*' => 'required|string|max:255',
            'from_date.*' => 'required|date',
            'to_date.*' => 'required|date',
            'mobile.*' => 'required|digits:10',
            'type_of_employer.*' => 'required',
        ];
        $messages = [
            'type_of_issuer.*.required' => 'Type of issuer Cannot be blank',
            'issue_date.*.date' => 'The Date of issue must be a valid date.',
            'issue_date.*.required' => 'The Date of issue Cannot Be Blank.',
            'issue_no.*.required' => 'The Issue No Cannot Be Blank.',
            'from_date.*.date' => 'The From Date must be a valid date.',
            'from_date.*.required' => 'The From Date Cannot Be Blank.',
            'to_date.*.date' => 'The To Date must be a valid date.',
            'to_date.*.required' => 'The To Date must be a valid date.',
            'mobile.*.required' => 'Mobile No Cannot Be Blank',
            'type_of_employer.*.required' => 'Type Of Employer Cannot Be Blank',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $f_names = $request->first_name;
        $session_worker_id = session()->get('worker_id');
        DB::beginTransaction();
        try {
            if (is_array($f_names) && !empty($f_names)) {
                $affectedRows = DB::table('Worker.temporary_worker_certificate')
                    ->where('worker_id',$session_worker_id)->delete();
                foreach ($f_names as $key => $f_name) {
                    $data = FamilyModel::Create([
                        'worker_id' => $session_worker_id,
                        'type_of_issuer' => $f_names[$key],
                        'name' => $request->name[$key],
                        'issue_date' => $request->issue_date[$key],
                        'issue_no' => $request->issue_no[$key],
                        'from_date' => $request->from_date[$key],
                        'to_date' => $request->to_date[$key],
                        'mobile' => $request->mobile[$key],
                        'type_of_employer' => $request->type_of_employer[$key],
                    ]);

                    if ($data === false) {
                        DB::rollback();
                        return redirect()->back()->with('error', '#WWC0001 Unable to update Certificate data!');
                    }
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            return redirect()->back()->with('error', '#WWC0002 DB exception error!');
        }

        return redirect()->route('submit-certificate-details');

    }

    public function pageSchemes(Request $request)
    {
        $session_worker_id = session()->get('worker_id');
        if (!$session_worker_id) {
            return $this->sessionFlash();
        }
        $data['formdata'] = $formdata = DB::table('Worker.temp_worker_schemes')->where('worker_id',$session_worker_id)->first();
        if ($formdata)
        {
            $data['tws'] = DB::table('Worker.temp_worker_schemes as tws')
                ->join('Masterdata.schemes as sch','tws.scheme_name','=','sch.scheme_code')
                ->where('tws.worker_id',$session_worker_id)
                ->select('tws.*','sch.*')
                ->get();

            $data['schemes'] = DB::table('Masterdata.schemes')
                ->select('scheme_code','scheme_name')->get();
           return view('worker/edit/edit-worker-schemes',$data);
        }
        else{
            $data['schemes'] = DB::table('Masterdata.schemes')
                ->select('scheme_code','scheme_name')->get();
            return view('worker.worker-schemes',$data);
        }

    }

    public function saveScheme(Request $request)
    {
        $rules = [
            'scheme_name.*' => 'required',
            'registration_id.*' => 'required|string|max:255',
            'date.*' => 'required|date',
        ];
        $messages = [
            'scheme_name.*.required' => 'Scheme Name Cannot be blank',
            'registration_id.*.required' => 'The Registration-id Cannot Be Blank',
            'date.*.required' => 'The Date of Registration Cannot Be Blank',
            'date.*.date' => 'The Date of Registration Must Be Valid Date',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $schemes = $request->scheme_name;
        $session_worker_id = session()->get('worker_id');
        DB::beginTransaction();
        try {
            if (is_array($schemes) && !empty($schemes))
            {
                foreach ($schemes as $key => $scheme){
                    $data = SchemesModel::Create([
                        'worker_id'=> $session_worker_id,
                       'scheme_name' => $schemes[$key],
                        'registration_id' => $request->registration_id[$key],
                        'date' => $request->date[$key],
                    ]);
//                    dd($data);
                  if ($data != true) {
                       DB::rollback();
                        return redirect()->back()->with('error', '#WSM0001 Unable to Update Scheme data!');
                    }
                }
               DB::commit();
            }
             }catch (\Exception $e)
         {
           DB::rollback();
           return redirect()->back()->with('error', '#WSM0002 DB exception error!');
         }
            return redirect()->route('submit-schemes-details');
    }
    public function updateScheme(Request $request)
    {
        $rules = [
            'scheme_name.*' => 'required',
            'registration_id.*' => 'required|string|max:255',
            'date.*' => 'required|date',
        ];
        $messages = [
            'scheme_name.*.required' => 'Scheme Name Cannot be blank',
            'registration_id.*.required' => 'The Registration-id Cannot Be Blank',
            'date.*.required' => 'The Date of Registration Cannot Be Blank',
            'date.*.date' => 'The Date of Registration Must Be Valid Date',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $schemes = $request->scheme_name;
        $session_worker_id = session()->get('worker_id');
        DB::beginTransaction();
        try {
            if (is_array($schemes) && !empty($schemes))
            {
                $affectedRows = DB::table('Worker.temp_worker_schemes')
                    ->where('worker_id',$session_worker_id)->delete();
                foreach ($schemes as $key => $scheme){
                    $data = SchemesModel::Create([
                        'worker_id'=> $session_worker_id,
                        'scheme_name' => $schemes[$key],
                        'registration_id' => $request->registration_id[$key],
                        'date' => $request->date[$key],
                    ]);
//                    dd($data);
                    if ($data != true) {
                        DB::rollback();
                        return redirect()->back()->with('error', '#WSC0001 Unable to insert Scheme data!');
                    }
                }
                DB::commit();
            }
        }catch (\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->with('error', '#WScC002 DB exception error!');
        }
        return redirect()->route('submit-schemes-details');
    }


    public function pageDocument(Request $request)
    {
        $session_worker_id = session()->get('worker_id');
        if (!$session_worker_id) {
            return $this->sessionFlash();
        }

        $data['formdata'] = $formdata = DB::table('Worker.temp_worker_documents')->where('worker_id', $session_worker_id)->first();
        if ($formdata){
            $data['twd'] = DB::table('Worker.temp_worker_documents')->where('worker_id', $session_worker_id)->first();
            $data['type_of_issuer'] = DB::table('Masterdata.type_of_issuer_table')->select('issuer_code', 'issuer_name')->get();
            $data['age_proof'] = DB::table('Masterdata.age_proof')->select('age_proof_code', 'age_proof_name')->get();
//            dd($data);
//            exit();
            return view('worker/edit/edit-worker-documents',$data);
        }
        else{
            $data['type_of_issuer'] = DB::table('Masterdata.type_of_issuer_table')->select('issuer_code', 'issuer_name')->get();
            $data['age_proof'] = DB::table('Masterdata.age_proof')->select('age_proof_code', 'age_proof_name')->get();
            return view('worker.worker-documents', $data);
        }

    }

    public function saveDocument(Request $request)
    {

        $mimes_pdf = env('PDF_MIME_TYPES');
        $mimes_img = env('IMG_MIME_TYPES');
        $validate = $request->validate([
            'id_proof' => 'required|'.$mimes_pdf.'|'.env('DOCUMENT_UPLOAD_SIZE'),
            'residential_proof' => 'required|'.$mimes_pdf.'|'.env('DOCUMENT_UPLOAD_SIZE'),
            'age_proof_id' => 'required',
            'age_proof' => 'required|'.$mimes_pdf.'|'.env('DOCUMENT_UPLOAD_SIZE'),
            'certificate_id' => 'required',
            'certificate_proof' => 'required|'.$mimes_pdf.'|'.env('DOCUMENT_UPLOAD_SIZE'),
            'passbook_xerox_proof' => 'required|'.$mimes_img.'|'.env('IMG_UPLOAD_SIZE'),
            'passport_image' => 'required|'.$mimes_img.'|'.env('IMG_UPLOAD_SIZE'),
            'thumb_image' => 'required|'.$mimes_img.'|'.env('IMG_UPLOAD_SIZE'),
            'bank_passbook' => 'required|'.$mimes_pdf.'|'.env('DOCUMENT_UPLOAD_SIZE'),
            'address_proof' => 'required|'.$mimes_pdf.'|'.env('DOCUMENT_UPLOAD_SIZE'),
            'declaration_file' => 'required|'.$mimes_img.'|'.env('IMG_UPLOAD_SIZE'),
        ],[
            'id_proof.required'=> 'Photo Id Proof Cannot Be Blank',
            'age_proof_id.required' => 'Age Proof Id Cannot Be Blank',
            'age_proof.required' => 'Age Proof Id Cannot be Blank',
            'certificate_id.required' => 'Certificate Id Type Cannot Be Blank',
            'certificate_proof.required' => 'Certificate Proof Cannot Be Blank',
            'passbook_xeorx_proof.required'=> 'Passbook Xerox Proof Cannot Be Blank',
            'passport_image.required'=>'Passport Image Cannot Be Blank',
            'thumb_image.required' => 'Thumb Image Cannot Be Blank',
            'bank_passbook.required'=>'Bank Passbook Cannot Be Blank',
            'address_proof.required'=>'Address Proof Cannot Be Blank',
            'declaration.required' => 'Declaration File Cannot Be Blank'

            ]);
        DB::beginTransaction();
        try {
            $session_worker_id = session()->get('worker_id');

            $generateUUID =(string)Str::orderedUuid();

            $id_proof_name =  'id-proof/'.$session_worker_id.$generateUUID. '.'.$request->id_proof->extension();
            Storage::disk('public')->put($id_proof_name, file_get_contents($request->id_proof->getRealPath()));

            $residential_proof_name =  'resident-proof/'.$session_worker_id.$generateUUID. '.'.$request->residential_proof->extension();
            Storage::disk('public')->put($residential_proof_name, file_get_contents($request->residential_proof->getRealPath()));

            $age_proof_name =  'age-proof/'.$session_worker_id.$generateUUID. '.'.$request->age_proof->extension();
            Storage::disk('public')->put($age_proof_name, file_get_contents($request->age_proof->getRealPath()));

            $pass_xerox_proof_name =  'passbook-xerox-copy/'.$session_worker_id.$generateUUID. '.'.$request->passbook_xerox_proof->extension();
            Storage::disk('public')->put($pass_xerox_proof_name, file_get_contents($request->passbook_xerox_proof->getRealPath()));

            $certificate_proof_name =  'certificate-proof/'.$session_worker_id.$generateUUID. '.'.$request->certificate_proof->extension();
            Storage::disk('public')->put($certificate_proof_name, file_get_contents($request->certificate_proof->getRealPath()));

            $passport_image =  'applicant-photo/'.$session_worker_id.$generateUUID. '.'.$request->passport_image->extension();
            Storage::disk('public')->put($passport_image, file_get_contents($request->passport_image->getRealPath()));

            $thumb =  'thumb/'   .$session_worker_id.$generateUUID. '.'.$request->thumb_image->extension();
            Storage::disk('public')->put($thumb, file_get_contents($request->thumb_image->getRealPath()));

            $address_proof =  'address-proof/'.$session_worker_id.$generateUUID. '.'.$request->address_proof->extension();
            Storage::disk('public')->put($address_proof, file_get_contents($request->address_proof->getRealPath()));

            $passbook_copy_name =  'bank-passbook/'.$session_worker_id.$generateUUID. '.'.$request->bank_passbook->extension();
            Storage::disk('public')->put($passbook_copy_name, file_get_contents($request->bank_passbook->getRealPath()));

            $declaration_name =  'declaration/'.$session_worker_id.$generateUUID. '.'.$request->declaration_file->extension();
            Storage::disk('public')->put($declaration_name, file_get_contents($request->declaration_file->getRealPath()));

            $data = DocumentModel::Create([
                'worker_id' => $session_worker_id,
                'id_proof' => "/private/{$id_proof_name}",
                'id_proof_ext' =>$request->id_proof->extension(),
                'residential_proof' => "/private/{$residential_proof_name}",
                'res_proof_ext' =>$request->residential_proof->extension(),
                'age_proof_id' => $request->age_proof_id,
                'age_proof' => "/private/{$age_proof_name}",
                'age_proof_ext' =>$request->age_proof->extension(),
                'passbook_xerox_proof' => "/private/{$pass_xerox_proof_name}",
                'certificate_id' => $request->certificate_id,
                'certificate_proof' => "/private/{$certificate_proof_name}",
                'certificate_proof_ext' =>$request->certificate_proof->extension(),
                'passport_image' => "/private/{$passport_image}",
                'thumb_image' => "/private/{$thumb}",
                'address_proof' => "/private/{$address_proof}",
                'address_proof_ext' => $request->address_proof->extension(),
                'bank_passbook' => "/private/{$passbook_copy_name}",
                'bank_passbook_ext' => $request->bank_passbook->extension(),
                'declaration_file' => "/private/{$declaration_name}",
            ]);
            if ($data != true) {
                DB::rollback();
                return redirect()->back()->with('error', '#WFM0003 Unable to insert data!');
            }
            DB::commit();

        } catch (\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->with('error', '#WFM000 DB exception error!');

        }
        return redirect()->route('submit-document-details');
    }
    /** Go to preview page */
    public  function previewPage(Request $request)
    {
        $session_worker_id = session()->get('worker_id');
        if (!$session_worker_id) {
            return $this->sessionFlash();
        }
        $session_worker_id = session()->get('worker_id');
        $data['tfm'] = DB::table('Worker.temp_form_models')->where('worker_id', $session_worker_id)->first();
        $data['twbd'] = DB::table('Worker.temp_worker_basic_details')->where('worker_id', $session_worker_id)->first();
        $data['twam'] = DB::table('Worker.temp_worker_address_models')->where('worker_id', $session_worker_id)->first();
        $data['twfm'] =  DB::table('Worker.temp_worker_family_models')->where('worker_id', $session_worker_id)->get();
        $data['twbm'] = DB::table('Worker.temp_worker_bank_models')->where('worker_id', $session_worker_id)->first();
        $data['twed'] = DB::table('Worker.temp_worker_employer_details')->where('worker_id', $session_worker_id)->first();
        $data['twc'] =  DB::table('Worker.temporary_worker_certificate')->where('worker_id', $session_worker_id)->get();
        $data['tws'] = DB::table('Worker.temp_worker_schemes')->where('worker_id',$session_worker_id)->get();
        $data['twd'] = DB::table('Worker.temp_worker_documents')->where('worker_id', $session_worker_id)->first();

        $data['twbdjoin']
            = DB::table('Worker.temp_worker_basic_details as twbd')
            ->join('Masterdata.gender as gen', 'twbd.gender', '=', 'gen.gender_code')
            ->join('Masterdata.marital_status as ms', 'twbd.maritial_status', '=', 'ms.marital_code')
            ->join('Masterdata.education as edu', 'twbd.education', '=', 'edu.education_code')
            ->join('Masterdata.category as cat', 'twbd.category', '=', 'cat.category_code')
            ->where('twbd.worker_id', $session_worker_id)
            ->select('twbd.*','gen.*', 'ms.*', 'cat.*', 'edu.*')
            ->first();
        $data['twamjoin'] = DB::table('Worker.temp_worker_address_models as twam')
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
            ->where('twam.worker_id', $session_worker_id)
            ->select('twam.*','cres.*', 'pres.*', 'chs.*', 'phs.*', 'cst.*', 'pst.*', 'cds.*', 'pds.*','scds.*','spds.*','cpo.*','ppo.*')
            ->first();
        $data['twedjoin'] = DB::table('Worker.temp_worker_employer_details as twed')
            ->join('Masterdata.type_of_work as tow','twed.type_of_work','=','tow.work_type_code')
            ->join('Masterdata.nature_of_work as now','twed.nature_of_work','=', 'now.nature_of_work_code')
            ->join('Masterdata.district as cds', 'twed.district', '=', 'cds.district_code')
            ->join('Masterdata.subdistrict as sd', 'twed.subdistrict', '=', 'sd.subdistrict_code')
            ->where('twed.worker_id',$session_worker_id)
            ->select('twed.*','tow.*','now.*','cds.*','sd.*')
            ->first();
        $data['twcjoin'] = DB::table('Worker.temporary_worker_certificate as twc')
            ->join('Masterdata.type_of_issuer_table as toi','twc.type_of_issuer','=','toi.issuer_code')
            ->where('twc.worker_id',$session_worker_id)
            ->select('twc.*','toi.*')
            ->get();
        $data['twsjoin'] = DB::table('Worker.temp_worker_schemes as tws')
            ->join('Masterdata.schemes as sc','tws.scheme_name','=','sc.scheme_code')
            ->where('tws.worker_id',$session_worker_id)
            ->select('tws.*','sc.*')
            ->get();
        $data['twdcj'] = DB::table('Worker.temp_worker_documents as twdc')
            ->join('Masterdata.age_proof as apt','twdc.age_proof_id','=','apt.age_proof_code')
            ->where('twdc.worker_id',$session_worker_id)
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

        return view('worker.worker-preview-details',$data);
    }

    public function getIdProof()
    {
        $session_worker_id = session()->get('worker_id');
        $id_proof = DB::table('Worker.temp_worker_documents')
            ->where('worker_id',$session_worker_id)
            ->first();
        $headers = ['Content-Type' => 'application/pdf'];
        $file = Storage::path($id_proof->id_proof);
        // dd($file);
        return response()->file($file);
    }

    public function getResProof()
    {
        $session_worker_id = session()->get('worker_id');
        $res_proof = DB::table('Worker.temp_worker_documents')
            ->where('worker_id',$session_worker_id)
            ->first();
//        dd($res_proof);
        $headers = ['Content-Type' => 'application/pdf'];
        $file = Storage::path($res_proof->residential_proof);
        return response()->file($file);

    }

    public function getAgeProof()
    {
        $session_worker_id = session()->get('worker_id');
        $age_proof = DB::table('Worker.temp_worker_documents')
            ->where('worker_id',$session_worker_id)
            ->first();
        $headers = ['Content-Type' => 'application/pdf'];
        $file = Storage::path($age_proof->age_proof);
        return response()->file($file);

    }
    public function getBankXerox()
    {
        $session_worker_id = session()->get('worker_id');
        $pass_xerox = DB::table('Worker.temp_worker_documents')
            ->where('worker_id',$session_worker_id)
            ->first();
        $headers = ['Content-Type' => 'application/pdf'];
        $file = Storage::path($pass_xerox->passbook_xerox_proof);
        return response()->file($file);

    }
    public function getCertProof()
    {
        $session_worker_id = session()->get('worker_id');
        $cert_proof = DB::table('Worker.temp_worker_documents')
            ->where('worker_id',$session_worker_id)
            ->first();
        $headers = ['Content-Type' => 'application/jpg'];
        $file = Storage::path($cert_proof->certificate_proof);
        return response()->file($file);
    }
    public function getPassport()
    {
        $session_worker_id = session()->get('worker_id');
        $passport = DB::table('Worker.temp_worker_documents')
            ->where('worker_id',$session_worker_id)
            ->first();
        $headers = ['Content-Type' => 'application/jpg'];
        $file = Storage::path($passport->passport_image);
        return response()->file($file);
    }
    public function getThumb()
    {
        $session_worker_id = session()->get('worker_id');
        $thumb = DB::table('Worker.temp_worker_documents')
            ->where('worker_id',$session_worker_id)
            ->first();
        $headers = ['Content-Type' => 'application/jpg'];
        $file = Storage::path($thumb->thumb_image);
        return response()->file($file);
    }
    public function getAddress()
    {
        $session_worker_id = session()->get('worker_id');
        $address_proof = DB::table('Worker.temp_worker_documents')
            ->where('worker_id',$session_worker_id)
            ->first();
        $headers = ['Content-Type' => 'application/jpg'];
        $file = Storage::path($address_proof->address_proof);
        return response()->file($file);
    }
    public function getBankCopy()
    {
        $session_worker_id = session()->get('worker_id');
        $getBankCopy = DB::table('Worker.temp_worker_documents')
            ->where('worker_id',$session_worker_id)
            ->first();
        $headers = ['Content-Type' => 'application/jpg'];
        $file = Storage::path($getBankCopy->bank_passbook);
        return response()->file($file);

    }
    public function decl()
    {
        $session_worker_id = session()->get('worker_id');
        $decl = DB::table('Worker.temp_worker_documents')
            ->where('worker_id',$session_worker_id)
            ->first();
        $headers = ['Content-Type' => 'application/jpg'];
        $file = Storage::path($decl->declaration_file);
        return response()->file($file);

    }

    public function finalSubmit(Request $request)
    {

        $session_worker_id = session()->get('worker_id');
//        DB::beginTransaction();
//        try {
            $tfm = DB::table('Worker.temp_form_models')->where('worker_id', $session_worker_id)->first();
            $data = MainFormModel::Create([
                'worker_id' => $session_worker_id,
                'office_id' => $tfm->office_id,
                'phone_no' => $tfm->phone_no,
                'district' =>$tfm->district,
                'status' => env('APPLICATION_SUBMIT_STATUS'),
            ]);

            $twbd = DB::table('Worker.temp_worker_basic_details')->where('worker_id', $session_worker_id)->first();
            $data = MainBasicDetails::Create([
                'worker_id' => $twbd->worker_id,
                'first_name' => $twbd->first_name,
                'last_name' => $twbd->last_name,
                'gurdain_name' => $twbd->gurdain_name,
                'gender' => $twbd->gender,
                'maritial_status' => $twbd->maritial_status,
                'category' => $twbd->category,
                'dob' => $twbd->dob,
                'eshram_no' => $twbd->eshram_no,
                'education' => $twbd->education,
                'pf_no' => $twbd->pf_no,
                'esic_no' => $twbd->esic_no,
                'email' => $twbd->email,
            ]);
            $twam = DB::table('Worker.temp_worker_address_models')->where('worker_id', $session_worker_id)->first();
            $data = MainAddressModel::Create([
                'worker_id' => $session_worker_id,
                'c_residence' => $twam->c_residence,
                'c_house_type' => $twam->c_house_type,
                'c_house_no' => $twam->c_house_no,
                'c_road' => $twam->c_road,
                'c_area' => $twam->c_area,
                'c_city' => $twam->c_city,
                'c_state' => $twam->c_state,
                'c_district' => $twam->c_district,
                'c_post_office' => $twam->c_post_office,
                'c_pin' => $twam->c_pin,
                'c_std' => $twam->c_std,
                'c_circle' => $twam->c_circle,
                'landmark' => $twam->landmark,
                'p_residence' => $twam->p_residence,
                'p_house_type' => $twam->p_house_type,
                'p_house_no' => $twam->p_house_no,
                'p_road' => $twam->p_road,
                'p_area' => $twam->p_area,
                'p_city' => $twam->p_city,
                'p_state' => $twam->p_state,
                'p_district' => $twam->p_district,
                'p_post_office' => $twam->p_post_office,
                'p_pin' => $twam->p_pin,
                'p_std' => $twam->p_std,
                'p_circle' => $twam->p_circle,
                'ration_type' => $twam->ration_type,
                'ration_no' => $twam->ration_no,
                'landline' => $twam->landline,

            ]);
            $data['twfms'] =  DB::table('Worker.temp_worker_family_models')->where('worker_id', $session_worker_id)->get();
            foreach ($data['twfms'] as $twfm)
            {
                $data = MainFamilyModel::Create([
                    'worker_id' => $session_worker_id,
                    'first_name' => $twfm->first_name,
                    'last_name' => $twfm->last_name,
                    'gurdain_name' => $twfm->gurdain_name,
                    'dob' => $twfm->dob,
                    'relation' => $twfm->relation,
                    'profession' => $twfm->profession,
                    'education' => $twfm->education,
                    'nominee' => $twfm->nominee,
                    'already_registered' => $twfm->already_registered,
                    'bocwwb_id' => $twfm->bocwwb_id,
                ]);
            }
            $twbm = DB::table('Worker.temp_worker_bank_models')->where('worker_id', $session_worker_id)->first();
            $data = MainBankModel::Create([
                'worker_id' => $session_worker_id,
                'ifsc_pk' => $twbm->ifsc_pk,
                'bank_name' => $twbm->bank_name,
                'branch_name' => $twbm->branch_name,
                'bank_address' => $twbm->bank_address,
                'account_no' => $twbm->account_no,
            ]);
            $twed = DB::table('Worker.temp_worker_employer_details')->where('worker_id', $session_worker_id)->first();
            $data = MainEmpModel::Create([
                'worker_id' => $session_worker_id,
                'employer_name' => $twed->employer_name,
                'board' => $twed->board,
                'type_of_work' => $twed->type_of_work,
                'workplace' => $twed->workplace,
                'mobile' => $twed->mobile,
                'district' => $twed->district,
                'subdistrict' => $twed->subdistrict,
                'city' => $twed->city,
                'pin_code' => $twed->pin_code,
                'doj' => $twed->doj,
                'nature_of_work' => $twed->nature_of_work,

            ]);

            $data['twc'] =  DB::table('Worker.temporary_worker_certificate')->where('worker_id', $session_worker_id)->get();
            foreach ( $data['twc'] as $twc)
            {
                $data = MainCertificateModel::Create([
                    'worker_id' => $session_worker_id,
                    'name' => $twc->name,
                    'type_of_issuer' => $twc->type_of_issuer,
                    'issue_date' => $twc->issue_date,
                    'issue_no' => $twc->issue_no,
                    'from_date' => $twc->from_date,
                    'to_date' => $twc->to_date,
                    'mobile' => $twc->mobile,
                    'type_of_employer' => $twc->type_of_employer,

                ]);
            }
            $data['tws'] = DB::table('Worker.temp_worker_schemes')->where('worker_id',$session_worker_id)->get();
            foreach ($data['tws'] as $tws){
                $data = WorkerSchemeModel::Create([
                    'worker_id' => $session_worker_id,
                    'scheme_name'=> $tws->scheme_name,
                    'registration_id'=> $tws->registration_id,
                    'date' => $tws->date,
                ]);
            }
            $twd = DB::table('Worker.temp_worker_documents')->where('worker_id', $session_worker_id)->first();
            $data = MainDocumentModel::Create([
                'worker_id' => $session_worker_id,
//                'photo_id' => $twd->photo_id,
                'id_proof' => $twd->id_proof,
                'id_proof_ext' =>$twd->id_proof_ext,
//                'residential_id' => $twd->residential_id,
                'residential_proof' => $twd->residential_proof,
                'res_proof_ext' =>$twd->res_proof_ext,
                'age_proof_id' => $twd->age_proof_id,
                'age_proof' => $twd->age_proof,
                'age_proof_ext' =>$twd->age_proof_ext,
//                'passbook_xerox_id' => $twd->passbook_xerox_id,
                'passbook_xerox_proof' => $twd->passbook_xerox_proof,
                'certificate_id' => $twd->certificate_id,
                'certificate_proof' => $twd->certificate_proof,
                'certificate_proof_ext' =>$twd->certificate_proof_ext,
                'passport_image' => $twd->passport_image,
                'thumb_image' => $twd->thumb_image,
                'address_proof' => $twd->address_proof,
                'address_proof_ext' => $twd->address_proof_ext,
                'bank_passbook' => $twd->bank_passbook,
                'bank_passbook_ext' => $twd->bank_passbook_ext,
                'declaration_file' => $twd->declaration_file,
            ]);
            return redirect()->route('print-ack')->with('success','Successfully Submitted !');
//        }catch(QueryException $e)
//        {
//            DB::rollback();
////            dd($data);
////            exit();
//            return redirect()->back()->with('error', 'Error submitting data. Please try again.');
//        }

    }
    public function ackPage()
    {
        $session_worker_id = session()->get('worker_id');
        if (!$session_worker_id) {
            return $this->sessionFlash();
        }
    $data['worker'] = DB::table('Worker.worker_main_form_models')->where('worker_id',$session_worker_id)->first();
        $data['mwf'] = DB::table('Worker.worker_main_form_models as wmfm')
            ->join('Masterdata.office as ofc','wmfm.office_id','=','ofc.office_id')
            ->where('worker_id',$session_worker_id)
            ->select('wmfm.*','ofc.*')
            ->first();
        $data['mfb'] = DB::table('Worker.worker_main_basic_details as wmbd')
            ->where('worker_id',$session_worker_id)
            ->select('wmbd.*')
            ->first();
//        $data['success'] = 'User registered successfully!';
        $successMessage = session('success', 'Default success message if not set');
        return view('worker.worker-acknowledgement',$data);
    }
    public function editDocument()
    {
        $session_worker_id = session()->get('worker_id');
        if (!$session_worker_id) {
            return $this->sessionFlash();
        }
        $data['twd'] = DB::table('Worker.temp_worker_documents')->where('worker_id', $session_worker_id)->first();
        return view('worker.edit/edit-worker-documents',$data);

    }
    public function updateDocument(Request $request)
    {
        $generateUUID =(string)Str::orderedUuid();
        $session_worker_id = session()->get('worker_id');
        $mimes = env('DOCUMENT_MIME_TYPES');
        $document = DB::table('Worker.temp_worker_documents')->where('worker_id', $session_worker_id)->first();

      /**Id Proof update **/
        if ($request->document_id == 1)
        {
            $validate = $request->validate([
                'id_file' => 'required|'.$mimes.'|'.env('DOCUMENT_UPLOAD_SIZE')
            ]);
            $id_proof_name =  'id-proof/'.$session_worker_id.$generateUUID. '.'.$request->id_file->extension();
            $data = DocumentModel::where('worker_id', $session_worker_id)->update([
                'id_proof' => "/private/{$id_proof_name}",
            ]);
            Storage::disk('public')->put($id_proof_name, file_get_contents($request->id_file->getRealPath()));
            $file_path = Storage::path($document->id_proof);
            if (file_exists($file_path)) {
                unlink($file_path);
                return redirect()->back()->with('success','Id Proof Updated Successfully!');
            }
            else{
                return redirect()->back()->with('error','Update Failed!');
            }
//            File::delete($file_path);
        }
        /** Resident Proof update **/
        if ($request->document_id == 2)
        {
            $validate = $request->validate([
                'res_file' => 'required|'.$mimes.'|'.env('DOCUMENT_UPLOAD_SIZE')
            ]);
            $residential_proof_name =  'resident-proof/'.$session_worker_id.$generateUUID. '.'.$request->res_file->extension();
            $data = DocumentModel::where('worker_id', $session_worker_id)->update([
                'residential_proof' => "/private/{$residential_proof_name}",
            ]);
            Storage::disk('public')->put($residential_proof_name, file_get_contents($request->res_file->getRealPath()));
            $file_path = Storage::path($document->residential_proof);
            if (file_exists($file_path)) {
                unlink($file_path);
                return redirect()->back()->with('success','Residential Proof Updated Successfully!');
            }
            else{
                return redirect()->back()->with('error','Update Failed!');
            }
//            dd('updated');
//            exit();
        }
        /**age proof update**/
        if ($request->document_id == 3)
        {
            $validate = $request->validate([
                'age_file' => 'required|'.$mimes.'|'.env('DOCUMENT_UPLOAD_SIZE')
            ]);
            $age_proof_name =  'age-proof/'.$session_worker_id.$generateUUID. '.'.$request->age_file->extension();
            $data = DocumentModel::where('worker_id', $session_worker_id)->update([
                'age_proof' => "/private/{$age_proof_name}",
            ]);
            Storage::disk('public')->put($age_proof_name, file_get_contents($request->age_file->getRealPath()));
            $file_path = Storage::path($document->age_proof);
            if (file_exists($file_path)) {
                unlink($file_path);
                return redirect()->back()->with('success','Age Proof Updated Successfully!');
            }
            else{
                return redirect()->back()->with('error','Update Failed!');
            }
//            dd('updated');
//            exit();
        }
        /** bank passbook xerox */
        if ($request->document_id == 4)
        {
            $validate = $request->validate([
                'bank_file' => 'required|'.$mimes.'|'.env('DOCUMENT_UPLOAD_SIZE')
            ]);
            $pass_xerox_proof_name =  'passbook-xerox-copy/'.$session_worker_id.$generateUUID. '.'.$request->bank_file->extension();
            $data = DocumentModel::where('worker_id', $session_worker_id)->update([
                'passbook_xerox_proof' => "/private/{$pass_xerox_proof_name}",
            ]);
            Storage::disk('public')->put($pass_xerox_proof_name, file_get_contents($request->bank_file->getRealPath()));
            $file_path = Storage::path($document->passbook_xerox_proof);
            if (file_exists($file_path)) {
                unlink($file_path);
                return redirect()->back()->with('success','Passbook Updated Successfully!');
            }
            else{
                return redirect()->back()->with('error','Update Failed!');
            }
//            dd($file_path);
//            exit();
        }
        /** certificate proof */
        if ($request->document_id == 5)
        {
            $validate = $request->validate([
                'certificate_file' => 'required|'.$mimes.'|'.env('DOCUMENT_UPLOAD_SIZE')
            ]);
            $certificate_proof_name =  'certificate-proof/'.$session_worker_id.$generateUUID. '.'.$request->certificate_file->extension();

            $data = DocumentModel::where('worker_id', $session_worker_id)->update([
                'certificate_proof' => "/private/{$certificate_proof_name}",
            ]);
            Storage::disk('public')->put($certificate_proof_name, file_get_contents($request->certificate_file->getRealPath()));
            $file_path = Storage::path($document->certificate_proof);
            if (file_exists($file_path)) {
                unlink($file_path);
                return redirect()->back()->with('success','Certificate Proof Updated Successfully!');
            }
            else{
                return redirect()->back()->with('error','Update Failed!');
            }
    /** Applicant image  */
        }
        if ($request->document_id == 6)
        {
            $validate = $request->validate([
                'passport_file' => 'required|'.$mimes.'|'.env('DOCUMENT_UPLOAD_SIZE')
            ]);
            $passport_image =  'applicant-photo/'.$session_worker_id.$generateUUID. '.'.$request->passport_file->extension();

            $data = DocumentModel::where('worker_id', $session_worker_id)->update([
                'passport_image' => "/private/{$passport_image}",
            ]);
            Storage::disk('public')->put($passport_image, file_get_contents($request->passport_file->getRealPath()));
            $file_path = Storage::path($document->passport_image);
            if (file_exists($file_path)) {
                unlink($file_path);
                return redirect()->back()->with('success','Applicant Image Updated Successfully!');
            }
            else{
                return redirect()->back()->with('error','Update Failed!');
            }
        }
    /** Thumb image **/
        if ($request->document_id == 7)
        {
            $validate = $request->validate([
                'thumb_file' => 'required|'.$mimes.'|'.env('DOCUMENT_UPLOAD_SIZE')
            ]);
            $thumb =  'thumb/'.$session_worker_id.$generateUUID. '.'.$request->thumb_file->extension();

            $data = DocumentModel::where('worker_id', $session_worker_id)->update([
                'thumb_image' => "/private/{$thumb}",
            ]);
            Storage::disk('public')->put($thumb, file_get_contents($request->thumb_file->getRealPath()));
            $file_path = Storage::path($document->thumb_image);
            if (file_exists($file_path)) {
                unlink($file_path);
                return redirect()->back()->with('success','Thumb Image Updated Successfully!');
            }
            else{
                return redirect()->back()->with('error','Update Failed!');
            }
        }

        /** address proof */
        if ($request->document_id == 8)
        {
            $validate = $request->validate([
                'address_file' => 'required|'.$mimes.'|'.env('DOCUMENT_UPLOAD_SIZE')
            ]);
            $address_proof =  'address-proof/'.$session_worker_id.$generateUUID. '.'.$request->address_file->extension();
            $data = DocumentModel::where('worker_id', $session_worker_id)->update([
                'address_proof' => "/private/{$address_proof}",
            ]);
            Storage::disk('public')->put($address_proof, file_get_contents($request->address_file->getRealPath()));
            $file_path = Storage::path($document->address_proof);
            if (file_exists($file_path)) {
                unlink($file_path);
                return redirect()->back()->with('success','Address Proof Updated Successfully!');
            }
            else{
                return redirect()->back()->with('error','Update Failed!');
            }
        }
        /** Passbook Copy */
        if ($request->document_id == 9)
        {
            $validate = $request->validate([
                'pass_file' => 'required|'.$mimes.'|'.env('DOCUMENT_UPLOAD_SIZE')
            ]);
            $passbook_copy_name =  'bank-passbook/'.$session_worker_id.$generateUUID. '.'.$request->pass_file->extension();
            $data = DocumentModel::where('worker_id', $session_worker_id)->update([
                'bank_passbook' => "/private/{$passbook_copy_name}",
            ]);
            Storage::disk('public')->put($passbook_copy_name, file_get_contents($request->pass_file->getRealPath()));
            $file_path = Storage::path($document->bank_passbook);
            if (file_exists($file_path)) {
                unlink($file_path);
                return redirect()->back()->with('success','Bank Passbook Updated Successfully!');
            }
            else{
                return redirect()->back()->with('error','Update Failed!');
            }
        }
        /** declaration file */
        if ($request->document_id == 10)
        {
            $validate = $request->validate([
                'decl_file' => 'required|'.$mimes.'|'.env('DOCUMENT_UPLOAD_SIZE')
            ]);
            $declaration_name =  'declaration/'.$session_worker_id.$generateUUID. '.'.$request->decl_file->extension();
            $data = DocumentModel::where('worker_id', $session_worker_id)->update([
                'declaration_file' => "/private/{$declaration_name}",
            ]);
            Storage::disk('public')->put($declaration_name, file_get_contents($request->decl_file->getRealPath()));
            $file_path = Storage::path($document->declaration_file);
            if (file_exists($file_path)) {
                unlink($file_path);
                return redirect()->back()->with('success','Declaration file Updated Successfully!');
            }
            else{
                return redirect()->back()->with('error','Update Failed!');
            }
        }

    }
            public function previewFromDoc()
            {
                return view('worker.worker-preview-details');
            }

            public function editSchemes(Request $request)
            {
                $session_worker_id = session()->get('worker_id');
                if (!$session_worker_id) {
                    return $this->sessionFlash();
                }
                $data['formdata'] = $formdata = DB::table('Worker.temp_worker_schemes')->where('worker_id', $session_worker_id)->first();
                if ($formdata) {
                    $data['formdata'] = $formdata = DB::table('Worker.temp_worker_family_models as twfm')
                        ->join('Worker.temp_form_models as tfm', 'twfm.worker_id', '=', 'tfm.worker_id')
                        ->join('Worker.temp_worker_basic_details as twbd', 'twfm.worker_id', '=', 'twbd.worker_id')
                        ->where('twfm.worker_id', $session_worker_id)
                        ->select('tfm.worker_id', 'twfm.*')
                        ->get();
                    return view('worker/edit.edit-worker-schemes-details', $data);
                }

            }

}


