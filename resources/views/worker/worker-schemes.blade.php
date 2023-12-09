
@include('worker.workerFormHeader')

<div class="container-fluid mb-4" >
    <div class="row">
    {{--    <div class="col-md-2"></div>--}}
    <!-- Left side columns -->
        <div class="col-md-12" style = "overflow-x:auto;">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title alert-info" style="text-align: center; color: white;font-weight: bolder; padding-top: 30px;">AVAILING OTHER SCHEMES</h3>
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
                    <div class="table-responsive mt-4">
                        <form method="post" id="dynamic_field"  action="{{route('save-schemes-details')}}">
                                @csrf
                            <table class="table table-bordered">
                                <thead>
                                    <tr style="background-color: #c0dbdc;">
                                        <th >Mention the external Schemes availed:</th>
                                        <th >Registration No</th>
                                        <th >Scheme Registration Date</th>
                                        <th >Action</th>
                                    </tr>
                                    <tr>
                                        <td class="dropdown">
                                            <select name="scheme_name[]" class="form-control">
                                                <option value="">--Select Schemes--</option>
                                                @foreach($schemes as $scheme)
                                                    <option value="{{$scheme->scheme_code}}">{{$scheme->scheme_name}}</option>
                                                @endforeach
                                            </select></td>
                                        <td><input type="text" name="registration_id[]" value="" class="form-control"  />
                                            @if ($errors->has('last_name'))
                                                <span class="text-danger font-weight-normal">{{ $errors->first('last_name') }}</span>
                                            @endif</td>
                                        <td><input type="date" name="date[]" value=""  class="form-control"  />
                                            @if ($errors->has('gurdain_name'))
                                                <span class="text-danger font-weight-normal">{{ $errors->first('gurdain_name') }}</span>
                                            @endif</td>
                                        <td><button type="button" name="add" id="add" class="btn btn-sm btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                            </table><button type="submit" class="btn btn-outline-info mt-2" style="float:right;"><span class="material-symbols-outlined">check_circle</span>
                                    Proceed to Next</button>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Left side columns -->
</div>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script src="{{URL::asset('assets/template/vendor/jquery/ajax-jquery-3.7.min.js')}}"></script>
{{--<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>--}}
{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>--}}
<script>
    $(document).ready(function(){

        let count = 1;
        function dynamic_field(number)
        {
            html = '<tr>';
            html += `<td class="dropdown">
  <select name="scheme_name[]" class="form-control">
    <option value="">--Select Scheme</option>`;

            @foreach($schemes as $scheme)
                html += `    <option value="{{$scheme->scheme_code}}">{{$scheme->scheme_name}}</option>`;
            @endforeach

                html += `  </select>
</td>
<td><input type="text" name="registration_id[]" class="form-control" /></td>
<td><input type="date" name="date[]" class="form-control" /></td>
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
