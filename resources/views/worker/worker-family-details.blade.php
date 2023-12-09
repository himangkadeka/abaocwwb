
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
                    <h3 class="card-title alert-info" style="text-align: center; color: white;font-weight: bolder; padding-top: 30px;"><i class="fa fa-users" aria-hidden="true"></i>&nbspWORKER FAMILY DETAILS</h3>
                    @if(session()->has('error'))
                        <div class="alert alert-danger">
                            <i class="bi bi-check-circle me-1"></i>
                            {{session('error')}}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="table-responsive hack1 mt-4" >
                        <div class="hack2" >
                            <span id="result"></span>
                            <form method="post" id="dynamic_field"  action="{{route('save-family-details')}}">
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
                                <tr>
                                   <input type="hidden" name="worker_id[]" value="{{$formdata->worker_id}}" class="form-control"/>

                                    <td><input type="text" name="first_name[]" value="" class="form-control" />
                                        @if ($errors->has('first_name'))
                                            <span class="text-danger font-weight-normal">{{ $errors->first('first_name') }}</span>
                                        @endif</td>
                                    <td><input type="text" name="last_name[]" value="" class="form-control"  />
                                        @if ($errors->has('last_name'))
                                            <span class="text-danger font-weight-normal">{{ $errors->first('last_name') }}</span>
                                        @endif</td>
                                    <td><input type="text" name="gurdain_name[]" value=""  class="form-control"  />
                                        @if ($errors->has('gurdain_name'))
                                            <span class="text-danger font-weight-normal">{{ $errors->first('gurdain_name') }}</span>
                                        @endif</td>
                                    <td><input type="date" name="dob[]" value="" id="birthdate"  class="form-control"/>
                                        @if ($errors->has('dob'))
                                            <span class="text-danger font-weight-normal">{{ $errors->first('dob') }}</span>
                                        @endif</td>
                                    <td><input type="text"  value="" class="form-control" id="age"  readonly/></td>
                                    <td><input type="text" name="relation[]"  class="form-control"/>
                                        @if ($errors->has('relation'))
                                            <span class="text-danger font-weight-normal">{{ $errors->first('relation') }}</span>
                                        @endif</td>
                                    <td><input name="profession[]" class="form-control" type="text" />
                                        @if ($errors->has('profession'))
                                            <span class="text-danger font-weight-normal">{{ $errors->first('profession') }}</span>
                                        @endif</td>
                                    <td><input type="text" name="education[]" value="" class="form-control" />
                                        @if ($errors->has('education'))
                                            <span class="text-danger font-weight-normal">{{ $errors->first('education') }}</span>
                                        @endif</td>
                                    <td><input type="checkbox" id="checkbox_1" name="nominee[]"  data-id="1" value="1" class="form-control checkboxDisable" />
                                        @if ($errors->has('nominee'))
                                            <span class="text-danger font-weight-normal">{{ $errors->first('nominee') }}</span>
                                        @endif</td>
                                    <input type="hidden" id="checkbox_11" name="nominee[]"  data-id="11"  value="0"  placeholder="Nominee" class="form-control ">

                                    <td><input type="checkbox" id="already_registered_2" name="already_registered[]"  data-id="2"   value="1"  class="form-control regDisable" />
                                        @if ($errors->has('already_registered'))
                                            <span class="text-danger font-weight-normal">{{ $errors->first('already_registered') }}</span>
                                        @endif</td>
                                    <input type="hidden" id="already_registered_22" name="already_registered[]"  data-id="22"  value="0"  class="form-control"/>
                                    <td><input type="text"  class="form-control" placeholder="BOCWWC ID " name="bocwwb_id[]"/>
                                        @if ($errors->has('bocwwb_id'))
                                            <span class="text-danger font-weight-normal">{{ $errors->first('bocwwb_id') }}</span>
                                        @endif</td>
                                    <td><button type="button" name="add" id="add" class="btn btn-sm btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                                <button type="submit" class="btn btn-outline-info mt-2" style="float:right;"><span class="material-symbols-outlined">check_circle</span>
                                    Proceed to Next
                                </button>
                            </form>
                    </div>
{{--                    </div>--}}

                </div>
            </div>
        </div>
    </div><!-- End Left side columns -->
</div>
</div>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script src="{{URL::asset('assets/template/vendor/jquery/ajax-jquery-3.7.min.js')}}"></script>
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
            html += '<td><input type="date" name="dob[]" id="birthdate"  class="form-control " /></td>';
            html += '<td><input type="text"  id="age" class="form-control" readonly/></td>';
            html += '<td><input type="text" name="relation[]" class="form-control" /></td>';
            html += '<td><input type="text" name="profession[]" class="form-control" /></td>';
            html += '<td><input type="text" name="education[]" class="form-control" /></td>';
            html += '<input type="hidden" id="checkbox_'+number+number+'" name="nominee[]" value="0" class="form-control" />';
            html += '<td><input type="checkbox" id="checkbox_'+number+'" data-id="'+number+'" name="nominee[]" value="1" class="checkboxDisable form-control" /></td>';
            html += '<input type="hidden" id="already_registered_'+number+number+'" name="already_registered[]" value="0" class="form-control" />';
            html += '<td><input type="checkbox" id="already_registered_'+number+'" data-id="'+number+'" name="already_registered[]" value="1" class="regDisable form-control" /></td>';
            html += '<td><input type="text"  name="bocwwb_id[]" placeholder="BOCWWC ID" class=" form-control" /></td>';
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
    document.getElementById('birthdate').addEventListener('input', function() {
        const birthdate = new Date(this.value);
        const today = new Date();
        let age = today.getFullYear() - birthdate.getFullYear();

        if (today.getMonth() < birthdate.getMonth() || (today.getMonth() === birthdate.getMonth() && today.getDate() < birthdate.getDate())) {
            age -= 1;
        }

        document.getElementById('age').textContent = age + ' years';

    });
</script>
<style>
    #checkbox {
        pointer-events: none;
    }
</style>
@include('layout.footer')
