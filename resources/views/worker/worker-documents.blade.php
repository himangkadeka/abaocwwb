@include('worker.workerFormHeader')
<style>
    #imagePreview {
        max-width: 70%;
        max-height: 70%;
        width: auto;
        height: auto;
    }
    .image-upload {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    #declarationPreview{
        max-width: 100%;
        max-height:100%;
        width: auto;
        height: auto;
    }

    #imageInput {
        margin-bottom: 10px;
    }
    /*.bg-info{*/
    /*    background-color: #0f3a47;*/
    /*    color: white;*/
    /*}*/

</style>
<div class="container-fluid mb-4">
    <div class="row">
    {{--    <div class="col-md-2"></div>--}}
    <!-- Left side columns -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title alert-info text-center text-white pt-5">
                        <i class="fa fa-folder-open" aria-hidden="true"></i>&nbsp UPLOAD SUPPORTING DOCUMENTS</h3>
                    <h4 class="d-flex">
                        <i class="fa fa-bullhorn" aria-hidden="true"></i>&nbspNote: All fields are mandatory:</h4>
                        <p class="text-danger mb-0"><i class="fa fa-check-circle" aria-hidden="true"></i>&nbspFor PDF File the size should not exceed 500kb</p>
                    <p class="text-danger"><i class="fa fa-check-circle" aria-hidden="true"></i>&nbspFor Image File the size should be between 20kb to 150kb</p>
                        <form class="form-group" enctype="multipart/form-data" action="{{route('save-worker-documents')}}" method="post">
                            @if(session()->has('error'))
                                <div class="alert alert-warning alert-dismissible fade show">
                                    <i class="bi bi-check-circle me-1"></i>
                                    {{session('error')}}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            @csrf
                                <div class="table-responsive mt-4">
                                    <table class="table table-active">
                                        <thead>
                                        <tr  style="background-color: #c0dbdc;">
                                            <th scope="col" class="text-lg-center">Sl.No</th>
                                            <th scope="col">Name Of Documents</th>
                                            <th scope="col">Action</th>
                                            <th scope="col">Preview</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>Photo ID proof&nbsp<span class="text-danger">*(Must Be a Pdf)</span></td>
                                            <td><input type="file" name="id_proof" class="form-control">
                                                @if ($errors->has('id_proof'))
                                                    <span class="text-danger font-weight-normal">{{ $errors->first('id_proof') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">2</th>
                                            <td>Residential Proof&nbsp<span class="text-danger">*(Must Be a Pdf)</span></td>
                                            <td><input type="file" name="residential_proof" class="form-control">
                                                @if ($errors->has('residential_proof'))
                                                    <span class="text-danger font-weight-normal">{{ $errors->first('residential_proof') }}</span>
                                                @endif
                                            </td>

                                        </tr>
                                        <tr>
                                            <th scope="row">3</th>
                                            <td>Proof of Age
                                                <span class="text-danger">&nbsp*(Must be a pdf file)</span>
                                                <select name="age_proof_id" class="form-control text-center">
                                                    <option value="">---Select Age Proof---</option>
                                                    @foreach($age_proof as $age)
                                                        <option value="{{$age->age_proof_code}}">{{$age->age_proof_name}}</option>
                                                    @endforeach
                                                </select> @if ($errors->has('age_proof_id'))
                                                    <span class="text-danger font-weight-normal">{{ $errors->first('age_proof_id') }}</span>
                                                @endif</td>
                                            <td>
                                                <input type="file" name="age_proof" class="form-control">
                                                @if ($errors->has('age_proof'))
                                                    <span class="text-danger font-weight-normal">{{ $errors->first('age_proof') }}</span>
                                                @endif</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">4</th>
                                            <td>Photocopy of Bank<span class="text-danger">&nbsp(Must be an image file)</span></td>
{{--                                            <td>Passbook Xerox</td>--}}
                                            <td><input type="file" name="passbook_xerox_proof" class="form-control">
                                                @if ($errors->has('passbook_xerox_proof'))
                                                    <span class="text-danger font-weight-normal">{{ $errors->first('passbook_xerox_proof') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">5</th>
                                            <td>Certificate of working 90 days <span class="text-danger">&nbsp*(Must be a pdf file)</span>
                                                <select name="certificate_id" class="form-control text-center" >
                                                    <option value="">---Select Certificate---</option>
                                                    @foreach($type_of_issuer as $issuer)
                                                        <option value="{{$issuer->issuer_code}}">{{$issuer->issuer_name}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('certificate_id'))
                                                    <span class="text-danger font-weight-normal">{{ $errors->first('certificate_id') }}</span>
                                                @endif
                                            </td>
                                            <td><input type="file" name="certificate_proof" class="form-control">
                                                @if ($errors->has('certificate_proof'))
                                                    <span class="text-danger font-weight-normal">{{ $errors->first('certificate_proof') }}</span>
                                                @endif</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">6</th>
                                            <td>Applicant Photo&nbsp<span class="text-danger">&nbsp(Must be an image file)</span></td>
                                            <td><input type="file" name="passport_image" id="imageInput"  accept="image/*" onchange="previewImage()" class="form-control">
                                                @if ($errors->has('passport_image'))
                                                    <span class="text-danger font-weight-normal">{{ $errors->first('passport_image') }}</span>
                                                @endif</td>
                                            <td colspan="2"><img id="imagePreview" src="" alt="Image Preview" /></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">7</th>
                                            <td>Applicant Thumb Print<span class="text-danger">&nbsp(Must be an image file)</span></td>
                                            <td class="image-upload"> <input type="file" name="thumb_image" id="thumbInput"  accept="image/*" onchange="previewThumb()" class="form-control">
                                                @if ($errors->has('thumb_image'))
                                                    <span class="text-danger font-weight-normal">{{ $errors->first('thumb_image') }}</span>
                                                @endif</td>
                                            <td colspan="2"><img id="thumbPreview" src="" alt="Image Preview" /></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">8</th>
                                            <td>Address Proof:- Aadhaar<span class="text-danger">&nbsp(Must be an pdf file)</span></td>
                                            <td><input type="file" name="address_proof" class="form-control">
                                                @if ($errors->has('address_proof'))
                                                    <span class="text-danger font-weight-normal">{{ $errors->first('address_proof') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">9</th>
                                            <td>Bank Passbook<span class="text-danger">&nbsp(Must be an pdf file)</span></td>
                                            <td><input type="file" name="bank_passbook" class="form-control">
                                                @if ($errors->has('bank_passbook'))
                                                    <span class="text-danger font-weight-normal">{{ $errors->first('bank_passbook') }}</span>
                                                @endif</td>


                                        </tr>
                                        <tr>
                                            <th scope="row">10</th>
                                            <td><span style="color: red;">*</span>&nbspSelf-Declaration<span style="color: red;">&nbsp(Must be an image file)</span></td>
                                            <td><input type="file" name="declaration_file" id="declarationInput"  accept="image/*" onchange="previewDeclaration()" class="form-control">
                                            @if ($errors->has('declaration_file'))
                                                <span class="text-danger font-weight-normal">{{ $errors->first('declaration_file') }}</span>
                                                @endif</td>
                                                <td colspan="2"><img id="declarationPreview" src="" alt="Image Preview" /></td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
{{--                            <table class="table table-bordered border-info mt-3">--}}
{{--                                <thead>--}}
{{--                                <tr>--}}
{{--                                    <th colspan="4" class="text-bold" style="background-color: #0f3a47;color: white;"> <span class="material-symbols-outlined">file_copy</span>Upload all supporting documents </th>--}}
{{--                                </tr>--}}
{{--                                </thead>--}}
{{--                                <tbody>--}}

{{--                                <tr>--}}
{{--                                    <th scope="row">1</th>--}}
{{--                                    <th scope="row"> <span style="color: red;">*</span>&nbspPhoto ID proof(Aadhaar)<span style="color: red;">&nbsp(Must be a pdf file)</span></th>--}}
{{--                                    <td  class="dropdown">--}}
{{--                                        <select name="photo_id" class="form-control">--}}
{{--                                            <option value="">Select</option>--}}
{{--                                            <option value="1">Aadhaar</option>--}}
{{--                                        </select>@if ($errors->has('photo_id'))--}}
{{--                                            <span class="text-danger font-weight-normal">{{ $errors->first('photo_id') }}</span>--}}
{{--                                        @endif</td>--}}
{{--                                    <td><input type="file" name="id_proof" class="form-control">@if ($errors->has('id_proof'))--}}
{{--                                            <span class="text-danger font-weight-normal">{{ $errors->first('id_proof') }}</span>--}}
{{--                                        @endif</td>--}}

{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                    <th scope="row">2</th>--}}
{{--                                    <th scope="row"> <span style="color: red;">*</span>&nbspResidential Proof<span style="color: red;">&nbsp(Must be a pdf file)</span>--}}
{{--                                    </th>--}}
{{--                                    <td  class="dropdown">--}}
{{--                                        <select name="residential_id" class="form-control">--}}
{{--                                            <option value="">--Select--</option>--}}
{{--                                            <option value="1">Aadhaar</option>--}}
{{--                                        </select>--}}
{{--                                        @if ($errors->has('residential_id'))--}}
{{--                                            <span class="text-danger font-weight-normal">{{ $errors->first('residential_id') }}</span>--}}
{{--                                        @endif</td>--}}
{{--                                    <td> <input type="file" name="residential_proof" class="form-control">--}}
{{--                                        @if ($errors->has('residential_proof'))--}}
{{--                                            <span class="text-danger font-weight-normal">{{ $errors->first('residential_proof') }}</span>--}}
{{--                                        @endif</td>--}}

{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                    <th scope="row">3</th>--}}
{{--                                    <th> <span style="color: red;">*</span>&nbspProof of Age(Aadhar--}}
{{--                                        Card / Passport / PAN--}}
{{--                                        Card / Driver's License /Birth Certificate issued by--}}
{{--                                        competent officers /--}}
{{--                                        School Leaving Certificate)<span style="color: red;">&nbsp(Must be a pdf file)</span>--}}

{{--                                    </th>--}}
{{--                                    <td  class="dropdown">--}}
{{--                                        <select name="age_proof_id" class="form-control">--}}
{{--                                            <option value="">--Select--</option>--}}
{{--                                            @foreach($age_proof as $age)--}}
{{--                                                <option value="{{$age->age_proof_code}}">{{$age->age_proof_name}}</option>--}}
{{--                                                @endforeach--}}
{{--                                        </select>--}}
{{--                                        @if ($errors->has('age_proof_id'))--}}
{{--                                            <span class="text-danger font-weight-normal">{{ $errors->first('age_proof_id') }}</span>--}}
{{--                                        @endif</td>--}}
{{--                                    <td> <input type="file" name="age_proof" class="form-control">@if ($errors->has('age_proof'))--}}
{{--                                            <span class="text-danger font-weight-normal">{{ $errors->first('age_proof') }}</span>--}}
{{--                                        @endif</td>--}}

{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                    <th scope="row">4</th>--}}
{{--                                    <th> <span style="color: red;">*</span>&nbspPhotocopy of Bank<span style="color: red;">&nbsp(Must be an image file)</span>--}}
{{--                                    </th>--}}
{{--                                    <td  class="dropdown">--}}
{{--                                        <select name="passbook_xerox_id" class="form-control">--}}
{{--                                            <option value="">--Select--</option>--}}
{{--                                            <option value="1">Xerox Copy</option>--}}
{{--                                        </select>--}}
{{--                                        @if ($errors->has('passbook_xerox_id'))--}}
{{--                                            <span class="text-danger font-weight-normal">{{ $errors->first('passbook_xerox_id') }}</span>--}}
{{--                                        @endif</td>--}}
{{--                                    <td><input type="file" name="passbook_xerox_proof" class="form-control">--}}
{{--                                        @if ($errors->has('passbook_xerox_id'))--}}
{{--                                            <span class="text-danger font-weight-normal">{{ $errors->first('passbook_xerox_id') }}</span>--}}
{{--                                        @endif</td>--}}
{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                    <th scope="row">5</th>--}}
{{--                                    <th> <span style="color: red;">*</span>&nbspCertificate of working 90--}}
{{--                                        days or more in the--}}
{{--                                        previous year (Authorized--}}
{{--                                        by the owner / village--}}
{{--                                        worker / M/s. Certificate--}}
{{--                                        of Authority made) one of--}}
{{--                                        these&nbsp<span style="color: red;">&nbsp(Must be a pdf file)</span>--}}

{{--                                    </th>--}}
{{--                                    <td><select name="certificate_id" class="form-control" >--}}
{{--                                            <option value="">--Select--</option>--}}
{{--                                            @foreach($type_of_issuer as $issuer)--}}
{{--                                                <option value="{{$issuer->issuer_code}}">{{$issuer->issuer_name}}</option>--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                        @if ($errors->has('certificate_id'))--}}
{{--                                            <span class="text-danger font-weight-normal">{{ $errors->first('certificate_id') }}</span>--}}
{{--                                        @endif</td>--}}
{{--                                    <td><input type="file" name="certificate_proof" class="form-control">--}}
{{--                                        @if ($errors->has('certificate_proof'))--}}
{{--                                            <span class="text-danger font-weight-normal">{{ $errors->first('certificate_proof') }}</span>--}}
{{--                                        @endif--}}
{{--                                    </td>--}}

{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                    <th scope="row">6</th>--}}
{{--                                    <th> <span style="color: red;">*</span>&nbspApplicant Photo&nbsp<span style="color: red;">&nbsp(Must be an image file)</span>--}}
{{--                                    </th>--}}
{{--                                    <td class="image-upload"><input type="file" name="passport_image" id="imageInput"  accept="image/*" onchange="previewImage()" class="form-control">--}}
{{--                                        @if ($errors->has('passport_image'))--}}
{{--                                            <span class="text-danger font-weight-normal">{{ $errors->first('passport_image') }}</span>--}}
{{--                                        @endif</td>--}}
{{--                                    <td colspan="2"><img id="imagePreview" src="" alt="Image Preview" /></td>--}}
{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                    <th scope="row">7</th>--}}
{{--                                    <th> <span style="color: red;">*</span>&nbspApplicant Thumb Print &nbsp<span style="color: red;">&nbsp(Must be an image file)</span>--}}
{{--                                    </th>--}}
{{--                                    <td class="image-upload"> <input type="file" name="thumb_image" id="thumbInput"  accept="image/*" onchange="previewThumb()" class="form-control">--}}
{{--                                        @if ($errors->has('thumb_image'))--}}
{{--                                            <span class="text-danger font-weight-normal">{{ $errors->first('thumb_image') }}</span>--}}
{{--                                        @endif</td>--}}
{{--                                    <td colspan="2"><img id="thumbPreview" src="" alt="Image Preview" /></td>--}}
{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                    <th scope="row">8</th>--}}
{{--                                    <th> <span style="color: red;">*</span>&nbspAddress Proof *:- Aadhar&nbsp<span style="color: red;">&nbsp(Must be an pdf file)</span>--}}
{{--                                    </th>--}}
{{--                                    <td colspan="2"><input type="file" name="address_proof" class="form-control">--}}
{{--                                        @if ($errors->has('address_proof'))--}}
{{--                                            <span class="text-danger font-weight-normal">{{ $errors->first('address_proof') }}</span>--}}
{{--                                        @endif</td>--}}

{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                    <th scope="row">9</th>--}}
{{--                                    <th> <span style="color: red;">*</span>&nbspBank Passbook<span style="color: red;">&nbsp(Must be a pdf file)</span>--}}
{{--                                    </th>--}}
{{--                                    <td colspan="2"><input type="file" name="bank_passbook" class="form-control">--}}
{{--                                        @if ($errors->has('bank_passbook'))--}}
{{--                                            <span class="text-danger font-weight-normal">{{ $errors->first('bank_passbook') }}</span>--}}
{{--                                        @endif</td>--}}

