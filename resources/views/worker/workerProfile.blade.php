@include('layout.workerheader')
<body>
<div class="d-flex" id="wrapper">
@include('worker.leftmenu')
<!-- Page Content -->
    <div id="page-content-wrapper">

        <nav class="navbar navbar-expand-lg navbar-light dashboard-bgcolor border-bottom">
            <button class="btn b-db-color" id="menu-toggle">
                <span style="display:none;">Menu</span>
                <span class="fas fa-bars" style="font-size: 1.4rem"></span>
            </button>

            <!-- Online users -->
            <!--<div class="d-inline-block px-4 py-2 dropdown">
                <div class="dropdown-toggle" data-toggle="dropdown" style="cursor: pointer;">
                    <span class="fas fa-users" style="font-size: 20px;"></span>
                </div>
                <div class="dropdown-menu b-dropmenu-db">
                    <a class="dropdown-item" href="#">User action</a>
                    <a class="dropdown-item" href="#">Another user action</a>
                    <a class="dropdown-item" href="#">Another user action</a>
                    <a class="dropdown-item" href="#">Another user action</a>
                </div>
            </div>-->
            <button class="navbar-toggler b-dropmenubtn" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="far fa-caret-square-down" style="font-size: 30px; color: #FFF"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                    <!--<li class="nav-item">
                      <a class="nav-link b-db-color" href="#">Notification</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link b-db-color" href="#">Inbox</a>
                    </li>-->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle b-db-color" href="" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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

        <div class="container-fluid">
            <div class="d-flex clearfix mt-4">
                <h3 class="d-inline-block" style="font-size:32px;">User Profile</h3>
                <span class="ml-auto d-inline-block align-self-center"><button type="button" class="btn btn-primary b-btn"><span class="fas fa-download fa-sm"></span> Report</button></span>
            </div>


            <!-- Content Row -->
            <div class="row">
                <div class="col-md-12 p-sm-5">
                    <form action="" class="w-sm-50 w-auto mx-auto">

                        <div class="form-group">
                            <label for="name">First Name:</label>
                            <input type="text" class="form-control" id="name" value="{{$user->first_name}}" placeholder="Enter first name" disabled>
                        </div>

                        <div class="form-group">
                            <label for="email">Last Name:</label>
                            <input type="text" class="form-control" id="email" placeholder="Enter last name" value="{{$user->last_name}}" disabled>
                        </div>


                        <div class="form-group">
                            <label for="phone number">Phone No</label>
                            <input type="text" class="form-control" id="" value="{{$user->phone_no}}" placeholder="Enter Phone Number" disabled>
                        </div>
                        <div class="form-group">
                            <label for="phone number">Date Of Birth</label>
                            <input type="text" class="form-control" id="" value="{{$user->dob}}" disabled>
                        </div>

                        <div class="form-group">
                            <label for="phone number">Gender</label>
                            <input type="text" class="form-control" id="" value="{{$user->gender_name}}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="phone number">Gender</label>
                            <input type="text" class="form-control" id="" value="{{$user->category_name}}" disabled>
                        </div>

{{--                        <div class="form-group">--}}
{{--                            <label for="comment">Comment:</label>--}}
{{--                            <textarea class="form-control" rows="5" id="comment" style="resize: none;" placeholder="Enter your comment"></textarea>--}}
{{--                        </div>--}}

{{--                        <div class="custom-control custom-checkbox d-inline-block">--}}
{{--                            <input type="checkbox" class="custom-control-input" id="customCheck1" name="example1">--}}
{{--                            <label class="custom-control-label" for="customCheck1">Option 1</label>--}}
{{--                        </div>--}}
{{--                        <div class="custom-control custom-checkbox d-inline-block">--}}
{{--                            <input type="checkbox" class="custom-control-input" id="customCheck2" name="example2">--}}
{{--                            <label class="custom-control-label" for="customCheck2">Option 2</label>--}}
{{--                        </div>--}}
{{--                        <div class="custom-control custom-checkbox d-inline-block">--}}
{{--                            <input type="checkbox" class="custom-control-input" id="customCheck3" name="example3">--}}
{{--                            <label class="custom-control-label" for="customCheck3">Option 3</label>--}}
{{--                        </div>--}}


