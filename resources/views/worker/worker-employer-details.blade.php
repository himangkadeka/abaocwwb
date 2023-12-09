@include('worker.workerFormHeader')
<div class="container-fluid mb-4">

    <div class="row">
    {{--    <div class="col-md-2"></div>--}}
    <!-- Left side columns -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title alert-info" style="text-align: center; color: white;font-weight: bolder; padding-top: 30px;"><i class="fa fa-briefcase" aria-hidden="true"></i>&nbspEMPLOYER DETAILS</h3>
                    <form action="{{route('save-employer-data')}}" class="form-group" method="post">
                        @csrf
                        <input type="hidden" name="worker_id" value="{{$formdata->worker_id}}">
                        <div class="form-row mt-4"><!--start 1-->
                            <div class="form-group col-md-6">
                                <label for="inputEmpName" class="bold">Employer Name</label><span style="color:red;">*</span>
                                <input type="text" class="form-control uc-text-smooth" id="emp_name"
                                       value="{{old('employer_name')}}" name="employer_name">
                                @if ($errors->has('employer_name'))
                                    <span
                                        class="text-danger font-weight-normal">{{ $errors->first('employer_name') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputContractor"class="bold">Contractor
                                    Company/Individual
                                    Employer/ Municipal
                                    Board Name
                                </label><span style="color:red;">*</span>
                                <input type="text" class="form-control uc-text-smooth" id="board" value="{{old('board')}}" name="board" placeholder="">
                                @if ($errors->has('board'))
                                    <span
                                        class="text-danger font-weight-normal">{{ $errors->first('board') }}</span>
                                @endif
                            </div>
{{--                            <div class="form-group col-md-3">--}}
{{--                                <label for="inputWork" class="bold">Type of Work</label>--}}
{{--                                <select id="inputWork" class="form-control" name="type_of_work">--}}
{{--                                    <option value="">--Select Type of work--</option>--}}
{{--                                   @foreach($worktype as $work)--}}
{{--                                        <option value="{{$work->work_type_code}}">{{$work->work_type_name}}</option>--}}
{{--                                       @endforeach--}}
{{--                                </select>--}}
{{--                                @if ($errors->has('type_of_work'))--}}
{{--                                    <span--}}
{{--                                        class="text-danger font-weight-normal">{{ $errors->first('type_of_work') }}</span>--}}
{{--                                @endif--}}
{{--                            </div>--}}
                        </div><!--end-->
                        <div class="form-row"><!--start 1-->
                            <div class="form-group col-md-4">
                                <label for="inputWork" class="bold">Type of Work</label>
                                <select id="inputWork" class="form-control" name="type_of_work">
                                    <option value="">--Select Type of work--</option>
                                    @foreach($worktype as $work)
                                        <option value="{{$work->work_type_code}}">{{$work->work_type_name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('type_of_work'))
                                    <span
                                        class="text-danger font-weight-normal">{{ $errors->first('type_of_work') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label for="workplace" class="bold">Workplace</label><span style="color:red;">*</span>
                                <input type="text" id="" name="workplace" class="form-control">
                                @if ($errors->has('workplace'))
                                    <span class="text-danger font-weight-normal">{{ $errors->first('workplace') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputMobile" class="bold">Mobile</label>
                                <input type="text" class="form-control" id="mobile_no" name="mobile">
                                @if ($errors->has('mobile'))
                                    <span
                                        class="text-danger font-weight-normal">{{ $errors->first('mobile') }}</span>
                                @endif
                            </div>
{{--                            <div class="form-group col-md-4">--}}
{{--                                <label for="mStatus" class="bold">District</label><span style="color:red;">*</span>--}}
{{--                                <select id="inputState" class="form-control dist" id="district" data-id ="d" name="district">--}}
{{--                                    <option value="">--Select District--</option>--}}
{{--                                    @foreach($districts as $dist)--}}
{{--                                        <option value="{{$dist->district_code}}">{{$dist->district_name}}</option>--}}
{{--                                        @endforeach--}}

{{--                                </select>--}}
{{--                                @if ($errors->has('district'))--}}
{{--                                    <span--}}
{{--                                        class="text-danger font-weight-normal">{{ $errors->first('district') }}</span>--}}
{{--                                @endif--}}
{{--                            </div>--}}
                        </div><!--end-->
                        <div class="form-row"><!--start 1-->
                            <div class="form-group col-md-4">
                                <label for="mStatus" class="bold">District</label><span style="color:red;">*</span>
                                <select id="inputState" class="form-control dist" id="district" data-id ="d" name="district">
                                    <option value="">--Select District--</option>
                                    @foreach($districts as $dist)
                                        <option value="{{$dist->district_code}}">{{$dist->district_name}}</option>
                                    @endforeach

                                </select>
                                @if ($errors->has('district'))
                                    <span
                                        class="text-danger font-weight-normal">{{ $errors->first('district') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputDob" class="bold">Sub-District of your
                                    workplace</label><span style="color:red;">*</span>
                                <select class="form-control" data-id="d" name="subdistrict" id="subdist">
                                    <option value ="">--Select Sub-district--</option>
                                </select>
                                @if ($errors->has('subdistrict'))
                                    <span class="text-danger font-weight-normal">{{ $errors->first('subdistrict') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputAge" class="bold">Town/city</label>
                                <input type="text" class="form-control" id="city" name="city" placeholder="">
                                @if ($errors->has('city'))
                                    <span class="text-danger font-weight-normal">{{ $errors->first('city') }}</span>
                                @endif
                            </div>
{{--                            <div class="form-group col-md-4">--}}
{{--                                <label for="inputCategory" class="bold">Pin code </label><span style="color:red;">*</span>--}}
{{--                                <input type="text" class="form-control" name="pin_code">--}}
{{--                                @if ($errors->has('pin_code'))--}}
{{--                                    <span class="text-danger font-weight-normal">{{ $errors->first('pin_code')}}</span>--}}
{{--                                @endif--}}
{{--                            </div>--}}
                        </div><!--end-->
                        <div class="form-row"><!--start 1-->
                            <div class="form-group col-md-3">
                                <label for="inputCategory" class="bold">Pin code </label><span style="color:red;">*</span>
                                <input type="text" class="form-control" name="pin_code">
                                @if ($errors->has('pin_code'))
                                    <span class="text-danger font-weight-normal">{{ $errors->first('pin_code')}}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-3 input-container" style="">

                                <label for="inputPhone" class="bold" style="display: flex;
        align-items: center;">Date of Joining work<span class="material-symbols-outlined">
calendar_month
</span></label>
                                <input type="text" class="form-control" data-provide="datepicker" placeholder="MM/DD/YYYY " id="doj" name="doj">
                                @if ($errors->has('doj'))
                                    <span class="text-danger font-weight-normal">{{ $errors->first('doj')}}</span>
                                @endif

                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputPF" class="bold">Nature of work</label>
                                <select id="" class="form-control" name="nature_of_work">
                                <option value="">--Select Nature of work--</option>
                                @foreach($worknature as $now)
                                    <option value="{{$now->nature_of_work_code}}">{{$now->nature_of_work}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('nature_of_work'))
                                    <span class="text-danger font-weight-normal">{{ $errors->first('nature_of_work')}}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputPhone" class="bold">MGNREGA Registration
                                    No.
                                </label>
                                <input type="text" class="form-control uc-text-smooth" id="occupation"
                                       value="{{old('mgnrega_no')}}" name="mgnrega_no" placeholder="">
                                @if ($errors->has('mgnrega_no'))
                                    <span class="text-danger font-weight-normal">{{ $errors->first('mgnrega_no')}}</span>
                                @endif
                            </div>
                        </div><!--end-->

                        <button type="submit" class="btn btn-outline-info float-right" style="float: right;"><span class="material-symbols-outlined">check_circle</span>
                            Proceed to Next
                        </button>

                    </form>

                </div>
            </div>
        </div>
    </div><!-- End Left side columns -->
</div>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<script>
    // Initialize the datepicker
    $(document).ready(function () {
        $("#doj").datepicker({
            dateFormat: "dd-mm-yy",
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+0", // Allow selecting DOB up to 100 years ago from the current year
            onSelect: calculateAge
        });
    });

    //calculate age
    function calculateAge(selectedDate) {
        // Convert the selected date to a JavaScript Date object
        // const dob = new Date(selectedDate);
        var dob = $(this).datepicker('getDate');
        var year = dob.getFullYear();
        var curYear = new Date().getFullYear();
        var age = curYear - year;

        $("#age").val(age);
    }
</script>
<script>

    const forceKeyPressUppercase = (e) => {
        let el = e.target;
        let charInput = e.keyCode;
        if ((charInput >= 97) && (charInput <= 122)) { // lowercase
            if (!e.ctrlKey && !e.metaKey && !e.altKey) { // no modifier key
                let newChar = charInput - 32;
                let start = el.selectionStart;
                let end = el.selectionEnd;
                el.value = el.value.substring(0, start) + String.fromCharCode(newChar) + el.value.substring(end);
                el.setSelectionRange(start + 1, start + 1);
                e.preventDefault();
            }
        }
    };

    document.querySelectorAll(".uc-text-smooth").forEach(function (current) {
        current.addEventListener("keypress", forceKeyPressUppercase);
    });

</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    $(document).ready(function() {

        $('.dist').on('change', function() {
            ajaxStart();
            var cDist = $(this).data('id') ;
            // console.log(cState);return

            var district_code = $(this).val();

            if (district_code) {
                $.ajax({
                    url: 'get-subdistricts',
                    type: 'GET',
                    data: { district_code: district_code,
                        _token: '{{csrf_token()}}'},
                    dataType: 'json',
                    success: function(data) {
                        ajaxStop();
                        if (cDist == 'd')
                        {
                            var dis= '#subdist';
                        }
                        console.log(data)
                        $(dis).html('<option value="">--Select Sub-District--</option>');
                        $.each(data.subdist, function(key, value) {
                            $(dis).append('<option value="' + value.subdistrict_code + '">' + value.subdistrict_name + '</option>');
                        });

                    }
                });
            } else {
                $('#subdist').empty();
                // $('#subdistrict').empty();
            }
        });
    });
</script>

@include('layout.footer')
