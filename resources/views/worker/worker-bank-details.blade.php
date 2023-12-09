@include('worker.workerFormHeader')

<div class="container-fluid mb-4">
    <div class="row">
    {{--    <div class="col-md-2"></div>--}}
    <!-- Left side columns -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title alert-info" style="text-align: center; color: white;font-weight: bolder; padding-top: 30px;">BANK DETAILS</h3>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                        <div class="form-row mt-4"><!--start 1-->
                            <div class="form-group col-md-2">
                                <label for="inputIfsc" class="bold">Bank IFSC</label><span style="color:red;">*</span>
                                <input type="text" class="search-input form-control uc-text-smooth" name="ifsc" id="ifsc"  placeholder="Enter Your IFSC Code" />
                                <input type="button" value="Search" id="populateBank" class=" btn btn-primary proceed mt-1"/>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="inputIfsc" class="bold"></label>
                            </div>
                        </div><!--end-->
                    <form action="{{route('save-bank-details')}}" class="form-group" method="post">
                        @csrf
{{--                        <input type="hidden" name="worker_id" value="{{$formdata->worker_id}}" >--}}
                        <input type="hidden" name="ifsc_pk" class="bank" id="ifsc_pk" value="">
                        <div class="form-row"><!--start 1-->
                            <div class="form-group col-md-4">
                                <label for="inputBank" class="bold">Bank Name</label><span style="color:red;">*</span>
                                <input type="text" class="form-control uc-text-smooth bank" id="bank_name" value="" name="bank_name" placeholder="" readonly>
                                @if ($errors->has('bank_name'))
                                    <span class="text-danger font-weight-normal">{{ $errors->first('bank_name') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputBranch" class="bold">Branch Name</label><span style="color:red;">*</span>
                                <input type="text" class="form-control uc-text-smooth bank" id="branch_name" value="" name="branch_name" readonly>
                                @if ($errors->has('branch_name'))
                                    <span class="text-danger font-weight-normal">{{ $errors->first('branch_name') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputBankAddress" class="bold">Bank Address</label><span style="color:red;">*</span>
                                <input type="text" class="form-control uc-text-smooth bank" id="bank_address" name="bank_address" value="" readonly>
                                @if ($errors->has('bank_address'))
                                    <span class="text-danger font-weight-normal">{{ $errors->first('bank_address') }}</span>
                                @endif
                            </div>
                        </div><!--end-->
                        <div class="form-row"><!--start 1-->

                            <div class="form-group col-md-4">
                                <label for="inputAcc" class="bold">Account Number</label><span style="color:red;">*</span>
                                <input type="text" class="form-control" id="account_no" name="account_no" maxlength="14" placeholder="Please enter valid account number">
                                <span id="account_noError" class="error-message text-danger"></span>
                                @if ($errors->has('account_no'))
                                    <span class="text-danger font-weight-normal">{{ $errors->first('account_no') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputAge" class="bold">Confirm Account Number</label><span style="color:red;">*</span>
                                <input type="text" class="form-control" id="account_no_confirmation" maxlength="14" placeholder="Please enter your account number again" name="account_no_confirmation" >
                                <span id="accError" style="color: red;"></span>
                                @if ($errors->has('account_no_confirmation'))
                                    <span class="text-danger font-weight-normal">{{ $errors->first('account_no_confirmation') }}</span>
                                @endif
                            </div>
                        </div><!--end-->
                        <button type="submit" class="btn btn-outline-info" style="float: right;"><span class="material-symbols-outlined">check_circle</span>
                            Proceed to Next
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div><!-- End Left side columns -->
</div>

<script src="{{URL::asset('assets/template/datepicker/jquery-3.7.date.js')}}"></script>
{{--<script src="{{URL::asset('assets/template/datepicker/jquery-ui.min.js')}}"></script>--}}
{{--<link href="{{URL::asset('assets/template/datepicker/jquery-ui.min.css')}}" rel="stylesheet" type="text/css">--}}
{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>--}}
<script>
    $('#account_no, #account_no_confirmation').on('keyup', function () {
        if ($('#account_no').val() == $('#account_no_confirmation').val()) {
            $('#accError').html('Account number Matched').css('color', 'green');
        } else
            $('#accError').html('Account number doesnot matched').css('color', 'red');
    });
</script>
<script>
    const forceKeyPressUppercase = (e) => {
        let el = e.target;
        let charInput = e.keyCode;
        if((charInput >= 97) && (charInput <= 122)) { // lowercase
            if(!e.ctrlKey && !e.metaKey && !e.altKey) { // no modifier key
                let newChar = charInput - 32;
                let start = el.selectionStart;
                let end = el.selectionEnd;
                el.value = el.value.substring(0, start) + String.fromCharCode(newChar) + el.value.substring(end);
                el.setSelectionRange(start+1, start+1);
                e.preventDefault();
            }
        }
    };
    document.querySelectorAll(".uc-text-smooth").forEach(function(current) {
        current.addEventListener("keypress", forceKeyPressUppercase);
    });

</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#populateBank').click(function () {
        $.ajax({
            url: 'get-bank-details',
            type: 'GET',
            data: {
                ifsc:$('#ifsc').val(),
                _token: '{{csrf_token()}}'},
            dataType: 'json',
            success: function (response) {
                console.log(response)
                if(response.ifsc === null)
                {
                    $('.bank').val('');
                    alert('Please Check IFSC Code !');
                    return;
                }

                // Populate the input field with the retrieved data
                $('#ifsc_pk').val(response.ifsc.id);
                $('#bank_name').val(response.ifsc.bank_name);
                $('#branch_name').val(response.ifsc.branch_name);
                $('#bank_address').val(response.ifsc.state);

                // Handle the unique value as needed
                var ifsc = response.ifsc;
                // You can use uniqueValue as needed
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });
</script>


@include('layout.footer')