{{--                        <div class="form-group my-3">--}}
{{--                            <label for="search">Search:</label>--}}
{{--                            <div class="input-group">--}}
{{--                                <input type="text" class="form-control" id="search" placeholder="Search">--}}
{{--                                <div class="input-group-append">--}}
{{--                                    <button class="btn btn-primary b-btn" type="submit">Go</button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="form-group">--}}
{{--                            <label for="sel1">Select list:</label>--}}
{{--                            <select class="form-control" id="sel1">--}}
{{--                                <option>Option 1</option>--}}
{{--                                <option>Option 2</option>--}}
{{--                                <option>Option 3</option>--}}
{{--                                <option>Option 4</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}

{{--                        <fieldset>--}}
{{--                            <legend>Select Gender</legend>--}}
{{--                            <div class="form-group">--}}
{{--                                <div class="form-check">--}}
{{--                                    <label class="form-check-label" for="radio1">--}}
{{--                                        <input type="radio" id="radio1" class="form-check-input" name="optradio">Male--}}
{{--                                    </label>--}}
{{--                                </div>--}}
{{--                                <div class="form-check">--}}
{{--                                    <label class="form-check-label" for="radio2">--}}
{{--                                        <input type="radio" id="radio2" class="form-check-input" name="optradio">Female--}}
{{--                                    </label>--}}
{{--                                </div>--}}
{{--                                <div class="form-check">--}}
{{--                                    <label class="form-check-label" for="radio3">--}}
{{--                                        <input type="radio" id="radio3" class="form-check-input" name="optradio">Others--}}
{{--                                    </label>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </fieldset>--}}


{{--                        <div class="form-group">--}}
{{--                            <label for="range">Select range:</label>--}}
{{--                            <input type="range" id="range" class="form-control-range">--}}
{{--                        </div>--}}

{{--                        <div class="form-group">--}}
{{--                            <label for="upload">File upload:</label>--}}
{{--                            <input type="file" id="upload" class="form-control-file border">--}}
{{--                        </div>--}}

{{--                        <div class="form-group form-check">--}}
{{--                            <label class="form-check-label" for="rem-me">--}}
{{--                                <input class="form-check-input" id="rem-me" type="checkbox"> Remember me</label>--}}
{{--                        </div>--}}
{{--                        <button type="submit" class="btn btn-primary b-btn">Submit</button>--}}
{{--                    </form>--}}
                </div>
            </div> <!--end row-->

{{--            <div class="my-5" id="b-homedb">--}}

{{--                <div class="container">--}}
{{--                    <h4 class="text-center mb-3 b-latest-data">Progress Report</h4>--}}
{{--                    <div class="pl-4 text-right" style="font-size: 24px">--}}
{{--					<span class="mr-2" id="one-item-row" style="cursor: pointer;">--}}
{{--						<i class="fas fa-bars"></i>--}}
{{--					</span>--}}
{{--                        <span class="mr-2" id="two-item-row" style="cursor: pointer;">--}}
{{--						<i class="fas fa-th-large"></i>--}}
{{--					</span>--}}
{{--                        <span class="mr-2" id="three-item-row" style="cursor: pointer;">--}}
{{--						<i class="fas fa-th"></i>--}}
{{--					</span>--}}
{{--                    </div>--}}

{{--                    <div class="">--}}
{{--                        <div class="row text-center pl-4" id="sortable-cards">--}}
{{--                            <div class="col-lg-6 col-sm-12 p-3 b-customize">--}}
{{--                                <div class="bg-light p-4 b-dbcard">--}}
{{--                                    <i class="fas fa-users position-absolute" style="font-size:35px; right: 40px; top: 40px;"></i>--}}
{{--                                    <div class="">--}}
{{--                                        <p class="text-left font-weight-bold" style="font-size: 14px;">No. of Beneficiaries</p>--}}
{{--                                        <h3 class="text-left font-weight-bold" style="margin-top: -5px">39.04 Cr</h3>--}}
{{--                                        <div class="text-left" style="margin: 10px 0px 5px;">--}}
{{--                                            <span class="badge badge-success">+4%</span>--}}
{{--                                            <span style="font-size:13px;"> From previous period</span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="col-lg-6 col-sm-12 p-3 b-customize">--}}
{{--                                <div class="bg-light p-4 b-dbcard">--}}
{{--                                    <i class="fas fa-rupee-sign position-absolute" style="font-size:35px; right: 40px; top: 40px;"></i>--}}
{{--                                    <div class="">--}}
{{--                                        <p class="text-left font-weight-bold" style="font-size: 14px;">Total Amount Deposited</p>--}}
{{--                                        <h3 class="text-left font-weight-bold" style="margin-top: -5px">131,339.59 Cr</h3>--}}
{{--                                        <div class="text-left" style="margin: 10px 0px 5px;">--}}
{{--                                            <span class="badge badge-success">2%</span>--}}
{{--                                            <span style="font-size:13px;"> From previous period</span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="col-lg-6 col-sm-12 p-3 b-customize">--}}
{{--                                <div class="bg-light p-4 b-dbcard">--}}
{{--                                    <i class="fas fa-credit-card position-absolute" style="font-size:35px; right: 40px; top: 40px;"></i>--}}
{{--                                    <div class="">--}}
{{--                                        <p class="text-left font-weight-bold" style="font-size: 14px;">No. of Rupay Debit Cards Issued</p>--}}
{{--                                        <h3 class="text-left font-weight-bold" style="margin-top: -5px">39.46 Cr acres</h3>--}}
{{--                                        <div class="text-left" style="margin: 10px 0px 5px;">--}}
{{--                                            <span class="badge badge-success">12%</span>--}}
{{--                                            <span style="font-size:13px;"> From previous period</span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="col-lg-6 col-sm-12 p-3 b-customize">--}}
{{--                                <div class="bg-light p-4 b-dbcard">--}}
{{--                                    <i class="fas fa-hand-holding-medical position-absolute" style="font-size:35px; right: 40px; top: 40px;"></i>--}}
{{--                                    <div class="">--}}
{{--                                        <p class="text-left font-weight-bold" style="font-size: 14px;">Accidental Insurance cover</p>--}}
{{--                                        <h3 class="text-left font-weight-bold" style="margin-top: -5px">2 Lakhs</h3>--}}
{{--                                        <div class="text-left" style="margin: 10px 0px 5px;">--}}
{{--                                            <span class="badge badge-success">+100%</span>--}}
{{--                                            <span style="font-size:13px;"> From previous period</span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                        </div>--}}
{{--                    </div>--}}

{{--                </div>--}}

{{--            </div>--}}



{{--            <div class="row my-5 mx-sm-5">--}}
{{--                <div class="col-md-6">--}}
{{--                    <h4 class="text-center">Total deposits by sector (as of may 2020)</h4>--}}
{{--                    <canvas id="verticalBarChart2" width="400" height="400"></canvas>--}}
{{--                </div>--}}
{{--                <div class="col-md-6">--}}
{{--                    <h4 class="text-center">Bank Contribution (in percent)</h4>--}}
{{--                    <canvas id="doughnutChart2" width="400" height="400"></canvas>--}}
{{--                </div>--}}
{{--            </div>--}}


        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->
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
                        <form action="{{route('user-logout')}}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-primary b-btn mx-2">Sign Out</button>
                            <button class="btn btn-secondary mx-3" data-dismiss="modal">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Welcome to the dashboard!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block">

                        <strong>{!! $message !!} </strong>

                    </div>

                @endif
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>
    @if ($message = Session::get('success'))
    $(document).ready(function(){
        $('#successModal').modal({backdrop: 'static', keyboard: false}, 'show');

    });
    @endif
</script>
</body>
@include('layout.footer');
</html>
