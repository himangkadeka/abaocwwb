
@include('worker.workerFormHeader')
<style>
    .table,th{
        font-size:13px;
        text-align: center;
        background-color: #0f3a47;
        color: white;
    }
    input[type='checkbox'] {
        width:20px;
        height:20px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }

    td {
        border: 1px solid black;
    }


    /* try removing the "hack" below to see how the table overflows the .body */
    .hack1 {
        display: table;
        table-layout: fixed;
        width: 100%;
    }

    .hack2 {
        display: table-cell;
        overflow-x: auto;
        width: 100%;
    }

</style>
<div class="container-fluid mb-4" >
    <div class="row">
    {{--    <div class="col-md-2"></div>--}}
    <!-- Left side columns -->
        <div class="col-md-12" style = "overflow-x:auto;">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title alert-info" style="text-align: center; color: white;font-weight: bolder; padding-top: 30px;">UPDATE WORKER FAMILY DETAILS</h3>
{{--                    <div class="jumbotron jumbotron-fluid" style="border: 1px solid black;">--}}
{{--                        <div class="container-fluid">--}}
{{--                            <h4 class="display-8 "><span class="material-symbols-outlined">--}}
{{--keyboard_double_arrow_right--}}
{{--</span>Worker Overview</h4>--}}
{{--                            <div class="form-row">--}}
{{--                                <div class="form-group col-md-2">--}}
{{--                                    <label for="" class="bold">First Name</label>--}}
{{--                                    <input type="text" class="form-control uc-text-smooth" id="firstname"--}}
{{--                                           placeholder="{{$formdata->first_name}}" readonly>--}}
{{--                                </div>--}}
{{--                                <div class="form-group col-md-2">--}}
{{--                                    <label for="" class="bold">Last Name</label>--}}
{{--                                    <input type="text" class="form-control uc-text-smooth" id="firstname"--}}
{{--                                           placeholder="{{$formdata->last_name}}" readonly>--}}
{{--                                </div>--}}
{{--                                <div class="form-group col-md-2">--}}
{{--                                    <label for="" class="bold">DOB</label>--}}
{{--                                    <input type="text" class="form-control uc-text-smooth" id="firstname"--}}
{{--                                           placeholder="{{$formdata->dob}}" readonly>--}}
{{--                                </div>--}}
{{--                                <div class="form-group col-md-2">--}}
{{--                                    <label for="" class="bold">Gurdain Name</label>--}}
{{--                                    <input type="text" class="form-control uc-text-smooth" id="firstname"--}}
{{--                                           placeholder="{{$formdata->gurdain_name}}" readonly>--}}
{{--                                </div>--}}
{{--                                <div class="form-group col-md-2">--}}
{{--                                    <label for="" class="bold">Aadhaar No</label>--}}
{{--                                    <input type="text" class="form-control uc-text-smooth" id="firstname"--}}
{{--                                           value="{{session()->get('adhaar_no')}}" readonly>--}}
{{--                                </div>--}}
{{--                                <div class="form-group col-md-2">--}}
{{--                                    <label for="" class="bold">Education</label>--}}
{{--                                    <input type="text" class="form-control uc-text-smooth" id="firstname"--}}
{{--                                           value="{{$formdata->education}}" readonly>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <div class="table-responsive hack1 mt-4" >
                        <div class="hack2" >
                            <span id="result"></span>
                            <form method="post" id="dynamic_field"  action="{{route('update-family-details')}}">
                                @csrf
                                <table id="user_table">

                                    <thead>
                                    <tr class="table-bordered ">

                                        <th>First Name</th>
                                        <th >Last Name</th>
                                        <th >Guardian Name</th>
                                        <th >DOB</th>
                                        <th >Age</th>
                                        <th >Relation</th>
                                        <th >Profession</th>
                                        <th >Education</th>
                                        <th >Nominee</th>
                                        <th>Already Registered in BOCCW</th>
                                        <th>BOCCW ID</th>
                                        <th >Action</th>
                                    </tr>
                                    @foreach ($formdata as $key => $familyMember)
                                    <tr>
{{--                                        <input type="hidden" name="worker_id[]" value="{{$familyMember->worker_id}}" class="form-control"/>--}}
                                        <td><input type="text" name="first_name[]" value="{{$familyMember->first_name}}" class="form-control" /></td>
                                        <td><input type="text" name="last_name[]" value="{{$familyMember->last_name}}" class="form-control"  /></td>
                                        <td><input type="text" name="gurdain_name[]" value="{{$familyMember->gurdain_name}}"  class="form-control"  /></td>
                                        <td><input type="date" name="dob[]" value="{{$familyMember->dob}}"  class="form-control"/></td>
                                        <td><input type="text"  value="" class="form-control"  readonly/></td>
                                        <td><input type="text" name="relation[]" value="{{$familyMember->relation}}"  class="form-control"/></td>
                                        <td><input name="profession[]" class="form-control" value="{{$familyMember->profession}}" type="text" /></td>
                                        <td><input type="text" name="education[]" value="{{$familyMember->profession}}" class="form-control" /></td>
                                        <td><input type="checkbox" id="checkbox_1" name="nominee[]"  data-id="1" value="1" class="form-control checkboxDisable" @if($familyMember->nominee == 1) checked @endif /></td>
                                        <input type="hidden" id="checkbox_11" name="nominee[]"  data-id="11"  value="0"  placeholder="Nominee" class="form-control ">
                                        <td><input type="checkbox" id="already_registered_2" name="already_registered[]"  data-id="2"   value="{{$familyMember->already_registered}}"  class="form-control regDisable" @if($familyMember->already_registered == 1) checked @endif  /></td>
                                        <input type="hidden" id="already_registered_22" name="already_registered[]"  data-id="22"  value="0"  class="form-control"/>
                                        <td><input type="text"   class="form-control" placeholder="BOCWWC ID " name="bocwwb_id[]" value="{{ $familyMember->bocwwb_id ?? '' }}"/></td>
                                        <td><button type="button" name="add" id="add" class="btn btn-sm btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                                    </tr>
                                    @endforeach
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <button type="submit" class="btn btn-outline-info mt-3 float-right margin-left">
                                    Proceed to Next<span class="material-symbols-outlined">skip_next</span>
                                </button>
                                <a href="{{route('save-address')}}" class="btn btn-outline-info mt-3 float-right margin-left mr-2"><span class="material-symbols-outlined">skip_previous
</span>
                                    Go To Previous
                                </a>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div><!-- End Left side columns -->
</div>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>--}}
<script>
    $('#account_no, #cnf_account_no').on('keyup', function () {
        if ($('#account_no').val() == $('#cnf_account_no').val()) {
            $('#accError').html('Account number Matched').css('color', 'green');
        } else
            $('#accError').html('Account number does not matched').css('color', 'red');
    });
