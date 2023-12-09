<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserLoginController;
use App\Http\Controllers\Admin\MasterdataController;
use App\Http\Controllers\Worker\WorkerLoginController;
use App\Http\Controllers\Worker\MasterWorkerController;
use App\Http\Controllers\Worker\WorkerProfileController;
use App\Http\Controllers\Admin\UsercreateController;
use App\Http\Controllers\Office\OfficeinfoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    //return view('index');
    $data['dists'] = DB::table('Masterdata.district')->where('state_code', '=', 18)->get();
    return view('index', $data);
});

Route::get('/reload-captcha', [UserLoginController::class, 'reloadCaptcha']);
Route::prefix('admin')->group(function () {
    Route::get('/login', [UserLoginController::class, 'index']);
    Route::get('/logout', [UserLoginController::class, 'logout']);
    Route::get('/loginsuccess', [UserLoginController::class, 'loginSucess']);
    Route::post('/checklogin', [UserLoginController::class, 'checkLogin']);
    Route::post('/checkofficelogin', [UserLoginController::class, 'checkofficeLogin']);
    Route::get('/state',[MasterdataController::class,'stateentryForm']);
    Route::post('/addstate',[MasterdataController::class,'addState']);
    Route::get('/district',[MasterdataController::class,'districtentryform']);
    Route::post('/adddistrict',[MasterdataController::class,'addDistrict']);
    Route::get('/postoffice',[MasterdataController::class,'postofficeentryForm']);
    Route::post('/getdistrict',[MasterdataController::class,'getdistrictinfo']);
    Route::post('/getpostoffice',[MasterdataController::class,'getpostofficeinfo']);
    Route::post('/addpo',[MasterdataController::class,'addPo']);
    Route::get('/subdistrict',[MasterdataController::class,'subdistrictentryform']);
    Route::post('/addsubdis',[MasterdataController::class,'addSubdistrict']);
    Route::get('/bank',[MasterdataController::class,'bankentryform']);
    Route::post('/getbankdetails',[MasterdataController::class,'getbankinfo']);
    Route::post('/addbank',[MasterdataController::class,'addBank']);
    Route::get('/category',[MasterdataController::class,'categoryentryform']);
    Route::post('/addcategory',[MasterdataController::class,'addCategory']);
    Route::get('/education',[MasterdataController::class,'educationentryform']);
    Route::post('/addeducation',[MasterdataController::class,'addEducation']);
    Route::get('/gender',[MasterdataController::class,'genderentryform']);
    Route::post('/addgender',[MasterdataController::class,'addGender']);
    Route::get('/housetype',[MasterdataController::class,'housetypeentryform']);
    Route::post('/addhousetype',[MasterdataController::class,'addHousetype']);
    Route::get('/maritialstatus',[MasterdataController::class,'maritialstatusentryform']);
    Route::post('/addmaritalstatus',[MasterdataController::class,'addMaritalstatus']);
    Route::get('/natureofwork',[MasterdataController::class,'natureofworkentryform']);
    Route::post('/addnatureofwork',[MasterdataController::class,'addNatureofwork']);
    Route::get('/residencetype',[MasterdataController::class,'residencetypeentryform']);
    Route::post('/addresidencetype',[MasterdataController::class,'addResidencetype']);
    Route::get('/issuertype',[MasterdataController::class,'issuertypeentryform']);
    Route::post('/addissuertype',[MasterdataController::class,'addIssuertype']);
    Route::get('/worktype',[MasterdataController::class,'worktypeentryform']);
    Route::post('/addworktype',[MasterdataController::class,'addWorktype']);
    Route::get('/officelist',[MasterdataController::class,'officelistentryform']);
    Route::post('/addoffice',[MasterdataController::class,'addOffice']);
    Route::get('/rolelist',[MasterdataController::class,'rolelistentryform']);
    Route::post('/addrole',[MasterdataController::class,'addRole']);
    Route::get('/designation',[MasterdataController::class,'designationentryform']);
    Route::post('/adddesignation',[MasterdataController::class,'addDesignation']);
    Route::get('/ageproof',[MasterdataController::class,'ageproofentryform']);
    Route::post('/addageproof',[MasterdataController::class,'addAgeproof']);
    Route::get('/scheme',[MasterdataController::class,'schemesentryform']);
    Route::post('/addscheme',[MasterdataController::class,'addScheme']);
    Route::get('/userlist',[UsercreateController::class,'userlistentryform']);
    Route::post('/adduser',[UsercreateController::class,'addUser']);
    Route::post('/enableuser',[UsercreateController::class,'enableUser']);
    Route::post('/disableuser',[UsercreateController::class,'disableUser']);
});
Route::prefix('office')->group(function () {
    Route::get('/officeloginsuccess', [OfficeinfoController::class, 'officeloginSuccess'])->name('officeloginsuccess');
    Route::get('/officeapplications/{id}',[OfficeinfoController::class,'applicationDetails'])->name('office-applications');
    Route::post('/application-approve',[OfficeinfoController::class,'approveApplication'])->name('approve_application');
    Route::post('/application-reject',[OfficeinfoController::class,'rejectApplication'])->name('reject_application');
    Route::post('/application-forward',[OfficeinfoController::class,'forwardApplication'])->name('forward_application');
    Route::post('/application-forward-ro',[OfficeinfoController::class,'forwardApplicationRo'])->name('forwardro-application');
    Route::get('/logout', [UserLoginController::class, 'logout']);
    Route::post('/changepassword', [OfficeinfoController::class, 'changePassword']);
    Route::get('/application-received',[OfficeinfoController::class,'applicationReceived'])->name('application-received');
    Route::get('/application-pending',[OfficeinfoController::class,'application-pending'])->name('application-pending');
    Route::get('/application-approved',[OfficeinfoController::class,'applicationApproved'])->name('application-approved');
    Route::get('/application-rejected',[OfficeinfoController::class,'application-rejected'])->name('application-rejected');
    Route::get('get-worker-id-proof/{id}/{worker_id}',[OfficeinfoController::class,'getIdProof'])->name('office-id-proof');
    Route::get('get-worker-res-proof/{id}/{worker_id}',[OfficeinfoController::class,'getResProof'])->name('office-res-proof');
    Route::get('get-worker-age-proof/{id}/{worker_id}',[OfficeinfoController::class,'getAgeProof'])->name('office-age-proof');
    Route::get('get-worker-bank-copy/{id}/{worker_id}',[OfficeinfoController::class,'getBankXerox'])->name('office-bank-copy');
    Route::get('get-worker-certificate-proof/{id}',[OfficeinfoController::class,'getCertProof'])->name('office-cert-proof');
    Route::get('get-worker-passport/{id}/{worker_id}',[OfficeinfoController::class,'getPassport'])->name('office-passport');
    Route::get('get-worker-thumb/{id}/{worker_id}',[OfficeinfoController::class,'getThumb'])->name('office-thumb');
    Route::get('get-worker-address-proof/{id}/{worker_id}',[OfficeinfoController::class,'getAddress'])->name('office-address-proof');
    Route::get('get-worker-bank-pass/{id}/{worker_id}',[OfficeinfoController::class,'getBankCopy'])->name('office-bank-pass');
    Route::get('get-worker-decl/{id}/{worker_id}',[OfficeinfoController::class,'decl'])->name('office-decl');
});

