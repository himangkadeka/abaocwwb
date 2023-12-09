@include('worker.workerFormHeader')
<div class="container">
    <div class="row">
        <div class="col-md-12">


    <div class="card mt-5">
        <div class="card-body">
            <p>Dear <span class="font-weight-bold"> {{$mfb->first_name}} {{$mfb->last_name}}</span>, Your application has been submitted successfully and forwarded to Registering Officer at <span class="text-danger font-weight-bold">{{$mwf->office_name}}</span>.</p>

            <h4 class="justify-content-center">Your Application Id is: &nbsp;<span class="font-weight-bold">{{$worker->worker_id}}</span></h4>
        </div>

    </div>

        </div>
    </div>
    <div class="d-flex justify-content-center">
        <a href="{{url('/')}}" class="btn btn-outline-info mt-3 float-right margin-left"><i class="fa fa-undo" aria-hidden="true"></i>&nbsp;Return to Homepage</a>
    </div>

</div>
