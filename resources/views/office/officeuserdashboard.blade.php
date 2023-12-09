@include('layout.officeheader')
<body>
    <div class="d-flex" id="wrapper">
        @include('office.leftmenu')
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
            <!--<li class="nav-item">
              <a class="nav-link b-db-color" href="#">Notification</a>
            </li>
            <li class="nav-item">
              <a class="nav-link b-db-color" href="#">Inbox</a>
            </li>-->
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
        @if(session('msg'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
      <div class="container-fluid">
      	<div class="d-flex clearfix mt-4">
      		<h3 class="d-inline-block" style="font-size:32px;">Dashboard</h3>
      		<span class="ml-auto d-inline-block align-self-center"><button type="button" class="btn btn-primary b-btn"><span class="fas fa-download fa-sm"></span> Report</button></span>
      	</div>


        <!-- Content Row -->

        <div class="my-5" id="b-homedb">

			<div class="container">
				<h4 class="text-center mb-3 b-latest-data">Progress Report</h4>
				<div class="pl-4 text-right" style="font-size: 24px">
					<span class="mr-2" id="one-item-row" style="cursor: pointer;">
						<i class="fas fa-bars"></i>
					</span>
					<span class="mr-2" id="two-item-row" style="cursor: pointer;">
						<i class="fas fa-th-large"></i>
					</span>
					<span class="mr-2" id="three-item-row" style="cursor: pointer;">
						<i class="fas fa-th"></i>
					</span>
				</div>

				<div class="">
					<div class="row text-center pl-4" id="sortable-cards">
					    <div class="col-lg-6 col-sm-12 p-3 b-customize">
					        <div class="bg-light p-4 b-dbcard">
					        	<i class="fas fa-users position-absolute" style="font-size:35px; right: 40px; top: 40px;"></i>
					        	<div class="">
					        		<p class="text-left font-weight-bold" style="font-size: 14px;">Total Applications Received</p>
					        		<h3 class="text-left font-weight-bold" style="margin-top: -5px">{{ $rowCount }}</h3>
					        		<div class="text-left" style="margin: 10px 0px 5px;">
					        			<span class="badge badge-success"></span>
					        			<span style="font-size:13px;"></span>
					        		</div>
					        	</div>
					        </div>
					    </div>

					    <div class="col-lg-6 col-sm-12 p-3 b-customize">
					        <div class="bg-light p-4 b-dbcard">
					        	<i class="fas fa-rupee-sign position-absolute" style="font-size:35px; right: 40px; top: 40px;"></i>
					        	<div class="">
					        		<p class="text-left font-weight-bold" style="font-size: 14px;">Total Application Pending</p>
					        		<h3 class="text-left font-weight-bold" style="margin-top: -5px">{{ $countPending }}</h3>
					        		<div class="text-left" style="margin: 10px 0px 5px;">
					        			<span class="badge badge-success"></span>
					        			<span style="font-size:13px;"></span>
					        		</div>
					        	</div>
					        </div>
					    </div>

					    <div class="col-lg-6 col-sm-12 p-3 b-customize">
					        <div class="bg-light p-4 b-dbcard">
					        	<i class="fas fa-credit-card position-absolute" style="font-size:35px; right: 40px; top: 40px;"></i>
					        	<div class="">
					        		<p class="text-left font-weight-bold" style="font-size: 14px;">No. of Application Approved</p>
					        		<h3 class="text-left font-weight-bold" style="margin-top: -5px">{{ $countApproved }}</h3>
					        		<div class="text-left" style="margin: 10px 0px 5px;">
					        			<span class="badge badge-success"></span>
					        			<span style="font-size:13px;"></span>
					        		</div>
					        	</div>
					        </div>
					    </div>

					    <div class="col-lg-6 col-sm-12 p-3 b-customize">
					        <div class="bg-light p-4 b-dbcard">
					        	<i class="fas fa-hand-holding-medical position-absolute" style="font-size:35px; right: 40px; top: 40px;"></i>
					        	<div class="">
					        		<p class="text-left font-weight-bold" style="font-size: 14px;">Total Application Rejected</p>
					        		<h3 class="text-left font-weight-bold" style="margin-top: -5px">0</h3>
					        		<div class="text-left" style="margin: 10px 0px 5px;">
					        			<span class="badge badge-success"></span>
					        			<span style="font-size:13px;"></span>
					        		</div>
					        	</div>
					        </div>
					    </div>

					</div>
				</div>

			</div>

		</div>

<!-- show Latest Application -->
          <div class="row text-center pl-4" id="sortable-cards">
              <div class="col-lg-12 col-sm-12 p-3 b-customize">
                  <div class="bg-light p-4 b-dbcard">
{{--                      <i class="fas fa-users position-absolute" style="font-size:35px; right: 40px; top: 40px;"></i>--}}
                      <div class="">
                          <h5 class="text-left font-weight-bold"><i class="fa fa-file-text text-danger" aria-hidden="true"></i>&nbsp;New Applications Received :</h5>
{{--                          <h3 class="text-left font-weight-bold" style="margin-top: -5px">39.04 Cr</h3>--}}
{{--                          <div class="text-left" style="margin: 10px 0px 5px;">--}}
{{--                              <span class="badge badge-success">+4%</span>--}}
{{--                              <span style="font-size:13px;"> From previous period</span>--}}
{{--                          </div>--}}
                          <div class="table-responsive mt-4">
                          <table class="table table-bordered table-sm table-secondary text-sm-center">
                              <thead class="thead-dark">
                                <tr>
                                  <th >Sl.no</th>
                                  <th >Application No</th>
                                  <th >Name</th>
                                  <th >Date & time</th>
                                  <th >View Application</th>
                                </tr>
                              </thead>
                              @foreach($data as $key=> $application)
                              <tbody>
                              <tr>
                                  <td>{{$loop->iteration}}</td>
                                  <td>{{$application->worker_id}}</td>
                                  <td>{{$application->first_name}} {{$application->last_name}}</td>
                                  <td>{{$application->created_at}}</td>
                                  <td>
                                      <a href="{{route('office-applications',['id' =>$application->worker_id])}}" ><i class="fa fa-eye" aria-hidden="true"></i></a>
                                  </td>
                              </tr>
                              </tbody>
                                  @endforeach
                          </table>
                          </div>
                      </div>
                  </div>
              </div>
          </div>

        <div class="row my-5 mx-sm-5">
        	<div class="col-md-6">
        		<h4 class="text-center">Total deposits by sector (as of may 2020)</h4>
        		<canvas id="verticalBarChart2" width="400" height="400"></canvas>
        	</div>
        	<div class="col-md-6">
        		<h4 class="text-center">Bank Contribution (in percent)</h4>
        		<canvas id="doughnutChart2" width="400" height="400"></canvas>
        	</div>
        </div>


    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->
  <!-- Signup Modal -->
	<div class="modal fade" id="signout-modal" aria-hidden="true" tabindex="-1" role="dialog">
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
