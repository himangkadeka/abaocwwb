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
                <li>User</li>
            </ul>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 p-5 table-responsive">                      
                        <h4>USER</h4>
                        <div  class ="add-butt p-3 "><a  href="javascript:void(0);" data-toggle="modal" data-target="#useradd-modal"><button type="button" class="btn btn-primary b-btn" id="adduser">ADD<i class="fa fa-plus pl-2" aria-hidden="true"></i></button></a></div>
                        <table id="user-table" class="table table-bordered text-nowrap">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Sno.</th>
                                    <th>User Id</th>
                                    <th>Username</th>
                                    <th>Firstname</th>
                                    <th>Lastname</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Designation</th>
                                    <th>Office</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($userdatainfo as $userdata)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$userdata->id}}</td>
                                    <td>{{$userdata->username}}</td>
                                    <td>{{$userdata->firstname}}</td>
                                    <td>{{$userdata->lastname}}</td>
                                    <td>{{$userdata->phone}}</td>
                                    <td>{{$userdata->email}}</td>
                                    <td>{{$userdata->designation}}</td>
                                    <td>{{$userdata->office_name}}</td>
                                    <td>{{$userdata->role_name}}</td>
                                    @if($userdata->status == '1')
                                    <td>Active</td>
                                    @else
                                    <td>Deactived</td>
                                    @endif
                                    @if($userdata->role_name == 'Administrator')
                                    <td><span><i class="fas fa-edit" style="color: #12d3d0;"></i></span></td>
                                    @else
                                    <td><span><i class="fas fa-edit" style="color: #12d3d0;"></i><a href="#" class="enable-user" data-toggle="modal" ><i class="fas fa-user-alt" style="color: #ee1b1b; padding-left:5px;"></i></a><a href="#" class="disable-user" data-toggle="modal" ><i class="fas fa-user-alt-slash" style="color: #ee1b1b; padding-left:5px;"></i></a></span></td>
                                    @endif
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
        <!-- Message Modal -->
        <div class="modal fade" id="msg-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header text-center d-block p-3 border-bottom-0">
                        <h4 class="modal-title"><i class="fa fa-check p-2" aria-hidden="true"></i>Message</h4>
                        <button type="button" class="close position-absolute" style="right: 15px; top: 8px;" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body" >
                        <div id="showmsg"></div>
                        <div class="d-flex justify-content-center">
                            <a  href="javascript:void(0);"><button type="button" class="btn btn-primary b-btn "onClick="window.location.reload()">OK</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="useradd-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header text-center d-block p-2 border-bottom-0 bg-dark text-light">
                    <h4 class="modal-title">ADD USER</h4>
                    <button type="button" class="close position-absolute" style="right: 15px; top: 8px;" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div id="usr-msg"></div>
                        <form action="#" method="post" enctype = "multipart/form-data" class="w-sm-100 w-auto mx-auto">
                            @csrf
                            <div class="form-group w-100">
                                <label for="office-name">Username*:</label>
                                <input type="text" class="form-control" id="user-name" name="username" placeholder="Enter User Name" value="{{ old('username') }}" required>
                            </div>
                            <div class="form-group w-100 d-flex">
                                <div class="form-group w-50 mr-2 ">
                                    <label for="pwd">Password*:</label>
                                    <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Enter Password" value="{{ old('pwd') }}" required>
                                </div>
                                <div class="form-group w-50">
                                    <label for="confpwd">Confirm Password*:</label>
                                    <input type="password" class="form-control" id="confpwd" name="confpwd" placeholder="Confirm Password" value="{{ old('confpwd') }}" required>
                                    <span id="conf-msg" class="text-danger"></span>
                                </div>
                               
                            </div>
                            <div class="form-group w-100 d-flex">
                                <div class="form-group w-50 mr-2 ">
                                    <label for="first-name">Firstname*:</label>
                                    <input type="text" class="form-control" id="first-name" name="firstname" placeholder="Enter Firstname" value="{{ old('firstname') }}" required>
                                </div>
                                <div class="form-group w-50">
                                    <label for="last-name">Lastname*:</label>
                                    <input type="text" class="form-control" id="last-name" name="lastname" placeholder="Enter Lastname" value="{{ old('lastname') }}" required>
                                </div>
                            </div>
                            <div class="form-group w-100">
                                <label for="phone">Phone No*:</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number" value="{{ old('phone') }}" required>
                            </div>
                            <div class="form-group w-100">
                                <label for="email">Email*:</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email" value="{{ old('email') }}" required>
                            </div>
                            <div class="form-group w-100">
                                <label for="desig">Select Designation*</label>
                                <select class="form-control" id="desig" name="designation" required>
                                    <option  value="">--Select Designation--</option>
                                    @foreach($alldesignationinfo as $designationinfo)
                                        <option value="{{$designationinfo->id}}">{{$designationinfo->designation}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group w-100">
                                <label for="office-name">Select Office*</label>
                                <select class="form-control" id="office-name" name="officename" required>
                                    <option  value="">--Select Office--</option>
                                    @foreach($allofficeinfo as $officeinfo)
                                        <option value="{{$officeinfo->office_id}}">{{$officeinfo->office_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group w-100">
                                <label for="role-name">Select Role*</label>
                                <select class="form-control" id="role-name" name="rolename" required>
                                    <option  value="">--Select Role--</option>
                                    @foreach($allroleinfo as $roleinfo)
                                        <option value="{{$roleinfo->id}}">{{$roleinfo->role_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-flex justify-content-center py-4">
								<button type="button" id="useraddbutt" class="btn btn-primary b-btn">ADD</button>
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