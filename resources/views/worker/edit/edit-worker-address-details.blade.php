
@include('worker.workerFormHeader')
{{--<style>--}}
{{--   .card-title{--}}
{{--       background-image: url("/assets/template/images/frombannercopy.jpg");--}}
{{--       height: 100px;--}}
{{--       background-repeat: no-repeat, no-repeat;--}}
{{--       background-position: center;--}}
{{--       text-align: center;--}}
{{--       color: white;--}}

{{--   }--}}
{{--</style>--}}

<div class="container-fluid mb-4">
{{--    <div class="col-md-2"></div>--}}
<!-- Left side columns -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title alert-info" style="padding-top: 30px;font-weight: bolder;"><i class="fa fa-address-card" aria-hidden="true"></i>&nbspRESIDENTIAL DETAILS EDIT</h3>
                <h5> <span style="color:red;">*</span>Update Necessary Details</h5>
                <form action="{{route('update-worker-address')}}" method="post">
                    @csrf
                    <input type="hidden" name="worker_id" value="{{$formdata->worker_id}}" >
                    <div class="form-row mt-4"><!--start 1-->
                        <div class="form-group col-md-3">
                            <label for="inputFirstName" class="bold">Type Of Residence </label><span style="color:red;">*</span>
                            <select class="form-control" name="c_residence" id="currentResidence">
                                <option value="{{$formdata->c_residence}}">{{$formdata->residence_name}} </option>
                                @foreach ($residence as $key => $res)
                                    <option value="{{$res->residence_code}}">{{$res->residence_name}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('c_residence'))
                                <span class="text-danger font-weight-normal">{{ $errors->first('c_residence') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputLastName" class="bold">Type Of House</label><span style="color:red;">*</span>
                            <select class="form-control" name="c_house_type" id="currentHouse">
                                <option value="{{$formdata->c_house_type}}">{{$formdata->house_type}} </option>
                                @foreach ($house as $key => $hs)
                                    <option value="{{$hs->house_code}}">{{$hs->house_type}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('c_house_type'))
                                <span
                                    class="text-danger font-weight-normal">{{ $errors->first('c_house_type') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputPassword4" class="bold">House No./Building No. </label>
                            <input type="text" class="form-control " value="{{$formdata->c_house_no}}" id="currentBuilding" name="c_house_no" placeholder="">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="gender" class="bold">Area/Village </label><span style="color:red;">*</span>
                            <input type="text" class="form-control uc-text-smooth" value="{{$formdata->c_area}}" id="currentArea" name="c_area">
                            @if ($errors->has('c_area'))
                                <span
                                    class="text-danger font-weight-normal">{{ $errors->first('c_area') }}</span>
                            @endif
                        </div>
                    </div><!--end-->
                    <div class="form-row"><!--start 1-->

                        <div class="form-group col-md-3">
                            <label for="inputMstatus" class="bold">City</label><span style="color:red;">*</span>
                            <input type="text" class="form-control uc-text-smooth" value="{{$formdata->c_city}}" name="c_city" id="currentCity" >
                            @if ($errors->has('c_city'))
                                <span
                                    class="text-danger font-weight-normal">{{ $errors->first('c_city') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-3" >
                            <label for="inputAdhaar" class="bold">Road</label>
                            <input type="text" class="form-control uc-text-smooth" value="{{$formdata->c_road}}" id="currentRoad" name="c_road">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputDob" class="bold">State </label><span style="color:red;">*</span>
                            <select class="form-control state" data-id="c"  id="currentState" name="c_state">
                                <option value="{{$formdata->c_state}}">{{$formdata->state_name}} </option>
                                @foreach ($states as $key => $state)
                                    <option value="{{$state->state_code}}">{{$state->state_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputAge" class="bold">District</label>
                            <select  class="form-control dist" id="currentDist" data-id="c" name="c_district">
                                <option value="{{$formdata->c_district}}">{{$formdata->district_name}} </option>
{{--                                @foreach ($districts as $key => $dist)--}}
{{--                                    <option value="{{$dist->district_code}}">{{$dist->district_name}}</option>--}}
{{--                                @endforeach--}}
                            </select>
                            @if ($errors->has('c_district'))
                                <span
                                    class="text-danger font-weight-normal">{{ $errors->first('c_district') }}</span>
                            @endif
                        </div>


                    </div><!--end-->
                    <div class="form-row"><!--start 1-->
                        <div class="form-group col-md-3">
                            <label for="inputAge" class="bold">Revenue Circle </label><span style="color:red;">*</span>
                            <select  class="form-control" data-id="c" id="currentCircle" name="c_circle">
                                <option value="{{$formdata->c_circle}}">{{$formdata->subdistrict_name}}</option>
{{--                                @foreach ($subdistrict as $key => $subdist)--}}
{{--                                    <option value="{{$subdist->subdistrict_code}}">{{$subdist->subdistrict_name}}</option>--}}
{{--                                @endforeach--}}
                            </select>
                            @if ($errors->has('c_circle'))
                                <span
                                    class="text-danger font-weight-normal">{{ $errors->first('c_circle') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputCategory" class="bold">Post Office </label><span style="color:red;">*</span>
                            <select  class="form-control uc-text-smooth post" name="c_post_office" data-id="c" id="currentPost">
                                <option value="{{$formdata->c_post_office}}">{{$formdata->poname}}</option>
{{--                                @foreach ($podetails as $key => $post)--}}
{{--                                    <option value="{{$post->poid}}">{{$post->poname}}</option>--}}
{{--                                @endforeach--}}
                            </select>
                            @if ($errors->has('c_post_office'))
                                <span
                                    class="text-danger font-weight-normal">{{ $errors->first('c_post_office') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputPhone" class="bold">Pin Code</label><span style="color:red;">*</span>
                            <input type="text" class="form-control" id="currentPin" data-id="c" name="c_pin" value="{{$formdata->c_pin}}"  placeholder="" readonly>
                            @if ($errors->has('c_pin'))
                                <span
                                    class="text-danger font-weight-normal">{{ $errors->first('c_pin') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputPF" class="bold">STD Code</label>
                            <input type="text" class="form-control" id="currentStd" value="{{$formdata->c_std}}" name="c_std" placeholder="">
                        </div>
                    </div><!--end-->
                    <div class="form-row"><!--start 1-->
                        <div class="form-group col-md-3">
                            <label for="inputPhone" class="bold">Landmark</label>
                            <input type="text" class="form-control" name="landmark" value="{{$formdata->landmark}}" id="landmark">
                        </div>
                    </div><!--end-->
                    <div class="form-row mb-4 mt-3"><!--start 1-->
                        <div class="col-md-2">

                        </div>
                        <div class="form-check col-md-2" style="display: flex;justify-content: right;padding-right: 15px;">
                            <input type="checkbox" class="form-check-input" onclick="copyPermanentToCurrent()" id="checkBox">
                        </div>
                        <div class="col-md-6">
                            <label class="form-check-label font-weight-bold" >Click here to use the same Residential Address as Permanent Address</label>
                        </div>
                        <div class="col-md-4">

                        </div>
                    </div><!--end-->
                    <div class="form-row"><!--start 1-->
                        <div class="form-group col-md-3">
                            <label for="inputFirstName" class="bold">Type Of Residence </label><span style="color:red;">*</span>
                            <select class="form-control" id="permanentResidence"  name="p_residence">
                                < <option value="{{$formdata->p_residence}}">{{$formdata->residence_name}} </option>
                                @foreach ($residence as $key => $res)
                                    <option value="{{$res->residence_code}}">{{$res->residence_name}}</option>
                                @endforeach

                            </select>

                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputLastName" class="bold">Type Of House</label><span style="color:red;">*</span>
                            <select  class="form-control "  name="p_house_type"  id="permanentHouse">
                                <option value="{{$formdata->p_house_type}}">{{$formdata->house_type}} </option>
                                @foreach ($house as $key => $hs)
                                    <option value="{{$hs->house_code}}">{{$hs->house_type}}</option>
                                @endforeach


                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputPassword4" class="bold">House No./Building No. </label>
                            <input type="text" class="form-control uc-text-smooth" value="{{$formdata->p_house_no}}" id="permanentBuilding" name="p_house_no" placeholder="">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="gender" class="bold">Area/Village </label><span style="color:red;">*</span>
                            <input type="text" class="form-control uc-text-smooth" id="permanentArea" name="p_area" value="{{$formdata->p_area}}">
                        </div>
                    </div><!--end-->
                    <div class="form-row"><!--start 1-->
                        <div class="form-group col-md-3">
                            <label for="inputMstatus" class="bold">City</label><span style="color:red;">*</span>
                            <input type="text"  id="permanentCity" class="form-control form-control-sm" name="p_city" value="{{$formdata->p_city}}">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="inputAdhaar" class="bold">Road</label>
                            <input type="text" class="form-control  uc-text-smooth" id="permanentRoad" name="p_road" value="{{$formdata->p_road}}">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="inputDob" class="bold">State </label><span style="color:red;">*</span>
                            <select class="form-control state" data-id ="p" id="permanentState" name="p_state">
                                <option value="{{$formdata->p_state}}">{{$formdata->state_name}} </option>
                                @foreach ($states as $key => $state)
                                    <option value="{{$state->state_code}}">{{$state->state_name}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('p_state'))
                                <span class="text-danger font-weight-normal">{{ $errors->first('p_state') }}</span>
                            @endif

                        </div>

                        <div class="form-group col-md-3">
                            <label for="inputAge" class="bold">District </label><span style="color:red;">*</span>
                            <select class="form-control dist"  data-id ="p" id="permanentDist" name="p_district">
                                <option value="{{$formdata->p_district}}">{{$formdata->district_name}} </option>
                            </select>
                            @if ($errors->has('p_district'))
                                <span class="text-danger font-weight-normal">{{ $errors->first('p_district') }}</span>
                            @endif
                        </div>
                    </div><!--end-->
                    <div class="form-row"><!--start 1-->
                        <div class="form-group col-md-3">
                            <label for="inputAge" class="bold">Revenue Circle</label><span style="color:red;">*</span>
                            <select  class="form-control " data-id="p" id="permanentCircle" name="p_circle">
                                <option value="{{$formdata->p_circle}}">{{$formdata->subdistrict_name}}</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputCategory" class="bold">Post Office </label><span style="color:red;">*</span>
                            <select  class="form-control uc-text-smooth post" data-id="p" id="permanentPost" name="p_post_office">
                                <option value="{{$formdata->p_post_office}}">{{$formdata->poname}}</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputPhone" class="bold">Pin Code</label><span style="color:red;">*</span>
                            <input type="text" class="form-control" id="permanentPin" data-id ="p"  name="p_pin" value="{{$formdata->p_pin}}">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputPF" class="bold">STD Code</label>
                            <input type="text" class="form-control" id="permanentStd" value="{{$formdata->p_std}}" name="p_std" placeholder="">
                        </div>
                    </div><!--end-->
                    <div class="form-row"><!--start 1-->
{{--                        <div class="form-group col-md-3">--}}
{{--                            <label for="inputPhone" class="bold">Land Line Number</label>--}}
{{--                            <input type="text" class="form-control " id="landline"  name="landline" value="{{$formdata->landline}}" placeholder="">--}}
{{--                        </div>--}}
                        <div class="form-group col-md-3">
                            <label for="inputPF" class="bold">Ration Card Number</label>
                            <input type="text" class="form-control" id="ration_no" name="ration_no" value="{{$formdata->ration_no}}" placeholder="">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputPF" class="bold">Ration Card Type.</label>
                            <input type="text" class="form-control" id="ration" name="ration_type" value="{{$formdata->ration_type}}" placeholder="">
                        </div>

                    </div><!--end-->
                    <button type="submit" class="btn btn-outline-info mt-3 float-right margin-left">Proceed to Next<span class="material-symbols-outlined">skip_next</span>
                    </button>
                    <a href="{{route('main-page')}}" class="btn btn-outline-info mt-3 float-right margin-left mr-2">
                        <span class="material-symbols-outlined">skip_previous</span>
                        Go To Previous
                    </a>
                </form>

            </div>
        </div>
    </div>
</div><!-- End Left side columns -->
<div id="loader" style="display: none;">
    {{--    <img src="spinner.gif" alt="Loading..." />--}}
    <div class="d-flex justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</div>
</div>

{{--<script src="{{URL::asset('assets/template/datepicker/jquery-3.7.date.js')}}"></script>--}}
{{--<script src="{{URL::asset('assets/template/datepicker/jquery-ui.min.js')}}"></script>--}}
{{--<link href="{{URL::asset('assets/template/datepicker/jquery-ui.min.css')}}" rel="stylesheet" type="text/css">--}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>function copyPermanentToCurrent() {
        let checkBox= document.getElementById('checkBox');
        const currentResidence = document.getElementById("currentResidence").value;
        const currentHouse = document.getElementById("currentHouse").value;
        const currentBuilding = document.getElementById("currentBuilding").value;
        const currentArea = document.getElementById("currentArea").value;
        const currentCity = document.getElementById("currentCity").value;
        const currentDist = $("#currentDist :selected").val();
        const currentDistText = $("#currentDist :selected").text();
        const currentRoad = document.getElementById("currentRoad").value;
        const currentState = document.getElementById("currentState").value;
        const currentPost = $("#currentPost :selected").val();
        const currentPostText = $("#currentPost :selected").text();
        const currentPin = document.getElementById("currentPin").value;
        const currentStd = document.getElementById("currentStd").value;
        const currentCircle = $("#currentCircle :selected").val();
        const currentCircleText = $("#currentCircle :selected").text();
        if(checkBox.checked === true)
        {
            // Set values in current address fields
            document.getElementById("permanentStd").value = currentStd;
            $('#permanentStd').attr('readonly',true);
            document.getElementById("permanentPin").value = currentPin;

            $('#permanentPin').attr('readonly',true);
            // document.getElementById("permanentPost").value = currentPost;
            $('#permanentPost').html('<option value="' + currentPost + '">' + currentPostText + '</option>');
            $('#permanentPost').attr('readonly',true);
            document.getElementById("permanentState").value = currentState;
            $('#permanentState').attr('readonly',true);
            document.getElementById("permanentRoad").value = currentRoad;
            $('#permanentRoad').attr('readonly',true);
            // document.getElementById("permanentDist").value = currentDist;
            $('#permanentDist').html('<option value="' + currentDist + '">' + currentDistText + '</option>');
            $('#permanentDist').attr('readonly',true);
            document.getElementById("permanentCity").value = currentCity;
            $('#permanentCity').attr('readonly',true);
            document.getElementById("permanentArea").value = currentArea;
            $('#permanentArea').attr('readonly',true);
            document.getElementById("permanentHouse").value = currentHouse;
            $('#permanentHouse').attr('readonly',true);
            document.getElementById("permanentResidence").value = currentResidence;
            $('#permanentResidence').attr('readonly',true);
            document.getElementById("permanentBuilding").value = currentBuilding;
            $('#permanentBuilding').attr('readonly',true);
            // document.getElementById("permanentCircle").value = currentCircle;
            $('#permanentCircle').html('<option value="' + currentCircle + '">' + currentCircleText + '</option>');
            $('#permanentCircle').attr('readonly',true);

        }
        else{
            document.getElementById("permanentStd").value = "";
            document.getElementById("permanentPin").value ="";
            $('#permanentPost').html('<option value="">--Select Post-office--</option>');
            document.getElementById("permanentState").value = "";
            document.getElementById("permanentRoad").value = "";
            $('#permanentDist').html('<option value="">--Select District--</option>');
            document.getElementById("permanentCity").value = "";
            document.getElementById("permanentArea").value = "";
            document.getElementById("permanentHouse").value = "";
            document.getElementById("permanentResidence").value = "";
            document.getElementById("permanentBuilding").value = "";
            $('#permanentCircle').html('<option value="">--Select Circle-office--</option>');
        }
        // Set values in current address fields
    }</script>

<script>
    function ajaxStart() {
        // Show the loader when an AJAX request starts
        console.log('loadershow')
        $("#loader").show();
    };

    function ajaxStop() {
        // Hide the loader when all AJAX requests are complete
        console.log('loaderhide')
        $("#loader").hide();
    };
    //district
    $(document).ready(function() {

        $('.state').on('change', function() {
            ajaxStart();
            var cState = $(this).data('id') ;
            // console.log(cState);return

            var state_code = $(this).val();

            if (state_code) {
                $.ajax({
                    url: 'get-districts',
                    type: 'GET',
                    data: { state_code: state_code,
                        _token: '{{csrf_token()}}'},
                    dataType: 'json',
                    success: function(data) {
                        ajaxStop();
                        if (cState == 'c')
                        {
                            var dis= '#currentDist';
                        } else if (cState == 'p'){
                            var dis = '#permanentDist';
                        }
                        console.log(data)
                        $(dis).html('<option value="">--Select District--</option>');
                        $.each(data.districts, function(key, value) {
                            $(dis).append('<option value="' + value.district_code + '">' + value.district_name + '</option>');
                        });

                    }
                });
            } else {
                $('#currentDist').empty();
                // $('#subdistrict').empty();
            }
        });
    });
    //subdistrict & postoffc
    $(document).ready(function() {
        $('.dist').on('change', function() {
            ajaxStart();
            var cDist = $(this).data('id');
            var district_code = $(this).val();
            if(cDist == 'c')
            {
                var state_code = $('#currentState').val();
            }
            else if(cDist == 'p'){
                var state_code = $('#permanentState').val();
            }
            if (district_code) {
                $.ajax({
                    url: 'get-subdistricts-postoffc',
                    type: 'GET',
                    data: { state_code : state_code,
                        district_code: district_code,
                        _token: '{{csrf_token()}}'},
                    dataType: 'json',
                    success: function(data) {
                        ajaxStop();
                        if (cDist == 'c')
                        {
                            var pos = '#currentPost';
                            var dis= '#currentCircle';
                        } else if (cDist == 'p'){
                            var dis = '#permanentCircle';
                            var pos = '#permanentPost';
                        }
                        console.log(data)
                        $(dis).html('<option value="">--Select Sub-district--</option>');
                        $.each(data.subdist, function(key, value) {
                            $(dis).append('<option value="' + value.subdistrict_code + '">' + value.subdistrict_name + '</option>');
                        });
                        $(pos).html('<option value="">--Select Post-office--</option>');
                        $.each(data.postoffice, function(key, value) {
                            $(pos).append('<option value="' + value.poid + '">' + value.poname + '</option>');
                        });
                    }
                });
            } else {

                $('#currentCircle').empty();
            }
        });
    });
    //postoffice
    $(document).ready(function() {
        $('.post').on('change', function() {
            ajaxStart();
            var cPost = $(this).data('id');
            var post_code = $(this).val();
            if(cPost == 'c')
            {
                var state_code = $('#currentState').val();
                var district_code = $('#currentDist').val();

            }
            else if(cPost == 'p'){
                var state_code = $('#permanentState').val();
                var district_code = $('#permanentDist').val();

            }
            if (post_code) {
                $.ajax({
                    url: 'get-pincode',
                    type: 'get',
                    data: { state_code : state_code,
                        district_code: district_code,
                        poid: post_code,
                        _token: '{{csrf_token()}}'},
                    dataType: 'json',
                    success: function(data) {
                        ajaxStop();
                        if (cPost == 'c')
                        {
                            var pin= '#currentPin';
                        } else if (cPost == 'p'){
                            var pin = '#permanentPin';
                        }
                        console.log(data)
                        $(pin).val(data.pincode.pincode);

                    }
                });
            } else {

                $('#currentCircle').empty();
            }
        });
    });
</script>

@include('layout.footer')
