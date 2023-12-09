
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
        <h3 class="card-title alert-info" style="text-align: center; color: white;font-weight: bolder; padding-top: 30px;">Details of the 90 Days Working Certificate</h3>
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
                <form method="post" id="dynamic_field"  action="{{route('save-certificate-details')}}">
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
                        <tr>
                            <input type="hidden" name="worker_id[]" value="{{$formdata->worker_id}}" class="form-control"/>
                            <td class="dropdown">
                                <select name="type_of_issuer[]" class="form-control">
                                    <option value="">--Select Issuer--</option>
                                    @foreach($type_of_issuer as $issuer)
                                    <option value="{{$issuer->issuer_code}}">{{$issuer->issuer_name}}</option>
                                   @endforeach
                                </select>
                                @if ($errors->has('type_of_issuer'))
                                    <span class="text-danger font-weight-normal">{{ $errors->first('type_of_issuer') }}</span>
                                @endif
                            </td>
                            <td><input type="date" name="issue_date[]" value="" class="form-control" /></td>
                            <td><input type="text" name="issue_no[]" value=""  class="form-control"/></td>
                            <td><select name="type_of_employer[]" class="form-control">
                                    <option value="">--Select employer--</option>
                                    @foreach($type_of_issuer as $issuer)
                                        <option value="{{$issuer->issuer_code}}">{{$issuer->issuer_name}}</option>
                                    @endforeach
                                </select></td>
                            <td><input type="text" name="name[]" value="" class="form-control" /></td>
                            <td><input type="text" name="mobile[]"  class="form-control" /></td>
                            <td><input type="date"  name="from_date[]"  value="" class="form-control" /></td>
                            <td><input type="date"  name="to_date[]"  value="" class="form-control" /></td>
                            <td><button type="button" name="add" id="add" class="btn btn-sm btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                    <button type="submit" class="btn btn-outline-info mt-3" style="float:right;"><span class="material-symbols-outlined">check_circle</span>
                        Proceed to Next
                    </button>
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