Route::get('/worker-dashboard',[WorkerLoginController::class,'loginDash'])->name('worker-dashboard');
/** Route Worker details */
Route::prefix('worker')->group(function(){
    Route::post('/user-login',[WorkerLoginController::class,'workerLogin']);
    Route::post('/user-logout',[WorkerLoginController::class,'logoutUser'])->name('user-logout');
    Route::get('/worker-dashboard',[WorkerLoginController::class,'loginDash'])->name('worker-dashboard');
    Route::get('/worker-claimed-schemes',[MasterWorkerController::class,'getScheme'])->name('worker-claimed-schemes');
//    Route::get('/',[MasterWorkerController::class,'index'])->name('homepage');
  /**save prelimnary data **/
    Route::post('/worker-registration',[MasterWorkerController::class,'saveModal'])->name('worker-reg');

    /** route to Basic Deatils page */
    Route::get('worker-basic-details',[MasterWorkerController::class,'mainPage'])->name('main-page');

    /** save basic details */
    Route::post('save-basic-details',[MasterWorkerController::class,'saveBasic'])->name('save-basic-page');

    /** Update basic data **/
    Route::post('update-basic-data',[MasterWorkerController::class,'updateBasic'])->name('update-basic-data');
    /** Pass data to address page with view */
    Route::get('worker-registration-address',[MasterWorkerController::class,'pageAddress'])->name('submit-basic-details');

    /** Save address details */
    Route::post('save-address-details',[MasterWorkerController::class,'saveAddress'])->name('submit-address');
    /** Update address if user exists */
    Route::post('update-address-data',[MasterWorkerController::class,'updateAddress'])->name('update-worker-address');

    /** pass data to bank details **/
    Route::get('worker-bank-details',[MasterWorkerController::class,'pageBank'])->name('save-address');

    /** Save bank details */
    Route::post('save-bank-details',[MasterWorkerController::class,'saveBankDetails'])->name('save-bank-details');

    /** update bank details */
    Route::post('update-bank-details',[MasterWorkerController::class,'updateBank'])->name('update-bank-details');

    /** pass data to family details */
    Route::get('worker-family-details',[MasterWorkerController::class,'pageFamily'])->name('submit-bank');

    /** Save family details */
    Route::post('save-family-details',[MasterWorkerController::class,'saveFamily'])->name('save-family-details');
    /** Update family details */
    Route::post('update-family-details',[MasterWorkerController::class,'updateFamily'])->name('update-family-details');

    /** Pass data to employer page */
    Route::get('worker-employer-details',[MasterWorkerController::class,'pageEmployer'])->name('submit-family-details');

    /**save employer data */
    Route::post('save-employer-details',[MasterWorkerController::class,'saveEmployer'])->name('save-employer-data');

    /** Update Employer Data **/
    Route::post('update-employer-data',[MasterWorkerController::class,'updateEmployer'])->name('update-employer-data');

    /** pass data to working certificate */
    Route::get('worker-working-certificate',[MasterWorkerController::class,'pageCertificate'])->name('submit-employer-details');

    /**save data working certificate */
    Route::post('save-worker-certificate',[MasterWorkerController::class,'saveCertificate'])->name('save-certificate-details');

    /** Update working certificate */
    Route::post('update-certificate-details',[MasterWorkerController::class,'updateCertificate'])->name('update-certificate-details');

    /** Pass Data to Schemes page */
    Route::get('worker-schemes-details',[MasterWorkerController::class,'pageSchemes'])->name('submit-certificate-details');

    /** Save scheme data **/
    Route::post('save-scheme-details',[MasterWorkerController::class,'saveScheme'])->name('save-schemes-details');

    /** Update Scheme Data */
    Route::post('update-scheme-details',[MasterWorkerController::class,'updateScheme'])->name('update-scheme-details');

    /** pass data to documents page */
    Route::get('worker-documents-details',[MasterWorkerController::class,'pageDocument'])->name('submit-schemes-details');

  /** save documents **/
    Route::post('/save-worker-documents',[MasterWorkerController::class,'saveDocument'])->name('save-worker-documents');

    /** Pass data to Preview **/
    Route::get('worker-data-preview',[MasterWorkerController::class,'previewPage'])->name('submit-document-details');

    /** Save Final Worker Data **/
    Route::get('save-worker-data',[MasterWorkerController::class,'finalSubmit'])->name('save-final-data');

    /** Acknowledge Page */
    Route::get('submit-success',[MasterWorkerController::class,'ackPage'])->name('print-ack');

    /** update docs from preview */
    Route::get('update-documents-page',[MasterWorkerController::class,'editDocument'])->name('update-documents');

    /**update documents**/
    Route::post('update-worker-documents',[MasterWorkerController::class,'updateDocument'])->name('update-worker-documents');

    /**get the preview page from edit docs**/
    Route::get('preview-page',[MasterWorkerController::class,'previewFromDoc'])->name('preview-page');

    /** get to schemes page for edit **/
    Route::get('update-schemes-page',[MasterWorkerController::class,'editSchemes'])->name('update-schemes');

    /** View Documents start */
    Route::get('get-worker-id-proof/{id}',[MasterWorkerController::class,'getIdProof'])->name('get-id-proof');
    Route::get('get-worker-res-proof/{id}',[MasterWorkerController::class,'getResProof'])->name('get-res-proof');
    Route::get('get-worker-age-proof/{id}',[MasterWorkerController::class,'getAgeProof'])->name('get-age-proof');
    Route::get('get-worker-bank-copy/{id}',[MasterWorkerController::class,'getBankXerox'])->name('get-bank-copy');
    Route::get('get-worker-certificate-proof/{id}',[MasterWorkerController::class,'getCertProof'])->name('get-cert-proof');
    Route::get('get-worker-passport/{id}',[MasterWorkerController::class,'getPassport'])->name('get-passport');
    Route::get('get-worker-thumb/{id}',[MasterWorkerController::class,'getThumb'])->name('get-thumb');
    Route::get('get-worker-address-proof/{id}',[MasterWorkerController::class,'getAddress'])->name('get-address-proof');
    Route::get('get-worker-bank-pass/{id}',[MasterWorkerController::class,'getBankCopy'])->name('get-bank-pass');
    Route::get('get-worker-decl/{id}',[MasterWorkerController::class,'decl'])->name('get-decl');
    /** View Documents End **/

    /** Get office list from district */
    Route::get('get-office',[MasterWorkerController::class,'getOffice']);
/** Get district and subdistrict */
    Route::get('get-districts', [MasterWorkerController::class,'getDistricts']);
    Route::get('get-subdistricts-postoffc',[MasterWorkerController::class,'getSubdistPostOffc']);
    Route::get('get-subdistricts',[MasterWorkerController::class,'getSubDist']);
    Route::get('get-pincode',[MasterWorkerController::class,'getPin']);

 /** Get bank */
    Route::get('get-bank-details',[MasterWorkerController::class,'getBank']);
    Route::get('/worker-profiles',[WorkerLoginController::class,'getProfile'])->name('worker-profile');
});