</script>
<script>
    $(document).ready(function(){

        let count = 1;
        function dynamic_field(number)
        {
            html = '<tr>';
            // html += '<td><input type="hidden" name="worker_id[]" value="" class="form-control" /></td>';
            html += '<td><input type="text" name="first_name[]" value="" class="form-control" /></td>';
            html += '<td><input type="text" name="last_name[]" class="form-control" /></td>';
            html += '<td><input type="text" name="gurdain_name[]" class="form-control"/></td>';
            html += '<td><input type="date" name="dob[]" id="dob"  class="form-control " /></td>';
            html += '<td><input type="text"  id="age" class="form-control" readonly/></td>';
            html += '<td><input type="text" name="relation[]" class="form-control" /></td>';
            html += '<td><input type="text" name="profession[]" class="form-control" /></td>';
            html += '<td><input type="text" name="education[]" class="form-control" /></td>';
            html += '<input type="hidden" id="checkbox_'+number+number+'" name="nominee[]" value="0" class="form-control" />';
            html += '<td><input type="checkbox" id="checkbox_'+number+'" data-id="'+number+'" name="nominee[]" value="1" class="checkboxDisable form-control" /></td>';
            html += '<input type="hidden" id="already_registered_'+number+number+'" name="already_registered[]" value="0" class="form-control" />';
            html += '<td><input type="checkbox" id="already_registered_'+number+'" data-id="'+number+'" name="already_registered[]" value="1" class="regDisable form-control" /></td>';
            html += '<td><input type="text"  name="bocwwb_id[]"  class=" form-control" /></td>';
            html += '<td><button type="button" name="remove" id="" class="btn btn-sm btn-danger remove"><i class="fa fa-trash" aria-hidden="true"></i></button></td></tr>';
            $('tbody').append(html);
        }
        $(document).on('click', '#add', function(){
            count++;
            dynamic_field(count);
        });

        $(document).on('click', '.remove', function(){
            // count--;
            $(this).closest("tr").remove();
        });
    });

    $(document).on('click', '.checkboxDisable', function(){
        var id =$(this).data("id");
        console.log(id)
        if($(this).is(':checked')) {
            $('#checkbox_'+id+id).attr("disabled", true);
            console.log('#checkbox_'+id+id)
            console.log('add')

        }else{

            $('#checkbox_'+id+id).removeAttr("disabled")
            console.log('#checkbox_'+id+id)
            console.log('remove')

        }
    });
    $(document).on('click', '.regDisable', function(){
        var id =$(this).data("id");
        console.log(id)
        if($(this).is(':checked')) {
            $('#already_registered_'+id+id).attr("disabled", true);
            console.log('#already_registered_'+id+id)
            console.log('add')

        }else{

            $('#already_registered_'+id+id).removeAttr("disabled")
            console.log('#already_registered_'+id+id)
            console.log('remove')

        }
    });
</script>
<script>
    // Function to calculate age from the date of birth
    function calculateAge() {
        const dobInput = document.getElementById("dob").value;
        const dob = new Date(dobInput);
        const now = new Date();
        const ageInMilliseconds = now - dob;
        const ageDate = new Date(ageInMilliseconds);
        const age = Math.abs(ageDate.getUTCFullYear() - 1970);

        // Display the calculated age in the age input field
        document.getElementById("age").value = age;
    }

    // Attach the calculateAge function to the date input's change event
    document.getElementById("dob").addEventListener("change", calculateAge);
</script>
<style>
    #checkbox {
        pointer-events: none;
    }
</style>
@include('layout.footer')
