@include('worker.workerFormHeader')

<div class="container-fluid mb-4">
    <div class="row">
    {{--    <div class="col-md-2"></div>--}}
    <!-- Left side columns -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title alert-info" style="padding-top: 30px;"><i class="fa fa-university" aria-hidden="true"></i>&nbsp
                        UPDATE BANK DETAILS</h3>
                    <h5> <span style="color:red;">*</span>Update Necessary Details</h5>
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
                            <input type="text" class="search-input form-control uc-text-smooth" name="ifsc" id="ifsc" value="{{$ifsc->ifsc}}" placeholder="Enter Your IFSC Code" />
                            <input type="button" value="Search" id="populateBank" class=" btn btn-primary proceed mt-1"/>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputIfsc" class="bold"></label>
                        </div>
                    </div><!--end-->
                    <form action="{{route('update-bank-details')}}" class="form-group" method="post">
                        @csrf
                        <input type="hidden" name="ifsc_pk" class="bank" id="ifsc_pk" value="{{$ifsc->id}}">
                        <div class="form-row"><!--start 1-->
                            <div class="form-group col-md-4">
                                <label for="inputBank" class="bold">Bank Name</label>
                                <input type="text" class="form-control uc-text-smooth" value="{{$formdata->bank_name}}" id="bank_name" name="bank_name" placeholder="" readonly>
                                @if ($errors->has('bank_name'))
                                    <span class="text-danger font-weight-normal">{{ $errors->first('bank_name') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputBranch" class="bold">Branch Name</label>
                                <input type="text" class="form-control uc-text-smooth" id="branch_name" value="{{$formdata->branch_name}}" name="branch_name" readonly>
                                @if ($errors->has('branch_name'))
                                    <span class="text-danger font-weight-normal">{{ $errors->first('branch_name') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputBankAddress" class="bold">Bank Address</label>
                                <input type="text" class="form-control uc-text-smooth" value="{{$formdata->bank_address}}" name="bank_address" readonly>
                                @if ($errors->has('bank_address'))
                                    <span class="text-danger font-weight-normal">{{ $errors->first('bank_address') }}</span>
                                @endif
                            </div>
                        </div><!--end-->
                        <div class="form-row"><!--start 1-->
                            <div class="form-group col-md-4">
                                <label for="inputAcc" class="bold">Account Number</label><span style="color:red;">*</span>
                                <input type="text" class="form-control " id="account_no" name="account_no" value="{{$formdata->account_no}}" placeholder="" maxlength="14">
                                <span id="account_noError" class="error-message text-danger"></span>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputAge" class="bold">Confirm Account Number</label>
                                <input type="text" class="form-control " id="cnf_account_no" placeholder="" value="{{$formdata->account_no}}" name="account_no_confirmation" >
                                <span id="accError" style="color: red;"></span>
                                @if ($errors->has('account_no_confirmation'))
                                    <span class="text-danger font-weight-normal">{{ $errors->first('account_no_confirmation') }}</span>
                                @endif
                            </div>
                        </div><!--end-->
                        <button type="submit" class="btn btn-outline-info mt-3 float-right margin-left">
                            Proceed to Next<span class="material-symbols-outlined">skip_next</span>
                        </button>
                        <a href="{{route('submit-basic-details')}}" class="btn btn-outline-info mt-3 float-right margin-left mr-2"><span class="material-symbols-outlined">skip_previous
</span>
                            Go To Previous
                        </a>
                    </form>

                </div>
            </div>
        </div>
    </div><!-- End Left side columns -->
</div>

<script src="{{URL::asset('assets/template/datepicker/jquery-3.7.date.js')}}"></script>
<script src="{{URL::asset('assets/template/datepicker/jquery-ui.min.js')}}"></script>
<link href="{{URL::asset('assets/template/datepicker/jquery-ui.min.css')}}" rel="stylesheet" type="text/css">
{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>--}}
<script>
    $('#account_no, #cnf_account_no').on('keyup', function () {
        if ($('#account_no').val() == $('#cnf_account_no').val()) {
            $('#accError').html('Account number Matched').css('color', 'green');
        } else
            $('#accError').html('Account number doesnot matched').css('color', 'red');
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
<script>
    /**Real Time Validation account No : Himangka Deka **/
    const account_noInput = document.getElementById('account_no');
    const account_noError = document.getElementById('account_noError');
    // const clearButton = document.getElementById('clearButton');

    // Function to validate the input
    function validateInput() {
        const account_no = account_noInput.value;
        // Check if the input exceeds the maximum length
        if (account_no.length > parseInt(account_noInput.getAttribute('maxlength'), 14)) {
            // Truncate the input value to the maximum length
            account_noInput.value = account_no.substring(0, parseInt(account_noInput.getAttribute('maxlength'), 14));
        }

        if (account_no.length === 14) {
            // If valid, clear the error message and remove the invalid-input class
            account_noError.textContent = '';
            account_noInput.classList.remove('invalid-input');
        } else {
            // If invalid, display an error message and add the invalid-input class
            account_noError.textContent = 'Account No must be between 8 to 14 digits long';
            account_noInput.classList.add('invalid-input');
        }

        // Toggle the visibility of the clear button based on whether the input has a value
        clearButton.style.display = account_no.length > 0 ? 'block' : 'none';
    }
    // Function to clear the input
    function clearInput() {
        account_noInput.value = '';
        clearButton.style.display = 'none';
        validateInput(); // Re-run validation after clearing the input
    }

    // Attach an input event listener to the input field
    account_noInput.addEventListener('input', validateInput);

    // Attach a blur event listener to the input field
    account_noInput.addEventListener('blur', validateInput);
    document.getElementById('account_no').addEventListener('keydown', function (event) {
        if (!/[0-9]/.test(event.key) && event.key !== 'Backspace' && event.key !== 'Delete') {
            event.preventDefault();
        }
    });

</script>

@include('layout.footer')