{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                    <th scope="row">10</th>--}}
{{--                                    <th> <span style="color: red;">*</span>&nbspSelf-Declaration<span style="color: red;">&nbsp(Must be an image file)</span>--}}
{{--                                    </th>--}}
{{--                                    <td class="image-upload"> <input type="file" name="declaration_file" id="declarationInput"  accept="image/*" onchange="previewDeclaration()" class="form-control">--}}
{{--                                        @if ($errors->has('declaration_file'))--}}
{{--                                            <span class="text-danger font-weight-normal">{{ $errors->first('declaration_file') }}</span>--}}
{{--                                        @endif</td>--}}
{{--                                    <td colspan="2"><img id="declarationPreview" src="" alt="Image Preview" /></td>--}}
{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                <tr>--}}

{{--                                </tr>--}}

{{--                                </tbody>--}}
{{--                            </table>--}}
                            <div class="form-row mt-4" style="">
                                <div class="form-group col-md-1">
                                </div>
                                <div class="form-group col-md-1" style="display: flex;justify-content: right;padding-right: 15px;">
                                    <input class="form-check-input mt-5" type="checkbox" value="" id="defaultCheck1" required>
                                </div>

                                <div class="form-group col-md-9" style=" display: flex;justify-content: center;">

                                    <span style="color: red;">*</span>&nbsp<p class=" lead">I hereby declare
                                        that the information /
                                        documents provided in
                                        above form is true &
                                        correct to the best of my
                                        knowledge and belief and
                                        nothing has been falsely
                                        stated. In case any of the
                                        above information is
                                        found to be false or untrue
                                        or misleading or
                                        misrepresenting, I am
                                        aware that I may be held
                                        liable for it.
                                    </p>
                                </div>
                                <div class="form-group col-md-1">
                                </div>
                            </div>
                            <div class="form-row mt-4">
                                <div class="form-group col-md-4">
                                </div>
                                <div class="form-group col-md-4" style=" display: flex;justify-content: center;">
                                    <button type="submit" class="btn btn-outline-info"><span class="material-symbols-outlined">check_circle</span>
                                        Proceed to Preview
                                    </button>
                                </div>
                                <div class="form-group col-md-4">

                                </div>

                            </div>
                        </form>
                        <div id="file-list"></div>

                </div>
            </div>
        </div>
    </div><!-- End Left side columns -->

</div>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
    function previewImage() {
        const imageInput = document.getElementById('imageInput');
        const imagePreview = document.getElementById('imagePreview');

        if (imageInput.files && imageInput.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                imagePreview.src = e.target.result;
            };

            reader.readAsDataURL(imageInput.files[0]);
        } else {
            imagePreview.src = '';
        }
    }
</script>
<script>
    function previewThumb() {
        const thumbInput = document.getElementById('thumbInput');
        const thumbPreview = document.getElementById('thumbPreview');

        if (thumbInput.files && thumbInput.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                thumbPreview.src = e.target.result;
            };

            reader.readAsDataURL(thumbInput.files[0]);
        } else {
            thumbPreview.src = '';
        }
    }
</script>
<script>
    function previewDeclaration() {
        const declarationInput = document.getElementById('declarationInput');
        const declarationPreview = document.getElementById('declarationPreview');

        if (declarationInput.files && declarationInput.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                declarationPreview.src = e.target.result;
            };

            reader.readAsDataURL(declarationInput.files[0]);
        } else {
            declarationPreview.src = '';
        }
    }
</script>
@include('layout.footer')
