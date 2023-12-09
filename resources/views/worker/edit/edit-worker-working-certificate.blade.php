
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
        <div class="col-md-12" >
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title alert-info text-center text-white font-weight-bolder pt-5"><i class="fa fa-certificate" aria-hidden="true"></i>&nbspUpdate Details Of 90 Days Working Certificate</h3>
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
                            <form method="post" id="dynamic_field"  action="{{route('update-certificate-details')}}">
                                @csrf
                                <table id="user_table ">
                                    <thead>
                                    <tr>
                                        <th >Type of Issuer</th>
                                        <th >Issue Date</th>
                                        <th >Issue Number</th>
                                        <th >Type of Employer</th>
                                        <th >Full Name</th>
                                        <th >Mobile</th>
                                        <th >From Date</th>
                                        <th >To Date </th>
                                        <th >Action</th>
                                    </tr>
                                    @foreach ($twc as $key => $certificate)
                                    <tr>
{{--                                        <input type="hidden" name="worker_id[]" value="{{$formdata->worker_id}}" class="form-control"/>--}}
                                        <td class="dropdown">
                                            <select name="type_of_issuer[]" class="form-control">
                                                <option value="{{$certificate->type_of_issuer}}">{{$certificate->issuer_name}}</option>
                                                @foreach($type_of_issuer as $issuer)
                                                    <option value="{{$issuer->issuer_code}}">{{$issuer->issuer_name}}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('type_of_issuer'))
                                                <span class="text-danger font-weight-normal">{{ $errors->first('type_of_issuer') }}</span>
                                            @endif
                                        </td>
                                        <td><input type="date" name="issue_date[]" value="{{$certificate->issue_date}}" class="form-control" /></td>
                                        <td><input type="text" name="issue_no[]" value="{{$certificate->issue_no}}"  class="form-control"/></td>
                                        <td><select name="type_of_employer[]" class="form-control">
                                                <option value="{{$certificate->type_of_issuer}}">{{$certificate->issuer_name}}</option>
                                                @foreach($type_of_issuer as $issuer)
                                                    <option value="{{$issuer->issuer_code}}">{{$issuer->issuer_name}}</option>
                                                @endforeach
                                            </select></td>
                                        <td><input type="text" name="name[]" value="{{$certificate->name}}" class="form-control" /></td>
                                        <td><input type="text" name="mobile[]" value="{{$certificate->mobile}}"  class="form-control" /></td>
                                        <td><input type="date"  name="from_date[]"  value="{{$certificate->from_date}}" class="form-control" /></td>
                                        <td><input type="date"  name="to_date[]"  value="{{$certificate->to_date}}" class="form-control" /></td>
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
                                <a href="{{route('submit-family-details')}}" class="btn btn-outline-info mt-3 float-right margin-left mr-2">
                            <span class="material-symbols-outlined">skip_previous
</span>Go To Previous
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
    $(document).ready(function(){

        let count = 1;
        function dynamic_field(number)
        {
            html = '<tr>';
            html += `<td class="dropdown">
  <select name="type_of_issuer[]" class="form-control">
    <option value="">--Select Issuer</option>`;

            @foreach($type_of_issuer as $issuer)
                html += `    <option value="{{$issuer->issuer_code}}">{{$issuer->issuer_name}}</option>`;
            @endforeach

                html += `  </select>
</td>
<td><input type="date" name="issue_date[]" class="form-control" /></td>
<td><input type="text" name="issue_no[]" class="form-control" /></td>
<td class="dropdown">
  <select name="type_of_employer[]" class="form-control">
    <option value="">--Select Employer</option>`;

            @foreach($type_of_issuer as $issuer)
                html += `    <option value="{{$issuer->issuer_code}}">{{$issuer->issuer_name}}</option>`;
            @endforeach

                html += `  </select>
</td>
<td><input type="text" name="name[]" id="issue_no" class="form-control" /></td>
<td><input type="text" name="mobile[]" class="form-control" /></td>
<td><input type="date" name="from_date[]" placeholder="" value="" class="form-control"></td>
<td><input type="date" name="to_date[]" class="form-control" /></td>
<td><button type="button" name="remove" id="" class="btn btn-sm btn-danger remove"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
</tr>`;
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
</script>
{{--<script>--}}
{{--    // Function to calculate age from the date of birth--}}
{{--    function calculateAge() {--}}
{{--        const dobInput = document.getElementById("dob").value;--}}
{{--        const dob = new Date(dobInput);--}}
{{--        const now = new Date();--}}
{{--        const ageInMilliseconds = now - dob;--}}
{{--        const ageDate = new Date(ageInMilliseconds);--}}
{{--        const age = Math.abs(ageDate.getUTCFullYear() - 1970);--}}

{{--// Display the calculated age in the age input field--}}
{{--        document.getElementById("age").value = age;--}}
{{--    }--}}

{{--    // Attach the calculateAge function to the date input's change event--}}
{{--    document.getElementById("dob").addEventListener("change", calculateAge);--}}
{{--</script>--}}
<style>
    #checkbox {
        pointer-events: none;
    }
</style>
@include('layout.footer')
