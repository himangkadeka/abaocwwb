@include('layout.adminheader')
<body>
    <div class="d-flex" id="wrapper">
        @include('admin.leftmenu')
        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light dashboard-bgcolor border-bottom">
                <button class="btn b-db-color" id="menu-toggle">
                    <span style="display:none;">Menu</span>
                    <span class="fas fa-bars" style="font-size: 1.4rem"></span>
                </button>
                <button class="navbar-toggler b-dropmenubtn" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="far fa-caret-square-down" style="font-size: 30px; color: #FFF"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle b-db-color" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="fas fa-users" style="font-size: 20px; padding-right:10px;"></span>Profile
                            </a>
                            <div class="dropdown-menu dropdown-menu-right text-center b-dropmenu-db" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#">My Profile</a>
                                <a class="dropdown-item" href="#">Change Password</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#signout-modal">Sign Out</a>  
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- Breadcrumb -->
            <ul class="breadcrumb">
                <li>Master Data</li>
                <li>Districts</li>
            </ul>
            <div class="container-fluid">
                <div class="my-5" id="b-homedb">
                    <div class="row">
                        <div class="container-sm ">
                                <h4 class="text-left mb-3 b-latest-data">ADD DISTRICT</h4>
                                <form action="adddistrict" method="post" class="w-sm-50 w-auto mx-auto">
                                @csrf
                                @if(Session::has('msg'))
                    				<span class="text-success font-weight-bold">{{ Session::get('msg') }}</span>
               				    @endif
                                   @if(isset($errmsg))
                    				<span class="text-danger font-weight-bold">{{$errmsg}}</span>
               				    @endif
                                   <div class="form-group w-50">
                                        <label for="state">Select State: </label>
                                        <select class="form-control" id="state" name="state" required>
                                            <option  value="">--Select State--</option>
                                            @foreach($allstateinfo as $stateinfo)
                                            <option value="{{$stateinfo->state_code}}">{{$stateinfo->state_name}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('statecode'))
                    				        <span class="text-danger font-weight-bold">{{ $errors->first('statecode') }}</span>
               					        @endif
                                    </div>
                                    <div class="form-group w-50">
                                        <label for="district-code">District Code As per LGD: </label>
                                        <input type="text" class="form-control" id="district-code" name="districtcode" placeholder="Enter District Code as per LGD" value="{{ old('statecode') }}" required>
                                        @if ($errors->has('districtcode'))
                    				        <span class="text-danger font-weight-bold">{{ $errors->first('districtcode') }}</span>
               					        @endif
                                    </div>
                                    <div class="form-group w-50">
                                        <label for="state-name">District Name:</label>
                                        <input type="text" class="form-control" id="district-name" name="districtname" placeholder="Enter District Name" value="{{ old('statename') }}" required>
                                        @if ($errors->has('districtname'))
                    				        <span class="text-danger font-weight-bold">{{ $errors->first('districtname') }}</span>
               					        @endif
                                    </div>
                                    <div class="text-left py-4">
								        <button type="submit" class="btn btn-primary b-btn">ADD</button>
							        </div>
                                </form>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 p-5 table-responsive">
                        <h4>Districts::</h4>
                        <table id="state-table" class="table table-bordered text-nowrap">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Sno.</th>
                                    <th>District Code</th>
                                    <th>State Name</th>
                                    <th>District Name</th>
                                    <th>Created On</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($alldistrictinfo as $districtinfo)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$districtinfo->district_code}}</td>
                                    <td>{{$districtinfo->state_name}}</td>
                                    <td>{{$districtinfo->district_name}}</td>
                                    <td>{{$districtinfo->created_on}}</td>
                                    <td><span><i class="fas fa-edit" style="color: #12d3d0;"></i><i class="fas fa-solid fa-trash" style="color: #ee1b1b; padding-left:5px;"></i></span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Signup Modal -->
        <div class="modal fade" id="signout-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header text-center d-block p-5 border-bottom-0">
                        <h3 class="modal-title">Sign Out?</h3>
                        <button type="button" class="close position-absolute" style="right: 15px; top: 8px;" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <p class="text-center">Are you sure you want to Sign Out?</p>
                        <div class="text-center py-4">
                            <form action="logout" method="GET">
                                <button type="submit" class="btn btn-primary b-btn mx-2">Sign Out</button>
                                <button class="btn btn-secondary mx-3" data-dismiss="modal">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@include('layout.footer')
</html>