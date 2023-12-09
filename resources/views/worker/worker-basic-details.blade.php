@include('worker.workerFormHeader')
<div class="container-fluid mb-4">
    <div class="row">
    {{--    <div class="col-md-2"></div>--}}
    <!-- Left side columns -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title alert-info"
                        style="text-align: center; color: white;font-weight: bolder; padding-top: 30px;"><i class="fa fa-user" aria-hidden="true"></i>&nbspBASIC DETAILS</h3>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{route('save-basic-page')}}" class="form-group" method="post">

                        @csrf
                        <input type="hidden" name="worker_id" value="{{$formdata->worker_id}}">
                        @if ($errors->has('worker_id'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <span><strong>{{ $errors->first('worker_id') }}</strong></span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="form-row mt-5"><!--start 1-->
                            <div class="form-group col-md-4">
                                <label for="inputFirstName" class="bold">First Name</label><span style="color:red;">*</span>
                                <input type="text" class="form-control uc-text-smooth" id="firstname"
                                       value="{{old('first_name')}}" name="first_name">
                                @if ($errors->has('first_name'))
                                    <span
                                        class="text-danger font-weight-normal">{{ $errors->first('first_name') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputLastName" class="bold">Last Name</label><span style="color:red;">*</span>
                                <input type="text" class="form-control uc-text-smooth" id="lastname" value="{{old('last_name')}}" name="last_name" placeholder="">
                                @if ($errors->has('last_name'))
                                    <span
                                        class="text-danger font-weight-normal">{{ $errors->first('last_name') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4" class="bold">Fathers/Husband Name</label>
                                <input type="text" class="form-control uc-text-smooth" id="gurdain_name"
                                       value="{{old('gurdain_name')}}" name="gurdain_name" placeholder="">
                                @if ($errors->has('gurdain_name'))
                                    <span
                                        class="text-danger font-weight-normal">{{ $errors->first('gurdain_name') }}</span>
                                @endif
                            </div>
                        </div><!--end-->
                        <div class="form-row"><!--start 1-->
                            <div class="form-group col-md-4">
                                <label for="gender" class="bold">Gender</label><span style="color:red;">*</span>
                                <select id="inputGender" class="form-control" name="gender">
                                    <option value="">--Select Gender--</option>
                                    @foreach ($gender as $data)
{{--                                        <option value="" disabled>Select</option>--}}
                                        <option value="{{ $data->gender_code }}">{{ $data->gender_name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('gender'))
                                    <span class="text-danger font-weight-normal">{{ $errors->first('gender') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputAdhaar" class="bold">Aadhaar No</label>
                                <input type="text" class="form-control" id="aadhar"
                                       placeholder="{{session()->get('adhaar_no')}}" disabled>
                                @if ($errors->has('adhaar_no'))
                                    <span
                                        class="text-danger font-weight-normal">{{ $errors->first('adhaar_no') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label for="mStatus" class="bold">Marital Status</label><span style="color:red;">*</span>
                                <select id="inputState" class="form-control" name="maritial_status">
                                    <option value="">--Select Marital Status--</option>
                                    @foreach ($marital as $data)
                                        <option value="{{ $data->marital_code }}">{{ $data->marital_status }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('maritial_status'))
                                    <span
                                        class="text-danger font-weight-normal">{{ $errors->first('maritial_status') }}</span>
                                @endif
                            </div>
                        </div><!--end-->
                        <div class="form-row"><!--start 1-->
                            <div class="form-group col-md-4" class="bold">
                                <label for="inputDob" class="bold" style="display: flex;
        align-items: center;">Date Of Birth&nbsp<i class="fa fa-calendar" aria-hidden="true"></i></label>
                                <input type="text" data-provide="datepicker" id="dob" class="form-control datepicker"
                                       name="dob" placeholder="MM/DD/YYYY">
                                @if ($errors->has('dob'))
                                    <span class="text-danger font-weight-normal">{{ $errors->first('dob') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputAge" class="bold">Age(Years) </label>
                                <input type="text" class="form-control" id="age" placeholder="" disabled>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputCategory" class="bold">Category </label><span style="color:red;">*</span>
                                <select id="inputCategory" class="form-control" name="category">
                                    <option value="">--Select Category--</option>
                                    @foreach ($category as $data)
                                        <option value="{{ $data->category_code }}">{{ $data->category_name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('category'))
                                    <span class="text-danger font-weight-normal">{{ $errors->first('category') }}</span>
                                @endif
                            </div>
                        </div><!--end-->
                        <div class="form-row"><!--start 1-->
                            <div class="form-group col-md-4">
                                <label for="inputPhone" class="bold">Mobile Phone Number </label>
                                <input type="text" class="form-control" id="phone" placeholder="{{$formdata->phone_no}}"
                                       disabled>

                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPF" class="bold">eShram Number</label>
                                <input type="text" class="form-control uc-text-smooth" id="eshram"
                                       value="{{old('eshram_no')}}" name="eshram_no" placeholder="">
                                @if ($errors->has('eshram_no'))
                                    <span class="text-danger font-weight-normal">{{ $errors->first('eshram_no') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPhone" class="bold">Education Details</label>
                                <select id="inputCategory" class="form-control" name="education">
                                    <option value ="">--Select Education--</option>
                                    @foreach ($education as $data)
                                        <option value="{{ $data->education_code }}">{{ $data->education_name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('education'))
                                    <span class="text-danger font-weight-normal">{{ $errors->first('education') }}</span>
                                @endif
                            </div>
                        </div><!--end-->
                        <div class="form-row"><!--start 1-->

                            <div class="form-group col-md-4">
                                <label for="inputPF" class="bold">Profession</label>
                                <input type="text" class="form-control uc-text-smooth" id="occupation"
                                       value="{{old('occupation')}}" name="occupation" placeholder="">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputEsic" class="bold">Email (If available) </label>
                                <input type="text" class="form-control uc-text-smooth" id="email"
                                       value="{{old('emaile')}}" name="email" placeholder=""
                                >
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputEsic" class="bold">PF/UAN (If available) </label>
                                <input type="text" class="form-control uc-text-smooth" id="pf_no"
                                       value="{{old('pf_no')}}" name="pf_no" placeholder=""
                                >
                            </div>
                        </div><!--end-->
                        <div class="form-row"><!--start 1-->
                            <div class="form-group col-md-4">
                                <label for="inputPhone" class="bold">ESIC Number(If available) </label>
                                <input type="text" class="form-control" id="esic_no" name="esic_no">
                            </div>
                        </div><!--end-->
                        <button type="submit" class="btn btn-outline-info" style="float:right;"><span class="material-symbols-outlined">check_circle</span>
                            Proceed to Next
                        </button>

                    </form>

                </div>
            </div>
        </div>
    </div><!-- End Left side columns -->
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">

                            <strong>{!! $message !!} </strong>

                        </div>

                    @endif
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    {{--                @if ($message = Session::get('success'))--}}
                    {{--                    <a href="{{route('generate-uan',['id'=>encrypt($id)])}}" target="_blank" class="btn btn-success">Print Acknowledgement</a>--}}

                    {{--                @endif--}}
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<script>
    // Initialize the datepicker
    $(document).ready(function () {
        var defaultYear = 1993;
        $("#dob").datepicker({
            defaultDate: new Date(defaultYear, 0, 1),
            dateFormat: "dd-mm-yy",
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+0", // Allow selecting DOB up to 100 years ago from the current year
            onSelect: calculateAge
        });
    });

    //calculate age
    function calculateAge(selectedDate) {
        var dob = $(this).datepicker('getDate');
        var year = dob.getFullYear();
        var curYear = new Date().getFullYear();
        var age = curYear - year;
        $("#age").val(age);
    }
</script>
{{--<script>--}}

{{--    const forceKeyPressUppercase = (e) => {--}}
{{--        let el = e.target;--}}
{{--        let charInput = e.keyCode;--}}
{{--        if ((charInput >= 97) && (charInput <= 122)) { // lowercase--}}
{{--            if (!e.ctrlKey && !e.metaKey && !e.altKey) { // no modifier key--}}
{{--                let newChar = charInput - 32;--}}
{{--                let start = el.selectionStart;--}}
{{--                let end = el.selectionEnd;--}}
{{--                el.value = el.value.substring(0, start) + String.fromCharCode(newChar) + el.value.substring(end);--}}
{{--                el.setSelectionRange(start + 1, start + 1);--}}
{{--                e.preventDefault();--}}
{{--            }--}}
{{--        }--}}
{{--    };--}}

{{--    document.querySelectorAll(".uc-text-smooth").forEach(function (current) {--}}
{{--        current.addEventListener("keypress", forceKeyPressUppercase);--}}
{{--    });--}}

{{--</script>--}}


@include('layout.footer')
