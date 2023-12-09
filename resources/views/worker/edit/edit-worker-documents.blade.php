@include('worker.workerFormHeader')
<div class="container-fluid mb-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title alert-info" style="text-align: center; color: white;font-weight: bolder; padding-top: 30px;">EDIT SUPPORTING DOCUMENTS</h3>
                    @if(session('success'))
                        <h6 class="alert alert-success">
                            {{ session('success') }}
                        </h6>
                    @endif
                    @if(session('error'))
                        <h6 class="alert alert-danger">
                            {{ session('error') }}
                        </h6>
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
                        <table class="table table-active tab">
                            <thead>
                            <tr  style="background-color: #c0dbdc;">
                                <th scope="col" class="text-lg-center">Sl.No</th>
                                <th scope="col">Type Of Documents</th>
                                <th scope="col">Uploaded Files</th>
                                <th scope="col"></th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>

                                <form action="{{route('update-worker-documents')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                <th scope="row">1</th>
                                <td>@if ($twd === 1) selected @endif Aadhaar</td>
                                <td>
                                    <a href="{{ route('get-id-proof', ['id'=> mt_rand(1,1000)])}}"  class="href" target="_blank" ><i class="fa fa-external-link" aria-hidden="true"></i>&nbspVIEW PHOTO ID PROOF</a>

                                </td>
                                <td><input type="file" name="id_file"></td>
                                <input type="hidden" name="document_id" value="1">
                                <td> <input class="btn btn-sm btn-success" type="submit" value="Update">
                                </td>
                                 </form>

                            </tr>
                            <tr>
                                <form action="{{route('update-worker-documents')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                <th scope="row">2</th>
                                <td>@if ($twd === 1) selected @endif Aadhaar</td>
                                <td><a href="{{route('get-res-proof', ['id'=> mt_rand(1,1000)])}}" class="href" target="_blank" ><i class="fa fa-external-link" aria-hidden="true"></i>&nbspVIEW RESIDENTIAL PROOF</a>
{{--                                    @if(session()->has('success1'))--}}
{{--                                        <div class="alert alert-success alert-dismissible fade show" role="alert">--}}
{{--                                            {{ session()->get('success1') }}--}}
{{--                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
{{--                                                <span aria-hidden="true">&times;</span>--}}
{{--                                            </button>--}}
{{--                                        </div>--}}
{{--                                    @endif</td>--}}
                                <td><input type="file" name="res_file"></td>
                                <input type="hidden" name="document_id" value="2">
                                    <td><input class="btn btn-sm btn-success" type="submit" value="Update"></td>
                                </form>
                            </tr>
                            <tr>
                                <form action="{{route('update-worker-documents')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                <th scope="row">3</th>
                                <td>Age Proof</td>
                                <td><a href="{{route('get-age-proof', ['id'=> mt_rand(1,1000)])}}" class="href" target="_blank" ><i class="fa fa-external-link" aria-hidden="true"></i>&nbspVIEW AGE PROOF</a>
{{--                                    @if(session()->has('success2'))--}}
{{--                                        <div class="alert alert-success alert-dismissible fade show" role="alert">--}}
{{--                                            {{ session()->get('success2') }}--}}
{{--                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
{{--                                                <span aria-hidden="true">&times;</span>--}}
{{--                                            </button>--}}
{{--                                        </div>--}}
{{--                                    @endif</td>--}}
                                <td><input type="file" name="age_file"></td>
                                <input type="hidden" name="document_id" value="3">
                                <td><input class="btn btn-sm btn-success" type="submit" value="Update"></td>
                                </form>
                            </tr>
                            <tr>
                                <form action="{{route('update-worker-documents')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                <th scope="row">4</th>
                                <td>Photocopy of Bank</td>
                                <td><a href="{{route('get-bank-copy', ['id'=> mt_rand(1,1000)])}}" class="href" target="_blank"><i class="fa fa-external-link" aria-hidden="true"></i>&nbspVIEW BANK PHOTOCOPY</a></td>
                                <td><input type="file" name="bank_file"></td>
                                <input type="hidden" name="document_id" value="4">
                                <td><input class="btn btn-sm btn-success" type="submit" value="Update"></td>
                                </form>
                            </tr>
                            <tr>
                                <form action="{{route('update-worker-documents')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                <th scope="row">5</th>
                                <td>Certificate of working 90 days or more</td>
                                <td><a href="{{route('get-cert-proof', ['id'=> mt_rand(1,1000)])}}" class="href" target="_blank" ><i class="fa fa-external-link" aria-hidden="true"></i>&nbspVIEW CERTIFICATE</a></td>
                                <td><input type="file" name="certificate_file"></td>
                                <input type="hidden" name="document_id" value="5">
                                <td><input class="btn btn-sm btn-success" type="submit" value="Update"></td>
                                </form>
                            </tr>
                            <tr>
                                <form action="{{route('update-worker-documents')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                <th scope="row">6</th>
                                <td> Applicant Photo</td>
                                <td><a href="{{route('get-passport', ['id'=> mt_rand(1,1000)])}}" class="href" target="_blank"><i class="fa fa-external-link" aria-hidden="true"></i>&nbspVIEW APPLICANT PHOTO</a></td>
                                <td><input type="file" name="passport_file"></td>
                                    <input type="hidden" name="document_id" value="6">
                                <td> <input class="btn btn-sm btn-success" type="submit" value="Update"></td>
                                </form>
                            </tr>
                            <tr>
                                <form action="{{route('update-worker-documents')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                <th scope="row">7</th>
                                <td> Applicant Thumb Print</td>
                                <td><a href="{{route('get-thumb', ['id'=> mt_rand(1,1000)])}}" class="href" target="_blank"><i class="fa fa-external-link" aria-hidden="true"></i>&nbspVIEW THUMB PRINT</a></td>
                                <td><input type="file" name="thumb_file"></td>
                                    <input type="hidden" name="document_id" value="7">
                                    <td> <input class="btn btn-sm btn-success" type="submit" value="Update"></td>
                                </form>
                            </tr>
                            <tr>
                                <form action="{{route('update-worker-documents')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                <th scope="row">8</th>
                                <td> Address Proof</td>
                                <td><a href="{{route('get-address-proof', ['id'=> mt_rand(1,1000)])}}" class="href" target="_blank" ><i class="fa fa-external-link" aria-hidden="true"></i>&nbspVIEW ADDRESS PROOF</a></td>
                                <td><input type="file" name="address_file"></td>
                                <input type="hidden" name="document_id" value="8">
                                <td><input class="btn btn-sm btn-success" type="submit" value="Update"></td>
                                </form>
                            </tr>
                            <tr>
                                <form action="{{route('update-worker-documents')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                <th scope="row">9</th>
                                <td>Bank Passbook</td>
                                <td><a href="{{route('get-bank-pass', ['id'=> mt_rand(1,1000)])}}" class="href" target="_blank" ><i class="fa fa-external-link" aria-hidden="true"></i>&nbspVIEW BANK PASSBOOK</a></td>
                                <td><input type="file" name="pass_file"></td>
                                <input type="hidden" name="document_id" value="9">
                                <td><input class="btn btn-sm btn-success" type="submit" value="Update"></td>
                                </form>
                            </tr>
                            <tr>
                                <form action="{{route('update-worker-documents')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                <th scope="row">10</th>
                                <td>Declaration</td>
                                <td><a href="{{route('get-decl',['id'=> mt_rand(1,1000)])}}" class="href" target="_blank"><i class="fa fa-external-link" aria-hidden="true"></i>&nbspVIEW SELF DECLARATION</a></td>
                                <td><input type="file" name="decl_file"></td>
                                <input type="hidden" name="document_id" value="10">
                                <td><input class="btn btn-sm btn-success" type="submit" value="Update"></td>
                                </form>
                            </tr>
                            </tbody>
                        </table>
                        <a  class="btn btn-outline-info mt-3 float-right margin-left"  href='{{route('submit-document-details')}}'>
                            Go to Preview<span class="material-symbols-outlined">skip_next</span>
                        </a>
                        <a href="{{route('submit-certificate-details')}}" class="btn btn-outline-info mt-3 float-right margin-left mr-2">
                            <span class="material-symbols-outlined">skip_previous
</span>Go To Previous
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layout.footer')
