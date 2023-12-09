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
                <li>Sub Districts</li>
            </ul>
            <div class="container-fluid">
                <div class="my-5" id="b-homedb">
                </div>
                <div class="row">
                    <div class="col-md-12 p-5 table-responsive">
                        <h4>Sub Districts::</h4>
                        <div  class ="add-butt p-3"><a  href="javascript:void(0);" data-toggle="modal" data-target="#subdisadd-modal"><button type="button" class="btn btn-primary b-btn" id="addpo">ADD<i class="fa fa-plus pl-2" aria-hidden="true"></i></button></a></div>
                        <table id="state-table" class="table table-bordered text-nowrap">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Sno.</th>
                                    <th>Sub District Code</th>
                                    <th>Sub District</th>
                                    <th>District</th>
                                    <th>State</th>
                                    <th>Created On</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allsubdistrictinfo as $subdistrictinfo)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$subdistrictinfo->subdistrict_code}}</td>
                                    <td>{{$subdistrictinfo->subdistrict_name}}</td>
                                    <td>{{$subdistrictinfo->district_name}}</td>
                                    <td>{{$subdistrictinfo->state_name}}</td>
                                    <td>{{$subdistrictinfo->created_on}}</td>
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
        <!-- Sub District Add Modal -->
        <div class="modal fade" id="subdisadd-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header text-center d-block p-2 border-bottom-0 bg-dark text-light">
                    <h4 class="modal-title">ADD SUB DISTRICT</h4>
                    <button type="button" class="close position-absolute" style="right: 15px; top: 8px;" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div id="msg"></div>
                        <form action="#"  method="post" enctype = "multipart/form-data" class="w-sm-100 w-auto mx-auto">
                            @csrf
                            <div class="form-group w-100">
                                <label for="po-state">Select State*: </label>
                                <select class="form-control" id="po-state" name="po-state" required>
                                    <option  value="">--Select State--</option>
                                    @foreach($allstateinfo as $stateinfo)
                                    <option value="{{$stateinfo->state_code}}">{{$stateinfo->state_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group w-100">
                                <label for="po-district">Select District*</label>
                                <select class="form-control" id="po-district" name="po-district" required>
                                    <option  value="">--Select District--</option>
                                </select>
                            </div>
                            <div class="form-group w-100">
                                <label for="subdiscode">Sub District Code*:</label>
                                <input type="text" class="form-control" id="subdiscode" name="subdiscode" placeholder="Enter Sub District Code as per LGD" value="{{ old('subdiscode') }}" required>
                            </div>
                            <div class="form-group w-100">
                                <label for="subdisname">Sub District Name*:</label>
                                <input type="text" class="form-control" id="subdisname" name="subdisname" placeholder="Enter Sub District Name" value="{{ old('subdisname') }}" required>
                            </div>
                            <div class="d-flex justify-content-center py-4">
								        <button type="button" id="subdisaddbutt" class="btn btn-primary b-btn">ADD</button>
							</div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@include('layout.footer')
</html>