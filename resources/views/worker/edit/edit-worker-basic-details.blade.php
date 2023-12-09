@include('worker.workerFormHeader')

<div class="container-fluid mb-4">
    <div class="row">
    {{--    <div class="col-md-2"></div>--}}
    <!-- Left side columns -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title alert-info"
                        style="text-align: center; color: white;padding-top: 30px; font-weight: bolder;"><i class="fa fa-user" aria-hidden="true"></i>&nbspUPDATE BASIC DETAILS</h3>
                    <form action="{{route('update-basic-data')}}" class="form-group" method="post">
                        @csrf
                        <input type="hidden" name="worker_id" value="{{$formdata->worker_id}}">
                       <h5> <span style="color:red;">*</span>Update Necessary Details</h5>
                        <div class="form-row mt-4"><!--start 1-->
                            <div class="form-group col-md-4">
                                <label for="inputFirstName" class="bold">First Name</label><span style="color:red;">*</span>
                                <input type="text" class="form-control uc-text-smooth" id="firstname"
                                       value="{{$formdata->first_name}}" name="first_name">
                                @if ($errors->has('first_name'))
                                    <span
                                        class="text-danger font-weight-normal">{{ $errors->first('first_name') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputLastName" class="bold">Last Name</label><span style="color:red;">*</span>
                                <input type="text" class="form-control uc-text-smooth" id="lastname" value="{{$formdata->last_name}}" name="last_name" placeholder="">
                                @if ($errors->has('last_name'))
                                    <span
                                        class="text-danger font-weight-normal">{{ $errors->first('last_name') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4" class="bold">Fathers/Husband Name</label>
                                <input type="text" class="form-control uc-text-smooth" id="gurdain_name"
                                       value="{{$formdata->gurdain_name}}" name="gurdain_name" placeholder="">
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
                                    <option value="{{$formdata->gender}}">{{$formdata->gender_name}} </option>
                                    @foreach ($gender as $key => $gen)
                                        <option value="{{$gen->gender_code}}">{{$gen->gender_name}}</option>
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
                                    <option value="{{$formdata->maritial_status}}">{{$formdata->marital_status}} </option>
                                    @foreach ($marital as $key => $mar)
                                        <option value="{{$mar->marital_code}}">{{$mar->marital_status}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('maritial_status'))
                                    <span
                                        class="text-danger font-weight-normal">{{ $errors->first('maritial_status') }}</span>
                                @endif
                            </div>
                        </div><!--end-->
                        <div class="form-row"><!--start 1-->
                            <div class="form-group col-md-4">
                                <label for="inputDob" class="bold">Date Of Birth </label>&nbsp<i class="fa fa-calendar" aria-hidden="true"></i>
                                <input type="text" data-provide="datepicker" id="dob" class="form-control datepicker"
                                       name="dob" placeholder="MM/DD/YYYY" value="{{$formdata->dob}}">
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
                                    <option value="{{$formdata->category_code}}">{{$formdata->category_name}} </option>
                                    @foreach ($category as $key => $cat)
                                        <option value="{{$cat->category_code}}">{{$cat->category_name}}</option>
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
                                       value="{{$formdata->eshram_no}}" name="eshram_no" placeholder="">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPhone" class="bold">Education Details</label>
                                <select id="inputCategory" class="form-control" name="education">
                                    <option value="{{$formdata->education}}">{{$formdata->education_name}} </option>
                                    @foreach ($education as $key => $edu)
                                        <option value="{{$edu->education_code}}">{{$edu->education_name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('education'))
                                    <span
                                        class="text-danger font-weight-normal">{{ $errors->first('education') }}</span>
                                @endif
                            </div>
                        </div><!--end-->
                        <div class="form-row"><!--start 1-->

{{--                            <div class="form-group col-md-4">--}}
{{--                                <label for="inputPF" class="bold">Profession</label>--}}
{{--                                <input type="text" class="form-control uc-text-smooth" id="occupation"--}}
{{--                                       value="{{$formdata->occupation}}" name="occupation" placeholder="">--}}
{{--                            </div>--}}
                            <div class="form-group col-md-4">
                                <label for="inputEsic" class="bold">Email (If available) </label>
                                <input type="text" class="form-control uc-text-smooth" id="email"
                                       value="{{$formdata->email}}" name="email" placeholder=""
                                >
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputEsic" class="bold">PF/UAN (If available) </label>
                                <input type="text" class="form-control uc-text-smooth" id="pf_no"
                                       value="{{$formdata->pf_no}}" name="pf_no" placeholder="">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPhone" class="bold">ESIC Number(If available) </label>
                                <input type="text" class="form-control" value="{{$formdata->esic_no}}" id="esic_no" name="esic_no">
                            </div>
                        </div><!--end-->
                        <div class="form-row"><!--start 1-->

                        </div><!--end-->
                        <button type="submit" class="btn btn-outline-info mt-3 float-right margin-left mr-2">
                            Proceed to Next<span class="material-symbols-outlined">skip_next</span>
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
        $("#dob").datepicker({
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

@include('layout.footer')
